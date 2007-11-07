<?php

include_once("config.php");
include_once("lib/xmlDbConnection.class.php");
include("common_functions.php");

$exist_args{"debug"} =false;
$xmldb = new xmlDbConnection($exist_args);

$query = 'for $b in /TEI.2/text/body/div1
order by $b/@id
return <div1 type="{$b/@type}">
 {$b/head}
 {$b/docDate}
{for $art in $b/div2[.//figure]
let $fig := $art//figure
return
<div2>
 {$art/head}
 {$art/bibl}
 {$fig}
</div2>}
</div1>';
$xsl_file = "xslt/contents.xsl";
$xsl_params = array('mode' => "figure");
$xmldb->xquery($query);


html_head("Browse - Illustrations", true);

include("web/xml/head.xml");
include("web/xml/sidebar.xml");

print '<div class="content"> 
      <h2>Illustrations</h2>';

$xmldb->xslTransform($xsl_file, $xsl_params);
$xmldb->printResult();

include("searchformill.php");
   
print '<a href="illus-subj.php"><h4>View Illustrations by Subject</h4></a>';

print '</div>';


include("web/xml/foot.xml");

print '</body>
</html>';

?>
