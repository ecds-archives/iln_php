<?php
include("../../config.php");
include("common_functions.php");
include("linkRecord.class.php");

html_head("Links - Modify Existing link");

include("xml/head.xml");
include("xml/sidebar.xml");

$url = $_GET["url"];
$id = $_GET["id"];

$myargs = array('host' => $tamino_server,
		'db' => $tamino_db,
		'coll' => $link_coll,
		'id' => $id,
		'debug' => false);
$link = new LinkRecord($myargs);
$link->taminoGetRecord();

print '<div class="content">
<h2>Modify an existing record</h2>';

include("nav.html");

print '<hr>';
$link->printHTMLForm("modify");

print '<hr>';

include("nav.html");

print '</div>';

?>