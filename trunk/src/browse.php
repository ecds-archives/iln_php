<?php

// pass article id as argument, for example:
// browse.php?id=iln38.1068.002
// optionally, pass search terms for highlighting; for example;
// browse.php?id=iln38.1068.002&term=lincoln  

include("config.php");
include("common_functions.php");
include_once("lib/xmlDbConnection.class.php");

$id = $_GET["id"];
$term = $_GET["term"];
$term2 = $_GET["term2"];
$term3 = $_GET["term3"];

$exist_args{"debug"} = true;
$xmldb = new xmlDbConnection($exist_args);
$xql = "TEI.2//div1/div2[@id='" . $id . "']"; 
 
// addition to the query for next/previous links (only in contents/browse mode, not searches) 
$sibling_query = '<siblings> {for $b in /TEI.2//div1/div2 
  return <div2>  
          {$b/@id}  
          {$b/@n}  
          {$b/@type}  
          {$b/head}  
          {$b/bibl}  
         </div2> } 
</siblings>';  

$query ="for \$a in /TEI.2//div1/div2 where \$a/@id='$id' return <div1> {\$a}"; 
// if there is no search term, this is browse mode - use sibling query 
if (!(isset($term))) { $query .= $sibling_query; } 
$query .= "</div1>";   

$xsl_file = "xslt/browse.xsl"; 

html_head("Browse - Article");

include("web/xml/head.xml");
include("web/xml/sidebar.xml");
print '<div class="content">';

if ($id) {
  // run the query 
  $xmldb->xquery($query);

  // convert the terms into an array to pass to tamino functions
  $myterms = array($term, $term2, $term3);
  // transform xml with xslt
  $xmldb->xslTransform($xsl_file);
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
