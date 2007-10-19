<?php
include("common_functions.php");
include_once("config.php");
include_once("lib/xmlDbConnection.class.php");

html_head("Bibliography");

include("web/xml/head.xml");
include("web/xml/sidebar.xml");

print "<div class='content'>
  <h2>Bibliography</h2>";   
print "<hr>"; 

print transform("web/xml/bibl.xml", "xslt/bibl.xsl"); 

print "<hr>";  
print "</div>";  
include("web/xml/foot.xml"); 

?>


</body>
</html>
