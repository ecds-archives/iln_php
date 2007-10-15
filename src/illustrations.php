<?php

include_once("config.php");
include_once("lib/xmlDbConnection.class.php");
include("common_functions.php");

$exist_args{"debug"} =false;
$xmldb = new xmlDbConnection($exist_args);

$query = 'for $b in /TEI.2/text/body/div1
let $fig := $b//figure
order by $b/@id
return <div1 type="{$b/@type}">
 {$b/head}
 {$b/docDate}
 {$fig}
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

print '</div>';
   
include("web/xml/foot.xml");

print '</body>
</html>';
