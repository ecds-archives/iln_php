<?php

include_once("config.php");
include_once("lib/xmlDbConnection.class.php");
include("common_functions.php");

$exist_args{"debug"} = true;
$xmldb = new xmlDbConnection($exist_args);

$query = 'for $b in /TEI.2/:text/body/div1
order by $b/@id
let $fig := $b//figure
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
