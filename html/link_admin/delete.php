<?php
include_once("common_funcs.php");
include_once ("linkRecord.class.php");

html_head("Links - Delete existing link");

$url = $_GET["url"];

print '<div class="content">
<h2>Delete an existing link</h2>';

include("nav.html");

$myargs = array('host' => "vip.library.emory.edu",
		  'db' => "BECKCTR",
		  'coll' => 'iln_links',
		  'url' => $url);
$link = new LinkRecord($myargs);
$link->taminoDelete();

print 'Return to <a href="list.php">full listing</a> of all links.'; 

//include("nav.html");

print "</div></body></html>";