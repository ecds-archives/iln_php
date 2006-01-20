<?php

include_once("config.php");
include_once("xmlDbConnection.class.php");
include("common_functions.php");

$args = array('host' => $tamino_server,
	      'db' => $tamino_db,
	      'coll' => $tamino_coll,
	      'debug' => false);
$xmldb = new xmlDbConnection($args);

$query = 'for $b in input()/TEI.2/:text/body/div1
sort by (@id)
let $fig := $b//figure
return <div1 type="{$b/@type}">
 {$b/head}
 {$b/docDate}
 {$fig}
</div1>';
$xsl_file = "contents.xsl";
$xsl_params = array('mode' => "figure");
$xmldb->xquery($query);


html_head("Browse - Illustrations", true);

include("xml/head.xml");
include("xml/sidebar.xml");

print '<div class="content"> 
      <h2>Illustrations</h2>';

$xmldb->xslTransform($xsl_file, $xsl_params);
$xmldb->printResult();

print '</div>';
   
include("xml/foot.xml");

print '</body>
</html>';
