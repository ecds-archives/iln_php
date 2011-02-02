<?php

/* Configuration settings for entire site */
$in_production = false;
// set level of php error reporting -- turn off warnings when in production
if($in_production==true) {
  error_reporting(E_ERROR);	// for production
 } else {
  error_reporting(E_ERROR | E_PARSE);
 }

if($in_production==true) {
// root directory and url where the website resides
// production version
$basedir = "/home/httpd/html/beck/iln";
$server = "beck.library.emory.edu";
$base_path = "/iln";
$base_url = "http://$server$base_path/";
$port = "7080";
 } else {

$webserver = "beck.library.emory.edu";
$server = "kamina.library.emory.edu";
$base_path = "/~alice/iln";
$basedir = "/Users/alice/Sites/iln"; 
$base_url = "http://$webserver$base_path"; 
$port = "8080";
 }
// add basedir to the php include path (for header/footer files and lib directory)
//set_include_path(get_include_path() . ":" . $basedir . ":" . "$basedir/lib");


//shorthand for link to main css file
$cssfile = "web/css/schanges.css";
$csslink = "<link rel='stylesheet' type='text/css' href='$base_url/$cssfile'>";


$db = "iln";

/*exist settings*/
$exist_args = array('host'   => $server,
	      	    'port'   => $port,
		    'db'     => $db,
		    'dbtype' => "exist");

/* tamino settings  */
/*$tamino_server = "vip.library.emory.edu";
$tamino_db = "ILN";
$tamino_coll = "iln";
$link_coll = "links";
$bibl_coll = "bibliog";
*/



?>
