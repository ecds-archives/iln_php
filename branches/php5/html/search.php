<?php

/* usage: 
   search.php?region=a&term=b&region2=c&term2=d&sort=e&max=f&op=g
   for example:

search.php?region=article&term=lincoln&sort=date&op=and&region2=title&term2=america
 
(values are as specified below)  */

include_once("link_admin/taminoConnection.class.php");
include_once("common_functions.php");
include_once("phpDOM/classes/include.php");
import("org.active-link.xml.XML");

$region = $_GET["region"]; //options: document|article|title|date|illustration
$term =  $_GET["term"];  // search string for region above
$region2 = $_GET["region2"];  // same as first region
$term2 = $_GET["term2"];
$sort = $_GET["sort"]; // options: date|type|title
$maxdisplay = $_GET["max"];
$position = $_GET["pos"];  // position (i.e, cursor)
$operator = $_GET["op"];  // and|or


$args = array('host' => "vip.library.emory.edu",
	      'db' => "BECKCTR",
	      'debug' => false,
	      'coll' => 'ILN');
$tamino = new taminoConnection($args);
$xsl    = "search.xsl";

// pass terms into xslt as parameters 
// (needed to pass along in link to browse page for highlighting)
$xsl_params = array("term"  => $term, "term2" => $term2);

$reg = '';

// set a default maxdisplay
if ($maxdisplay == '') $maxdisplay = 20;
// if no position is specified, start at 1
if ($position == '') $position = 1;

// FIXME: check if sort is set?

switch ($region) {
 case "article" : $reg = "p"; break;
 case "title"   : $reg = "head"; break;
 case "date"    : $reg = "bibl/date"; break;
   // case "illustration" : $reg = "@type='Illustration' and ."; break;
 case "illustration" : $reg = "p/figure/head"; break;
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
     //   case "illustration" : $reg2 = "@type='Illustration' and ."; break;
   case "illustration" : $reg2 = "p/figure/head"; break;
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

// construct query from pieces
//$query = "url?_xql($position,$maxdisplay)=/TEI.2//div2[$reg~='$term$addterm']sortby($_sort)";
$query = "/TEI.2//div2[$reg~='$term$addterm']sortby($_sort)";

html_head("Search Results");

include("xml/head.xml");
include("xml/sidebar.xml");

print '<div class="content"> 
          <h2>Search Results</h2>';


// run the xql query
$rval = $tamino->xql($query, $position, $maxdisplay);
if ($rval) {       // tamino Error code (0 = success)
  print "<p>Error: failed to retrieve search results.<br>";
  print "(Tamino error code $rval)</p>";
  exit();
} 
// initialize cursor values
$tamino->getCursor();

print "<center><font size='+1'>";
if ($tamino->count == 0) { print "No matches "; }
else if ($tamino->count == 1) { print "$count match "; }
else { print "$tamino->count matches "; }
print "found for $begin_hi$term$end_hi in $region ";
if ($term2) { print "$op $begin_hi2$term2$end_hi in $region2"; }
print "</font><p>"; 


## store result links in a string to print it twice (top & bottom of page)
$result_links = '';

## if there are further pages of search results, link to them.
if ($tamino->count > $maxdisplay) {
  $result_links .= '<li class="firsthoriz">More results:</li>';
  for ($i = 1; $i <= $tamino->count; $i += $maxdisplay) {
    if ($i == 1) {
      $result_links .= '<li class="firsthoriz">';
    } else { 
      $result_links .= '<li class="horiz">';
    }
    # reconstruct the url and search terms
    $url = "search.php?region=$region&term=$term&max=$maxdisplay";
    if ($term2) {
      $url .= "&term2=$term2&region2=$region2&op=$operator";
    }
    if ($sort) {
      $url .= "&sort=$sort";
    }
    # now add the key piece: the new position
    $url .= "&pos=$i";
    if ($i != $position) {
      $result_links .= "<a href='$url'>";
      // url should be based on current search url, with new position defined
    }
    $j = min($tamino->count, ($i + $maxdisplay - 1));
    ## special case-- last set only has one result
    if ($i == $j) {
      $result_links .= "$i";
    } else {
      $result_links .= "$i - $j";
    }
    if ($i != $position) {
      $result_links .= "</a>";
    }
    $result_links .= "</li>";
  }
}

print "$result_links<p>";

// Don't display sort options if there are no results
if ($tamino->count) {
  sort_options($sort);
}

print "</center>";

print "<hr>";

// use sablotron to transform xml
$tamino->xslTransform($xsl, $xsl_params);
$myterms = array($term, $term2);
$tamino->printResult($myterms);

print "<hr>";

print "<center>$result_links</center>";

?>
   
  </div>
   
<?php
  include("xml/foot.xml");

function sort_options ($current) {
  // use the global variables
  global $region, $term, $region2, $term2, $operator, $maxdisplay, $position;
  $sort_url = "search.php?region=$region&term=$term&max=$maxdisplay&pos=$position";
  if ($term2) {
    $sort_url .= "&term2=$term2&region2=$region2&op=$operator";
  }
  
  print "<li class='firsthoriz'>Currently sorting by <b>$current</b>. Sort by:</li>";
  $option = array("date" => "Date", "type" => "Type", "title" => "Title");
  $first_opt = "date";

  foreach ($option as $opt => $val) {
    if ($val == $option[$first_opt]) {
      print "<li class='firsthoriz'>";
    } else {
      print "<li class='horiz'>";
    }
    if ($opt == $current) {
      print "$val</li>";
    } else {
      print "<a href='$sort_url&sort=$opt'>$val</a></li>";
    }
  }
print "<p>";



}

?>


</body>
</html>
