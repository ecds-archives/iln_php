<?php

include_once("common_funcs.php");
include_once("subjectList.class.php");
include_once("../phpDOM/classes/include.php");
import("org.active-link.xml.XML");

class linkRecord {

  var $host;
  var $db;
  var $coll;

  var $title;
  var $url;
  var $subject;  
  var $description;
  var $contributor;
  var $date;
  var $all_subjects;
  /* original date / date last modified ? */

  var $xquery;

  // Constructor 
  function linkRecord($argArray, $subjArray = NULL) {
    $this->host = $argArray['host'];
    $this->db = $argArray['db'];
    $this->coll = $argArray['coll'];

    $this->url = $argArray['url'];

    /* These fields may or may not be set-- 
       They may also be defined by setting url & using getRecord() */
    $this->title = $argArray['title'];
    $this->description = $argArray['description'];
    $this->contributor = $argArray['contributor'];
    $this->date = $argArray['date'];
    
    // define subjects for this record, if set
    if ($subjArray) {
      $this->subject = $subjArray;
    } else {
      $this->subject = array();
    }
    
    // pass in tamino settings to subject list
    $this->all_subjects = new subjectList($argArray);

    // xquery configuration
    $this->xquery['base'] =  "http://$this->host/tamino/$this->db/$this->coll?_xquery=";
    // xquery to retrieve a record by url
    $this->xquery['getRecord'] = "declare namespace dc='http://purl.org/dc/elements/1.1/' 
for \$b in input()/link_collection/link_record 
where \$b/dc:identifier = '$this->url' 
return \$b"; 
    // xquery to delete record by url
    $this->xquery['delete'] = "declare namespace dc=\"http://purl.org/dc/elements/1.1/\" 
update for \$b in input()/link_collection/link_record
where \$b/dc:identifier = \"$this->url\"
do delete \$b";
    // xquery to add a new record
    $this->xquery['add'] = "declare namespace dc=\"http://purl.org/dc/elements/1.1/\" 
 update for \$b in input()/link_collection 
 do insert <link_record>
  <dc:title>$this->title</dc:title>
  <dc:identifier>$this->url</dc:identifier>
  <dc:description>$this->description</dc:description>
  <dc:date>$this->date</dc:date>
  <dc:contributor>$this->contributor</dc:contributor>";
   foreach ($this->subject as $s) {
     $this->xquery['add'] .= "<dc:subject>$s</dc:subject>\n";
   }
   $this->xquery['add'] .= '</link_record> into $b';

    // xquery to modify an existing record
   $this->xquery['modify'] = "declare namespace dc=\"http://purl.org/dc/elements/1.1/\" 
update for \$b in input()/link_collection/link_record
where \$b/dc:identifier = '$this->url' 
do replace \$b with <link_record>
  <dc:title>$this->title</dc:title>
  <dc:identifier>$this->url</dc:identifier>
  <dc:description>$this->description</dc:description>
 <dc:date>$this->date</dc:date>
 <dc:contributor>$this->contributor</dc:contributor>";
   foreach ($this->subject as $s) {
     $this->xquery['modify'] .= "<dc:subject>$s</dc:subject>\n";
   }
   $this->xquery['modify'] .= '</link_record>';

  }  // end linkRecord constructor


  // retrieve a record from tamino by url & initialize object values
  function taminoGetRecord() {
    $getRecord_url = $this->xquery['base'] . $this->xquery['getRecord'];
    $getRecord_url = encode_url($getRecord_url);

   $this->xmlContent = file_get_contents($getRecord_url);
   $this->xml = new XML($this->xmlContent);
   if (!($this->xml)) {        ## call failed
     print "Error! unable to open xml content for $this->url record.<br>";
   }

   $xmlRecord = $this->xml->getBranches("ino:response/xq:result/link_record");
   if ($xmlRecord) {
     // Cycle through all of the branches (so order won't matter)
     foreach ($xmlRecord as $branch) {
       if ($val = $branch->getTagContent("dc:title")) {
	 $this->title = $val;
       } else if ($val = $branch->getTagContent("dc:description")) {
	 $this->description = $val;
       } else if ($val = $branch->getTagContent("dc:date")) {
	 $this->date = $val;
       } else if ($val = $branch->getTagContent("dc:contributor")) {
	 $this->contributor = $val;
       } else if ($val = $branch->getTagContent("dc:subject")) {
	 array_push($this->subject, $val);
       }       
     }
   } else {
     print "Error: unable to retrieve record from Tamino.";
   }
  }

  // Delete record from tamino
  function taminoDelete (){
    $delete_url = $this->xquery['base'] . $this->xquery['delete'];
    $delete_url = encode_url($delete_url);
    $xmlContent = file_get_contents($delete_url);
    if (strpos($xmlContent, "XQuery Update Request processed")) {
      print "<p>Successfully deleted record for <b>$this->url</b>.</p>";
    } else {
      print "<p>Failed to delete record for <b>$this->url</b>.</p>";
    }
  }

  // add a record to tamino
  function taminoAdd () {
    $add_url = $this->xquery['base'] . $this->xquery['add'];
    $add_url = encode_url($add_url);
    $this->xmlContent = file_get_contents($add_url);

   /* Check that the update succeeded. */
   if (strpos($this->xmlContent, "XQuery Update Request processed")) {
     print "<h3>Successfully added new record for <b>$this->url</b>.</h3>";
   } else {
     print "<h3>Failed to add new record for <b>$this->url</b>.</h3>";
   }
  }

  // update a record in tamino
  function taminoModify () {
    $modify_url = $this->xquery['base'] . $this->xquery['modify'];
    //   $disp_url = str_replace(">", "&gt;", $update_url);
    //   $disp_url = str_replace("<", "&lt;", $disp_url);
    $modify_url = encode_url($modify_url);
    $this->xmlContent = file_get_contents($modify_url);

   /* Check that the update succeeded. */
   if (strpos($this->xmlContent, "XQuery Update Request processed")) {
     print "<h3>Successfully updated record for <b>$this->url</b>.</h3>";
   } else {
     print "<h3>Failed to update record for <b>$this->url</b>.</h3>";
   }
  }

  // print all the values in a nice HTML table
  function printHTML () {
    print "<p><table border='1' width='100%'>";
    print "<tr><th width='20%'>Title:</th><td>$this->title</td></tr>";
    print "<tr><th>URL:</th><td><a href='$this->url'>$this->url</a></td></tr>";
    print "<tr><th>Subject(s):</th><td>";
    foreach ($this->subject as $s) { print "$s<br>"; }
    print "</td></tr>";
    print "<tr><th>Description:</th><td>$this->description</td></tr>";
    print "<tr><th>Contributor:</th><td>$this->contributor</td></tr>";
    print "<tr><th>Date Submitted:</th><td>$this->date</td></tr>";
    print "</table></p>";
  }

  // create an HTML form, with initial values set (if defined)
  // mode should be either add or update
  function printHTMLForm ($mode) {
    $textinput  = "input type='text' size='50'";
    $hiddeninput = "input type='hidden'";
    print "<table border='1' align='center'>";
    print "<form action='do_$mode.php' method='get'>";
    print "<tr><th>Title:</th><td><$textinput name='title' value='$this->title'></td></tr>";
    print "<tr><th>URL:</th><td>";
    if (isset($this->url)) {
      print "<$textinput name='url' value='$this->url'>";
    } else {
      print "<$textinput name='url' value='http://'>";
    }
    print "</td></tr>";
    print "<tr><th>Description</th><td><textarea cols='50' rows='4' name='desc'>$this->description</textarea></td></tr>";
    print "<tr><th>Subject(s):</th>";
    print "<td>";
    $this->all_subjects->printSelectList($this->subject);
    print "<br><i>Note: use shift or control to select more than one option.</i>";
    print "</td></tr>";
    print "<tr><th>Submitted by:</th><td>";
    // if already defined, don't allow user to modify
    if (isset($this->contributor)) {
      print "<$hiddeninput name='contrib' value='$this->contributor'>$this->contributor";
    } else {
      print "<$textinput name='contrib'>";
    }
    print "</td></tr>";
    print "<tr><th>Date Submitted:</th><td>";
    // if already defined, don't allow user to modify
    if (isset($this->date)) {
      print "<$hiddeninput name='date' value='$this->date'>$this->date";
    } else {
      /* If unset, initialize date value to today.  
         Format is: 2004-04-09 4:13 PM */
      print "<$textinput name='date' value='" . date("Y-m-d g:i A") . "'>";
    }
    print "</td></tr>";
    print "<tr><td colspan='2' align='center'>";
    print "<input type='submit' value='Submit'>";
    print "<input type='reset'>";
    print "</td></tr></form></table>";
  }

}