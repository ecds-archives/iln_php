<?php

include_once("config.php");
include_once("xmlDbConnection.class.php");
include("common_functions.php");

$id = $_GET["id"];

$args = array('host' => "bohr.library.emory.edu",
	      'port' => "8080",
	      'db' => "ILN",
	      //	      'coll' => $tamino_coll,
	      'dbtype' => "exist",
	      'debug' => false);
$xmldb = new xmlDbConnection($args);

// query for all volumes 
$allquery = 'for $b in //div1
order by @id
return <div1 id="{$b/@id}" type="{$b/@type}">
 {$b/head}
 {$b/docDate}
 <count type="article">{count($b/div2)}</count>
 <count type="figure">{count($b//figure)}</count>
</div1>';

//query for single volume by id
$idquery = 'for $b in //div1[@id="' . $id  . '"]
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

$xmldb->xquery($query);

html_head("Browse Volumes", true);

include("xml/head.xml");
include("xml/sidebar.xml");


print '<div class="content">';
if (isset($id)) {
  $voltitle = $xmldb->findNode("head");
  print "<h2>$voltitle</h2>";
} else {
  print '<h2>Volumes</h2>';
}
$xsl_file = "contents.xsl";
$xsl_params = array('mode' => "flat", "vol" => $vol);
$xmldb->xslTransform($xsl_file, $xsl_params);
$xmldb->printResult();
?> 
   
</div>
   
<?php
  include("xml/foot.xml");
?>


</body>
</html>
