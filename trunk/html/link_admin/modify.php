<?php
include_once("common_funcs.php");
include_once("../config.php");
include_once ("linkRecord.class.php");
include_once("../phpDOM/classes/include.php");
import("org.active-link.xml.XML");

link_head("Links - Modify Existing link");

$url = $_GET["url"];
$id = $_GET["id"];


$myargs = array('host' => $tamino_server,
		'db' => $tamino_db,
		'coll' => $link_coll,
		'id' => $id);
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
