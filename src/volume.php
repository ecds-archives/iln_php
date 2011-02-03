<?php

include_once("config.php");
include_once("lib/xmlDbConnection.class.php");
include("common_functions.php");

$id = $_REQUEST["id"];

$exist_args{"debug"} = false;
$xmldb = new xmlDbConnection($exist_args);

// query for all volumes 
$allquery = 'declare namespace tei="http://www.tei-c.org/ns/1.0";
for $b in /tei:TEI/tei:text/tei:body/tei:div1
order by $b/tei:head
return <div1 id="{$b/@xml:id}" type="{$b/@type}">
 {$b/tei:head}
 {$b/tei:docDate}
 <count type="article">{count($b/tei:div2)}</count>
 <count type="figure">{count($b//tei:figure)}</count>
</div1>';

//query for single volume by id
$idquery = 'declare namespace tei="http://www.tei-c.org/ns/1.0"; 
for $b in /tei:TEI/tei:text/tei:body/tei:div1
where $b/@xml:id = "' . $id  . '"
return <div1 id="{$b/@xml:id}" type="{$b/@type}">
 {$b/tei:head}
 {$b/tei:docDate}
 { for $c in $b/tei:div2 return
   <div2 id="{$c/@xml:id}" type="{$c/@type}" n="{$c/@n}">
     {$c/tei:head}
     {$c/tei:bibl}
     {for $d in $c/tei:p/tei:figure return $d}
   </div2>}
</div1>';

if (isset($id)) {
    $query = $idquery;
  } else {
    $query = $allquery;
    }
if (isset($id)) {
    $vol = "single";
    } else {
    $vol = "all";
    }


$xmldb->xquery($query);

html_head("Browse Volumes", true);
print '</head>';
include("web/xml/head.xml");
include("web/xml/sidebar.xml");


print '<div class="content">';
if (isset($id)) {
  $voltitle = $xmldb->findNode("tei:head");
  print "<h2>$voltitle</h2>";
} else {
  print '<h2>Volumes</h2>';
}
$xsl_file = "xslt/contents.xsl";
$xsl_params = array('mode' => "flat", "vol" => $vol);
$xmldb->xslTransform($xsl_file, $xsl_params);
$xmldb->printResult();

include("searchformart.php");

?> 
   
</div>
   
<?php
  include("web/xml/foot.xml");
?>


</body>
</html>
