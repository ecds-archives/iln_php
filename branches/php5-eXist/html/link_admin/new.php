<?php
include_once("common_funcs.php");
include_once ("linkRecord.class.php");
include_once("../phpDOM/classes/include.php");
import("org.active-link.xml.XML");


link_head("Links - Add a new link");

// needs tamino info to grab subject
$myargs = array('host' => "vip.library.emory.edu",
		'db' => "BECKCTR",
		'coll' => 'iln_links');
$link = new LinkRecord($myargs);

print '<div class="content">
<h2>Add a new record</h2>';

include("nav.html");

print '<hr>';
$link->printHTMLForm("add");

print '<hr>';

include("nav.html");

print '</div>';

?>