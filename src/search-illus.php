<?php

include_once("config.php");
include_once("lib/xmlDbConnection.class.php");
include_once("common_functions.php");


$exist_args{"debug"} = false;
$xmldb = new xmlDbConnection($exist_args);
$xsl    = "xslt/iln-exist-search.xsl";

$subj = $_REQUEST["subj"];
$kw = $_REQUEST["keyword"];
$date = $_REQUEST["date"];

$pos = $_REQUEST["position"];
$max = $_REQUEST["max"];

if ($pos == '') $pos = 1;
if ($max == '') $max = 20;



$options = array();
if ($kw)
  array_push($options, "ft:query(., '$kw')");
if ($subj)
 array_push($options, "ft:query(./@ana, '$subj')");

// there must be at least one search parameter for this to work
if (count($options)) {
  $searchfilter = "[" . implode(" and ", $options) . "]"; 
  // print("DEBUG: Searchfilter is $searchfilter\n");

if ($date)
  $searchfilter2 = "[ft:query(tei:bibl/tei:date, '$date' or tei:bibl/tei:date/@when, '$date')]";


// construct xquery
//$declare = 'declare namespace xs="http://www.w3.org/2001/XMLSchema"; '; //Don't need?
 $xquery = "declare namespace tei='http://www.tei-c.org/ns/1.0';
declare option exist:serialize 'highlight-matches=all';";
$xquery .= "for \$a in /tei:TEI//tei:div2$searchfilter2//tei:figure$searchfilter
let \$matchcount := ft:score(\$a)
let \$div2 := \$a/ancestor::tei:div2
return <div2>
{\$div2/@xml:id}
{\$div2/@type}
{\$div2/tei:head}
{\$div2/tei:bibl}
{\$a}";
if ($kw || $subj)
  $xquery .= "<hits>{\$matchcount}</hits>";
$xquery .= "</div2>";
 }
html_head("Search Results");

include("web/xml/head.xml");
include("web/xml/sidebar.xml");

print '<div class="content"> 
          <h2>Search Results</h2>';


// only execute the query if there are search terms
if (count($options)) {
// run the query
$xmldb->xquery($xquery, $pos, $max); 


  print "<p><b>Search results for texts where:</b></p>
 <ul class='searchopts'>";
  if ($kw)
    print "<li>illustration contains keyword(s) '$kw'</li>";
  if ($subj)
    print "<li>subject matches '$subj'</li>";
  if ($date)
    print "<li>illustration date matches '$date'</li>";
  
  print "</ul>";
  
  if ($xmldb->count == 0) {
    print "<p><b>No matches found.</b>
You may want to broaden your search or consult the search tips for suggestions.</p>\n";
    include("searchform.php");
  }
  $xsl_params = array ('mode' => "search-illus", 'keyword' => $kw, 'date' => $date,  'type' => "illustration", 'max' => $max);
  $xmldb->xslTransform($xsl, $xsl_params);
  $xmldb->printResult();
  
} else {
  // no search terms - handle gracefully  
  print "<p><b>Error!</b> No search terms were specified.</p>";
}

print "<hr>";  
print "</div>";  
include("web/xml/foot.xml"); 

?>


</body>
</html>
