<?php 

include_once("phpDOM/classes/include.php");
import("org.active-link.xml.XML");

class taminoConnection {

  // connection parameters
  var $host;
  var $db;
  var $coll;

  // these variables used internally
  var $base_url;
  var $xmlContent;
  var $xml;

  function taminoConnection($argArray) {
    $this->host = $argArray['host'];
    $this->db = $argArray['db'];
    $this->coll = $argArray['coll'];

    $this->base_url = "http://$this->host/tamino/$this->db/$this->coll?";
  }

  // send an xquery to tamino & get xml result
  // returns  tamino error code (0 for success, non-zero for failure)
  function xquery ($query) {
    $myurl = $this->base_url . "_xquery=" . $this->encode_xquery($query);
    /* print "DEBUG: myurl is $myurl<br>"; */

    $this->xmlContent = file_get_contents($myurl);
    /*
    $copy = $this->xmlContent;
    $copy = str_replace(">", "&gt;", $copy);
    $copy = str_replace("<", "\n&lt;", $copy);
    print "DEBUG: xmlContent is <pre>$copy</pre>"; 
    */
    $this->xml = new XML($this->xmlContent);
   if (!($this->xml)) {        ## call failed
     print "TaminoConnection xquery Error: unable to retrieve xml content.<br>";
   }

   $error = $this->xml->getTagAttribute("ino:returnvalue", 
					"ino:response/ino:message");
   return $error;
  }

   // convert a readable xquery into a clean url for tamino
   function encode_xquery ($string) {
     // get rid of multiple white spaces
     $string = preg_replace("/\s+/", " ", $string);
     // convert spaces to their hex equivalent
     $string = str_replace(" ", "%20", $string);
     return $string;
   }



}