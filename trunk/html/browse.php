<?php

// pass article id as argument, for example:
// browse.php?id=iln38.1068.002
// optionally, pass search terms for highlighting; for example;
// browse.php?id=iln38.1068.002&term=lincoln  

include("config.php");
include("common_functions.php");
include_once("xmlDbConnection.class.php");

$id = $_GET["id"];
$term = $_GET["term"];
$term2 = $_GET["term2"];
$term3 = $_GET["term3"];

$args = array('host' => $tamino_server,
	      'db' => $tamino_db,
	      'coll' => $tamino_coll,
	      'debug' => false);
$tamino = new xmlDbConnection($args);
$xql = "TEI.2//div1/div2[@id='" . $id . "']"; 
 
// addition to the query for next/previous links (only in contents/browse mode, not searches) 
$sibling_query = '<siblings> {for $b in input()/TEI.2//div1/div2 
  return <div2>  
          {$b/@id}  
          {$b/@n}  
          {$b/@type}  
          {$b/head}  
          {$b/bibl}  
         </div2> } 
</siblings>';  

$query ="for \$a in input()/TEI.2//div1/div2 where \$a/@id='$id' return <div1> {\$a}"; 
// if there is no search term, this is browse mode - use sibling query 
if (!(isset($term))) { $query .= $sibling_query; } 
$query .= "</div1>";   

$xsl_file = "browse.xsl"; 

html_head("Browse - Article");

include("xml/head.xml");
include("xml/sidebar.xml");
print '<div class="content">';

if ($id) {
  // run the query 
  $tamino->xquery($query);

  // convert the terms into an array to pass to tamino functions
  $myterms = array($term, $term2, $term3);
  // transform xml with xslt
  $tamino->xslTransform($xsl_file);
  // print out info about highlighted terms
  $tamino->highlightInfo($myterms);
  // print transformed result
  $tamino->printResult($myterms);
} else {
  print "<p class='error'>Error: No article specified!</p>";
}

print "</div>"; 
include("xml/foot.xml"); 
?>

</body>
</html>
