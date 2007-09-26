<?php

/* Configuration settings for entire site */

// set level of php error reporting -- turn off warnings when in production
error_reporting(E_ERROR | E_PARSE);


// root directory and url where the website resides
$server = "reagan.library.emory.edu";
$base_path = "/rebecca/ilnweb";
$basedir = "/home/httpd/html$base_path"; 
$base_url = "http://$server$base_path"; 

// add basedir to the php include path (for header/footer files and lib directory)
//set_include_path(get_include_path() . ":" . $basedir . ":" . "$basedir/lib");

/* tamino settings  */
$tamino_server = "vip.library.emory.edu";
$tamino_db = "ILN";
$tamino_coll = "iln";
$link_coll = "links";
$bibl_coll = "bibliog";

?>
