<?php
include("../../config.php");
include("common_functions.php");
include_once ("linkRecord.class.php");

html_head("Links - Delete existing link");
include("xml/head.xml");
include("xml/sidebar.xml");

$id = $_GET["id"];

print '<div class="content">
<h2>Delete an existing link</h2>';

include("nav.html");

$myargs = array('host' => $tamino_server,
		  'db' => $tamino_db,
		  'coll' => $link_coll,
		  'id' => $id);
$link = new LinkRecord($myargs);
// get the record so we can display useful feedback-- i.e., what was deleted
$link->taminoGetRecord();
$link->taminoDelete();

print 'Return to <a href="list.php">full listing</a> of all links.'; 

include("nav.html");

print '</div>';
include("xml/foot.xml");
?>
</body>
</html>
