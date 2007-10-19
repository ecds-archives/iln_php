<?php

// pass article id as argument, for example:
// browse.php?id=iln38.1068.002
// optionally, pass search terms for highlighting; for example;
// browse.php?id=iln38.1068.002&term=lincoln  

include("config.php");
include("common_functions.php");
include_once("lib/xmlDbConnection.class.php");

$id = $_GET["id"];
$kw = $_GET["keyword"];

$exist_args{"debug"} = false;
$xmldb = new xmlDbConnection($exist_args);
//$xql = "TEI.2//div1/div2[@id='" . $id . "']"; 
 
$query = 'for $art in /TEI.2//div1/div2[@id = "' . "$id" . '"]';
if ($kw != '') {$query .= "[. |= \"$kw\"]";}
$query .= 'let $previd := $art/preceding-sibling::div2[1]
let $nextid := $art/following-sibling::div2[1]
let $issue := $art/..
return <result>
{$art}
<issueid>
{$issue/@id}
{$issue/head}
</issueid>
<siblings>
    <prev>
    {$previd/@id}
    {$previd/@type}
    {$previd/@n}
    {$previd/bibl}
</prev>
<next>
 {$nextid/@id}
 {$nextid/@type}
 {$nextid/@n}
 {$nextid/bibl}
</next>
</siblings>
</result>
';

// addition to the query for next/previous links (only in contents/browse mode, not searches) 

//use @n in nextid-previd because head is in figure element for Illustrations.

$xsl_file = "xslt/article.xsl"; 

html_head("Browse - Article", true);

include("web/xml/head.xml");
include("web/xml/sidebar.xml");
print '<div class="content">';

if ($id) {
  // run the query 
  $xmldb->xquery($query);

  // convert the terms into an array to pass to tamino functions
  //  $myterms = array($term, $term2, $term3);
  // transform xml with xslt

  // print out info about highlighted terms
  $xmldb->highlightInfo($myterms);
  // print transformed result
  $xmldb->printResult($myterms);
} else {
  print "<p class='error'>Error: No article specified!</p>";
}

print "</div>"; 
include("web/xml/foot.xml"); 
?>

</body>
</html>
