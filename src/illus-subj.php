<?php

include_once("config.php");
include_once("lib/xmlDbConnection.class.php");
include("common_functions.php");
$exist_args{"debug"} =true;
$xmldb = new xmlDbConnection($exist_args);

$query = 'for $b in /TEI.2/text/back/div1//interpGrp return $b';

$xsl_file = "xslt/illus-subj.xsl";

html_head("Browse - Illustrations", true);

include("web/xml/head.xml");
include("web/xml/sidebar.xml");
print '<div class="content">';


$xmldb->xquery($query);

  $xmldb->xslTransform($xsl_file);

print "</div>"; 
include("web/xml/foot.xml"); 
?>

</body>
</html>