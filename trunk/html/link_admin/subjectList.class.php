<?php

include_once("../phpDOM/classes/include.php");
include_once("common_funcs.php");
import("org.active-link.xml.XML");

class subjectList {
  var $host;
  var $db;
  var $coll;
  var $subject_url;
  var $xmlContent;
  var $xml;
  var $xml_result;
  var $subjects;
  
  var $xquery;
  var $STRING;

  // constructor
  function subjectList($argArray) {
    $this->host = $argArray['host'];
    $this->db = $argArray['db'];
    $this->coll = $argArray['coll'];

    // a string to replace in xqueries that need it
    $this->STRING = 'STRING';

    // presumes that the above variables are actually set...
    $this->xquery['base'] = "http://$this->host/tamino/$this->db/$this->coll?_xquery=";
    $this->xquery['subject'] = "declare namespace dc='http://purl.org/dc/elements/1.1/'
for \$b in input()/link_collection/subject_list/dc:subject 
return \$b"; 
    $this->xquery['delete'] = "declare namespace dc=\"http://purl.org/dc/elements/1.1/\"  
update for \$b in input()/link_collection/subject_list/dc:subject
where \$b eq \"$this->STRING\"
do delete \$b";
    /* update xquery -- add a new subject to subject list */
    $this->xquery['add'] = "declare namespace dc=\"http://purl.org/dc/elements/1.1/\"  
update for \$b in input()/link_collection/subject_list
do insert <dc:subject>$this->STRING</dc:subject> into \$b";

    // initialize subject list from Tamino
    $this->taminoGetSubjects();
  }

  // get the full list of possible subjects from Tamino
  function taminoGetSubjects() {
    $url = $this->xquery['base'] . $this->xquery['subject'];
    $url =  encode_url($url);
    $this->xmlContent = file_get_contents($url);
    $this->xml = new XML($this->xmlContent);
    if (!($this->xml)) {        ## call failed
      print "Error! unable to open xml for subject list.<br>";
    }
    $this->subjects = array();
    // convert xml subjects into a php array
    $this->xml_result = $this->xml->getBranches("ino:response/xq:result");
    if ($this->xml_result) {
      // Cycle through all of the branches 
      foreach ($this->xml_result as $branch) {
	if ($val = $branch->getTagContent("dc:subject")) {
	  array_push($this->subjects, $val);
	}       
      }
    }
  }  /* end taminoGetSubjects() */

  // Delete a subject from subject list in tamino
  function taminoDelete ($subj) {
    print "<p>Deleting subject <b>$subj</b> from tamino.</p>";
    $delete_url = $this->xquery['base'] . str_replace($this->STRING, $subj, $this->xquery['delete']);
    $delete_url = encode_url($delete_url);
    $this->xmlContent = file_get_contents($delete_url);
    // check that the update succeeded
    if (strpos($xmlContent, "XQuery Update Request processed")) {
      print "<p>Successfully deleted <b>$subj</b> from the subject list.</p>";
    } // else? check if not found?
  }

  // Add a new subject to the list in tamino
  function taminoAdd ($subj) {
    $add_url = $this->xquery['base'] . str_replace($this->STRING, $subj, $this->xquery['add']);
    $add_url = encode_url($add_url);
    $this->xmlContent = file_get_contents($add_url);
    // check that the update succeeded
    if (strpos($this->xmlContent, "XQuery Update Request processed")) {
      print "<p>Successfully added <b>$subj</b> to the subject list.</p>";
     }
  }

  // check if a subject is in the list of subjects
  function isSubject ($subj) {
    return (in_array($subj, $this->subjects)) ? 1 : 0;
  }
  
  // print out all subjects as an html list 
  function printHTMLList () {
    print "<ul>";
    foreach ($this->subjects as $subj) {
      print "<li>$subj</li>";
    }
    print "</ul>";
  }

  /* Print all subjects as an html select form.
     Optionally takes an array of subjects; any subjects in the array 
     will be selected by default.
  */
  function printSelectList ($matches = NULL) { 
    $selected = '';
    print "<select name='subj[]' size='5' multiple='yes'>"; 
    foreach ($this->subjects as $subj) { 
      if (isset($matches) && (in_array($subj, $matches))) { 
	$selected = "selected='yes' ";
      }
      print "<option value='$subj' $selected>$subj</option>"; 
    } 
    print "</select>"; 
  }

  function printRemovalForm () {
    print '<form action="modify_subj.php" method="get">';
    print '<input type="hidden" name="mode" value="del">';
    $this->printSelectList();
    print '<input type="submit" value="Remove">';
    print '<input type="reset">';
    print '</form>';
  }

} /* end class subjectList */
