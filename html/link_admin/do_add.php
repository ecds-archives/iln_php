<?php
include_once("common_funcs.php");
include_once ("linkRecord.class.php");
link_head("Links - Process new link");

print '<div class="content">
<h2>Processing new link</h2>'; 
include("nav.html");


$url = $_GET["url"];
$title = $_GET["title"];
$description = $_GET["desc"];
$subject = $_GET["subj"];
$date = $_GET["date"];
$contributor = $_GET["contrib"];



// check that variables are set (all fields should be set)
if (!(isset($url))||(!(isset($title)))||(!(isset($description)))
    ||(!isset($subject))||(!isset($date))||(!isset($contributor))) {
  print "<p class='error'>Error! One or more required fields were not defined.</p>";
  print "Please <a href='javascript:back()'>go back</a> and fill in those fields.";
  exit();
}


$myargs = array('host' => "vip.library.emory.edu",
		'db' => "BECKCTR",
		'coll' => 'iln_links',
		'url' => $url,
		'title' => $title,
		'description' => $description,
		'date' => $date,
		'contributor' => $contributor);
$newlink = new LinkRecord($myargs, $subject);
$newlink->taminoAdd(); 
$newlink->printHTML(); 

?>