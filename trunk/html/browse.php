<?php

// pass article id as argument, for example:
// browse.php?id=iln38.1068.002
// optionally, pass search terms for highlighting; for example;
// browse.php?id=iln38.1068.002&term=lincoln  

include_once("link_admin/taminoConnection.class.php");
include("common_functions.php");
$id = $_GET["id"];
$term = $_GET["term"];
$term2 = $_GET["term2"];
$term3 = $_GET["term3"];


$args = array('host' => "vip.library.emory.edu",
		'db' => "BECKCTR",
	      //	      'debug' => true,
		'coll' => 'ILN');
$tamino = new taminoConnection($args);
$xql = "TEI.2//div1/div2[@id='" . $id . "']";
$xsl_file = "browse.xsl";


html_head("Browse - Article");

include("xml/head.xml");
include("xml/sidebar.xml");
print '<div class="content">';



if ($id) {
  // run the query
  $rval = $tamino->xql($xql);
  if ($rval) {       // tamino Error code (0 = success)
    print "<p>Error: failed to retrieve contents.<br>";
    print "(Tamino error code $rval)</p>";
    exit();
  } 

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

?>


  </div>
   
<?php
  include("xml/foot.xml");
?>


</body>
</html>
