<?php

include_once("config.php");
include_once("taminoConnection.class.php");
include("common_functions.php");

$args = array('host' => $tamino_server,
	      'db' => $tamino_db,
	      'coll' => $tamino_coll,
	      'debug' => false);
$tamino = new taminoConnection($args);

$query = 'for $b in input()/TEI.2//div1
return <div1>
 {$b/@type}
 {$b/head}
 {$b/docDate}
 { for $c in $b/div2 return
   <div2>
     {$c/@id}
     {$c/@type}
     {$c/head}
     {$c/bibl}
     { for $d in $c/p/figure return $d}
   </div2>
}
</div1>';
/*
added this to query to test taminoConnection class
<total>{count(input()/TEI.2//div1/div2)}</total>
*/


$tamino->xquery($query);

html_head("Browse");

include("xml/head.xml");
include("xml/sidebar.xml");

print '<div class="content"> 
          <h2>Browse</h2>';
print "<hr>";
$xsl_file = "contents.xsl";
$tamino->xslTransform($xsl_file);
$tamino->printResult();

print "<hr>";
print "</div>";
   
include("xml/foot.xml");

?>

</body>
</html>
