<?php
include_once("common_funcs.php");
include_once ("linkRecord.class.php");
link_head("Links - Process new link");

print '<div class="content">
<h2>Processing new link</h2>'; 
include("nav.html");


$url = $_GET["url"];
$id = $_GET["id"];
$title = $_GET["title"];
$description = $_GET["desc"];
$subject = $_GET["subj"];
$date = $_GET["date"];
$contributor = $_GET["contrib"];
$edit_date = $_GET["mod_date"];
$edit_contributor = $_GET["mod_contrib"];
$edit_desc = $_GET["mod_desc"];


$myargs = array('host' => "vip.library.emory.edu",
		'db' => "BECKCTR",
		'coll' => 'iln_links',
		'url' => $url,
		'id' => $id,
		'title' => $title,
		'description' => $description,
		'date' => $date,
		'contributor' => $contributor);
$newlink = new LinkRecord($myargs, $subject);
$newlink->taminoModify();
$newlink->printHTML();

?>