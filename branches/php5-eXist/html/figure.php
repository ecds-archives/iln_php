<?php

// pass figure entity as argument, for example:
// figure.php?id=v38p87

include("config.php");
include("common_functions.php");

$id = $_GET["id"];
$js = $_GET["js"]; 

if ($js == 'no') {
  //javascript disabled
  $mode = "&xslt_mode=no_js";
} else {
  $mode="";
}

html_head("Illustration");


$url = "http://$tamino_server/tamino/$tamino_db/$tamino_coll?_xql=/TEI.2//figure[@entity='" . $id ."']&_encoding=utf-8";

$xmlContent = file_get_contents($url);

$xml = new domDocument();
$xml->loadXML($xmlContent);

if (!($xml)) {        // call failed
  print "Error! unable to open xml content.<br>"; 
}  
$myxpath = new domxpath($xml);
// note: query returns a dome node list object
$n = $myxpath->query("/ino:response/xql:result/figure/head");
if ($n) { $head = $n->item(0)->textContent; }
$head = urlencode($head);
$n = $myxpath->query("/ino:response/xql:result/figure/@width");
if ($n) { $width = $n->item(0)->textContent; }
$n = $myxpath->query("/ino:response/xql:result/figure/@height");
if ($n) { $height = $n->item(0)->textContent; }

// Now, create the frameset with controller & image window
print "<frameset rows='80,*' border='0' >
 <frame noresize='true' marginwidth='0' framespacing='0' frameborder='no'
       border='0'
       marginheight='0' scrolling='no' name='control'
       src='image_viewer/controller.php?head=$head&id=$id&width=$width&height=$height' />
<frame noresize='true' marginwidth='0' framespacing='0' frameborder='no'
       border='0'
       marginheight='0'	name='image'
       src='image_viewer/image.php?id=$id&width=$width&height=$height' />
</frameset>";



?>
