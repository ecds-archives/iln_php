<?php

/* usage: 
   ilnsearch.php?region=a&term=b&region2=c&term2=d&sort=e&max=f&op=g
   for example:
http://beckptolemy/~rsutton/ilnsearch.php?region=article&term=lincoln&sort=date&op=and&region2=title&term2=america
 
(values are as specified below)  */

include("iln_functions.php");

// GET is visible on url, POST is not

$region = $_GET["region"]; //options: document|article|title|date|illustration
$term =  $_GET["term"];  // search string for region above
$region2 = $_GET["region2"];  // same as first region
$term2 = $_GET["term2"];
$sort = $_GET["sort"]; // options: date|type|title
$maxdisplay = $_GET["max"];
$position = $_GET["pos"];  // position (i.e, cursor)
$operator = $_GET["op"];  // and|or

//Note: pass xquery/x-query
$query = $_GET["query"];
// uncomment the single quotes
$query = str_replace("\'", "'", $query);
//$position = $_GET["position"]; 

$db_url = "http://tamino.library.emory.edu/passthru/servlet/transform/tamino/BECKCTR/ILN";
$xsl    = "_xslsrc=xsl:stylesheet/search_ptolemy.xsl";

//echo "Region is $region, region2 is $region2, and sort is $sort.<p>";

$reg = '';

// set a default maxdisplay
if ($maxdisplay == '') $maxdisplay = 20;
if ($position == '') $position = 1;
//echo "max is $maxdisplay, operator is $operator.<p>";

// FIXME: check if sort is set?

switch ($region) {
 case "article" : $reg = "p"; break;
 case "title"   : $reg = "head"; break;
 case "date"    : $reg = "bibl/date"; break;
 case "illustration" : $reg = "@type='Illustration' and ."; break;
 case "document":   // same as default
 default:          $reg = "."; break;
}

if ($term2 != '') {
  //if second term string is not defined, do nothing here  
  $reg2 = ''; 
  switch ($region2) {
   case "article" : $reg2 = "p"; break;
   case "title"   : $reg2 = "head"; break;
   case "date"    : $reg2 = "bibl/date"; break;
   case "illustration" : $reg2 = "@type='Illustration' and ."; break;
   case "document":   // same as default
   default:          $reg2 = "."; break;
  }
  // note: spaces MUST be represented as %20, or the term will fail
  $addterm = "'%20" . $operator . "%20" . $reg2 . "~='" . $term2;

  // terms to highlight on the page
  $highlight = "$term|$term2";
} else {
  $addterm = '';

  // term to highlight on the page
  $highlight = "$term";
}

$_sort = '';
switch ($sort) {
 case "date"  : $_sort ="bibl/date/@value";  break;
 case "type"  : $_sort = "@type"; break;
 case "title" : $_sort = "head"; break;
}

// if query is defined, use that
if ($query != '') {
  $newurl = "$db_url$query&$xsl";
  // add xslt_start parameter if position is defined
  if ($position != '') { $newurl .= "&xslt_start=$position"; }
} else {
  // otherwise, construct query from pieces
  $newurl = "$db_url?_xql($position,$maxdisplay)=TEI.2//div2[$reg~='$term$addterm']sortby($_sort)&$xsl";
  $baseurl = $newurl;  // save url without position
  if ($position != '') {
    $newurl .= "&xslt_start=$position";
  }
}

$newurl = encode_url($newurl);
//echo "url is<p>$newurl";

?>

<html>
<head>
<title>Search Results - The Civil War in America from The Illustrated London News</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="Javascript" 
	src="http://chaucer.library.emory.edu/iln/browser-css.js"></script>
<script language="Javascript" 
	src="http://chaucer.library.emory.edu/iln/content-list.js"></script>
<link rel="stylesheet" type="text/css" href="http://chaucer.library.emory.edu/iln/contents.css">

</head>

<?php
include("head.xml");
include("sidebar.xml");
?>

   <div class="content"> 
          <h2>Search Results</h2>
<?php
// get & display actual content
$lines = file ($newurl);
if ($highlight != '') {
  foreach ($lines as $l) echo highlight($l, $highlight);
} else {
  foreach ($lines as $l) echo $l;
}
?>
   
  </div>
   
<?php
  include("foot.xml");
?>


</body>
</html>
