<?php
include_once("common_funcs.php");
include_once ("linkRecord.class.php");

link_head("Links - Delete existing link");

$id = $_GET["id"];

print '<div class="content">
<h2>Delete an existing link</h2>';

include("nav.html");

$myargs = array('host' => "vip.library.emory.edu",
		  'db' => "BECKCTR",
		  'coll' => 'iln_links',
		  'id' => $id);
$link = new LinkRecord($myargs);
// get the record so we can display useful feedback-- i.e., what was deleted
$link->taminoGetRecord();
$link->taminoDelete();

print 'Return to <a href="list.php">full listing</a> of all links.'; 

//include("nav.html");

print "</div></body></html>";