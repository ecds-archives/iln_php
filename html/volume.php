<?php

include_once("link_admin/taminoConnection.class.php");
include("common_functions.php");

$id = $_GET["id"];

$args = array('host' => $tamino_server,
	      'db' => $tamino_db,
	      'coll' => $tamino_coll,
	      'debug' => false);
$tamino = new taminoConnection($args);

// query for all volumes 
$allquery = 'for $b in input()/TEI.2/:text/body/div1
sort by (@id)
return <div1 id="{$b/@id}" type="{$b/@type}">
 {$b/head}
 {$b/docDate}
 <count type="article">{count($b/div2)}</count>
 <count type="figure">{count($b//figure)}</count>
</div1>';

//query for single volume by id
$idquery = 'for $b in input()/TEI.2/:text/body/div1
where $b/@id = "' . $id  . '"
return <div1 id="{$b/@id}" type="{$b/@type}">
 {$b/head}
 {$b/docDate}
 { for $c in $b/div2 return
   <div2 id="{$c/@id}" type="{$c/@type}" n="{$c/@n}">
     {$c/head}
     {$c/bibl}
     {for $d in $c/p/figure return $d}
   </div2>}
</div1>';

$query = isset($id) ? $idquery : $allquery;
$vol = isset($id) ? "single" : "all";

$rval = $tamino->xquery($query);
if ($rval) {       // tamino Error code (0 = success)
  print "<p>Error: failed to retrieve contents.<br>";
  print "(Tamino error code $rval)</p>";
  exit();
} 

html_head("Browse Volumes", true);

include("xml/head.xml");
include("xml/sidebar.xml");


print '<div class="content">';
if (isset($id)) {
  $voltitle = $tamino->findNode("head");
  print "<h2>$voltitle</h2>";
} else {
  print '<h2>Volumes</h2>';
}
$xsl_file = "contents.xsl";
$xsl_params = array('mode' => "flat", "vol" => $vol);
$tamino->xslTransform($xsl_file, $xsl_params);
$tamino->printResult();
?> 
   
</div>
   
<?php
  include("xml/foot.xml");
?>


</body>
</html>
