<?php

include_once("config.php");
include_once("xmlDbConnection.class.php");
include("common_functions.php");

$args = array('host' => "bohr.library.emory.edu",
	      'port' => "8080",
	      'db' => "ILN",
	      //	      'coll' => $tamino_coll,
	      'dbtype' => "exist",
	      'debug' => false);
$xmldb = new xmlDbConnection($args);

$query = 'for $vol in //div1
let $fig := $vol//figure
order by $vol/@id
return <div1 type="{$vol/@type}">{$vol/head}{$vol/docDate}{$fig}</div1>';

$tamino_query = 'for $b in input()/TEI.2//div1
let $fig := $b//figure
return <div1>
 {$b/@type}
 {$b/head}
 {$b/docDate}
 {$fig}
</div1>';
$xsl_file = "contents.xsl";
$xsl_params = array('mode' => "figure");
$xmldb->xquery($query);

html_head("Browse - Illustrations");

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
