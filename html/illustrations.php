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
let $fig := $b//figure
return <div1>
 {$b/@type}
 {$b/head}
 {$b/docDate}
 {$fig}
</div1>';
$xsl_file = "contents.xsl";
$xsl_params = array('mode' => "figure");
$tamino->xquery($query);

html_head("Browse - Illustrations");

include("xml/head.xml");
include("xml/sidebar.xml");

print '<div class="content"> 
      <h2>Illustrations</h2>';

$tamino->xslTransform($xsl_file, $xsl_params);
$tamino->printResult();

print '</div>';
   
include("xml/foot.xml");

print '</body>
</html>';
