<?php
include_once("common_funcs.php");
include_once ("linkRecord.class.php");
include_once("../phpDOM/classes/include.php");
import("org.active-link.xml.XML");


html_head("Links - Modify Existing link");

$url = $_GET["url"];


$myargs = array('host' => "vip.library.emory.edu",
		  'db' => "BECKCTR",
		  'coll' => 'iln_links',
		  'url' => $url);
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