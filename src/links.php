<?php
include("common_functions.php");
include_once("config.php");
include_once("lib/xmlDbConnection.class.php");


html_head("Links");

include("web/xml/head.xml");
include("web/xml/sidebar.xml");


print '<div class="content"> 
      <h2>Links</h2>';
print "<hr>"; 

print transform("web/xml/links.xml", "xslt/links.xsl"); 

print "<hr>";  
print "</div>";  
include("web/xml/foot.xml"); 
?>
</body>
</html>

