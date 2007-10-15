<?php

include_once("config.php");
include_once("lib/xmlDbConnection.class.php");
include_once("common_functions.php");


$exist_args{"debug"} =  false;
$xmldb = new xmlDbConnection($exist_args);
$xsl    = "xslt/iln-exist-search.xsl";

$kw = $_REQUEST["keyword"];
$doctitle = $_REQUEST["doctitle"];
$date = $_REQUEST["date"];

$pos = $_REQUEST["position"];
$max = $_REQUEST["max"];

if ($pos == '') $pos = 1;
if ($max == '') $max = 20;



$options = array();
if ($kw) 
  array_push($options, ". &= '$kw' and ./@type=\"Article\"");
if ($doctitle)
  array_push($options, "head &= '$doctitle' and ./@type=\"Article\"");
if ($date)
  array_push($options, "(bibl/date &= '$date' or bibl/date/@value &= '$date') and ./@type=\"Article\"");


// there must be at least one search parameter for this to work
if (count($options)) {
  $searchfilter = "[" . implode(" and ", $options) . "]"; 
  print("DEBUG: Searchfilter is $searchfilter\n");

// construct xquery
//$declare = 'declare namespace xs="http://www.w3.org/2001/XMLSchema"; '; //Don't need?
$xquery = "for \$a in /TEI.2/text/body/div1/div2$searchfilter
let \$matchcount := text:match-count(\$a)
order by \$matchcount descending
return <div2>
{\$a/@id}
{\$a/@type}
{\$a/head}
{\$a/bibl}";
if ($kw)
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
    print "<li>document contains keyword(s) '$kw'</li>";
  if ($doctitle)
    print "<li>title matches '$doctitle'</li>";
  if ($date)
    print "<li>date matches '$date'</li>";
 
  print "</ul>";
  
  if ($xmldb->count == 0) {
    print "<p><b>No matches found.</b>
You may want to broaden your search or consult the search tips for suggestions.</p>\n";
    include("searchform.php");
  }

  $xsl_params = array ('mode' => "search", 'keyword' => $kw, 'doctitle' => $doctitle, 'date' => $date, 'type' => "article", 'max' => $max);
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
