<?php

include_once("config.php");
include_once("lib/xmlDbConnection.class.php");
include("common_functions.php");
$exist_args{"debug"} = false;
$xmldb = new xmlDbConnection($exist_args);
$xsl="xslt/illus-list.xsl";

$id = $_REQUEST["id"];
$pos = $_REQUEST["position"];
$max = $_REQUEST["max"];

if ($pos == '') $pos = 1;
if ($max == '') $max = 20;

$query = "for \$fig in /TEI.2/text/body//div2//figure[@ana &= '$id']
let \$a:= \$fig/ancestor::div2
return
<div2>
{\$a/@id}
{\$a/@type}
{\$a/head}
{\$a/bibl}
<figure>{\$fig/@entity}{\$fig/head}</figure>
</div2>";

html_head("Illustrations by Subject");
print '</head>';

include("web/xml/head.xml");
include("web/xml/sidebar.xml");
print '<div class="content">';
print '<h2> Illustrations by Subject</h2>';

$xmldb->xquery($query, $pos, $max);
$xsl_params = array ('mode' => "illus-list", 'id' => $id, 'type' => "illustration",  'max' => $max);
$xmldb->xslTransform($xsl, $xsl_params);
$xmldb->printResult();


print "<hr>";  

print '<p><a href="illus-subj.php"><h4>Return to Illustrations by Subject</h4></a></p>';

include("searchformill.php");
print "</div>";  
include("web/xml/foot.xml"); 
?>
