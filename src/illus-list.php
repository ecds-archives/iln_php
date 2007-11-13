<?php

include_once("config.php");
include_once("lib/xmlDbConnection.class.php");
include("common_functions.php");
$exist_args{"debug"} = false;
$xmldb = new xmlDbConnection($exist_args);
$xsl="xslt/illus-list.xsl";


$id = $_REQUEST["id"];

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

$xmldb->xquery($query);
$xmldb->xslTransform($xsl);
$xmldb->printResult();

print "<hr>";  
include("searchformill.php");
print "</div>";  
include("web/xml/foot.xml"); 
?>
