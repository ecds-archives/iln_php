<?php

// php functions used by more than one ILN php page

// convert a readable xquery into a clean url
function encode_url ($string) {
  // get rid of multiple white spaces
  $string = preg_replace("/\s+/", " ", $string);
  // convert spaces to hex equivalent
  $string = str_replace(" ", "%20", $string);
  return $string;
}


// highlight the search strings in the text
function highlight ($string, $match) {
  // note: need to fix regexps: * -> \w* (any word character)
  //$match = "Linc\w*|Presiden\w*";
  $_match = str_replace("*", "\w*", $match);
  $begin_hi = "<font color='red'><b>";
  $end_hi = "</b></font>";
  // Note: don't match/highlight the terms in a url (to pass to next file)
  $string = preg_replace("/([^=|']\b)($_match)(\b)/i", "$1$begin_hi$2$end_hi$3", $string);
  return $string;
}

?>