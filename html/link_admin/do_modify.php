<?php
include_once("common_funcs.php");
include_once ("linkRecord.class.php");
link_head("Links - Process new link");

print '<div class="content">
<h2>Processing new link</h2>'; 
include("nav.html");


$url = htmlentities($_GET["url"]);
$id = htmlentities($_GET["id"]);
$title = htmlentities($_GET["title"]);
$description = htmlentities($_GET["desc"]);
$subject = $_GET["subj"];
$date = htmlentities($_GET["date"]);
$contributor = htmlentities($_GET["contrib"]);
$edit_date = htmlentities($_GET["mod_date"]);
$edit_contributor = htmlentities($_GET["mod_contrib"]);
$edit_desc = htmlentities($_GET["mod_desc"]);



$myargs = array('host' => "vip.library.emory.edu",
		'db' => "BECKCTR",
		'coll' => 'iln_links',
		'url' => $url,
		'id' => $id,
		'title' => $title,
		'description' => $description,
		'date' => $date,
		//		'debug' => true,
		'contributor' => $contributor);
$newlink = new LinkRecord($myargs, $subject);



// old editing information is submitted via hidden inputs
// get any old edits & add to linkRecord so they are not lost
$edit_count = count($_GET['prev_date']);
$prev_date = $_GET['prev_date'];
$prev_contrib = $_GET['prev_contrib'];
$prev_desc = $_GET['prev_desc'];
for ($i = 0; $i < $edit_count; $i++) {
  $prev_edit = array( "date" => $prev_date[$i], 
	 	      "contributor" => $prev_contrib[$i], 
		      "description" => $prev_desc[$i]); 
  $newlink->addEdit($prev_edit); 
}

$edit_array = array( "date" => $edit_date,
		     "contributor" => $edit_contributor,
		     "description" => $edit_desc);


$newlink->addEdit($edit_array);
$newlink->taminoModify();
$newlink->printHTML();

?>