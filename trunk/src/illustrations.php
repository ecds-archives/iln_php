<?php

include_once("config.php");
include_once("lib/xmlDbConnection.class.php");
include("common_functions.php");

$exist_args{"debug"} =true;
$xmldb = new xmlDbConnection($exist_args);

$query = "declare namespace tei='http://www.tei-c.org/ns/1.0';
declare option exist:serialize 'highlight-matches=all';"; 
$query .= 'for $b in /tei:TEI/tei:text/tei:body/tei:div1
order by $b/@id
return <div1 type="{$b/@type}">
 {$b/tei:head}
 {$b/tei:docDate}
{for $art in $b/tei:div2[.//tei:figure]
let $fig := $art//tei:figure
return
<div2>
 {$art/tei:head}
 {$art/tei:bibl}
 {$fig}
</div2>}
</div1>';
$xsl_file = "xslt/contents.xsl";
$xsl_params = array('mode' => "figure");
$xmldb->xquery($query);


html_head("Browse - Illustrations", true);
print '</tei:head>';
include("web/xml/tei:head.xml");
include("web/xml/tei:sidebar.xml");

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
