<?php

include_once("config.php");
include_once("lib/xmlDbConnection.class.php");
include("common_functions.php");
$exist_args{"debug"} = true;
$xmldb = new xmlDbConnection($exist_args);

$query = "declare namespace tei='http://www.tei-c.org/ns/1.0';
declare option exist:serialize 'highlight-matches=all';"; 
$query .= 'for $b in /tei:TEI/tei:text/tei:back/tei:div1//tei:interpGrp return $b';

$xsl_file = "xslt/illus-subj.xsl";

html_head("Browse - Illustrations", true);
print '</head>';
include("web/xml/head.xml");
include("web/xml/sidebar.xml");
print '<div class="content">';
print '<h2>Illustrations by Subject</h2>';

$xmldb->xquery($query);

$xmldb->xslTransform($xsl_file);
$xmldb->printResult();

print "</div>"; 
include("web/xml/foot.xml"); 
?>

</body>
</html>