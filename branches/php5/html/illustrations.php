<?php


include_once("link_admin/taminoConnection.class.php");
include("common_functions.php");


$args = array('host' => "vip.library.emory.edu",
		'db' => "BECKCTR",
	      //	      'debug' => true,
		'coll' => 'ILN');
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
$rval = $tamino->xquery($query);
if ($rval) {       // tamino Error code (0 = success)
  print "<p>Error: failed to retrieve illustrations.<br>";
  print "(Tamino error code $rval)</p>";
  exit();
} 


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
