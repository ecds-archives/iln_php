<?php

// pass figure entity as argument, for example:
// figure.php?id=v38p87


include_once("link_admin/taminoConnection.class.php");
include_once("phpDOM/classes/include.php");
import("org.active-link.xml.XML");
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

$args = array('host' => "vip.library.emory.edu",
	      'db' => "BECKCTR",
	      'coll' => 'ILN',
      	      'debug' => false);
$tamino = new taminoConnection($args);
$xql = "TEI.2//figure[@entity='" . $id . "']"; 

if ($id) {
  // run the query 
  $tamino->xql($xql);
} else {
  print "<p class='error'>Error: No figure specified!</p>";
}

// retrieve values for head, width, & height
$head = $tamino->findNode("head");
$head = urlencode($head);
$width  = $tamino->xml->getTagAttribute("width", "ino:response/xql:result/figure");
$height = $tamino->xml->getTagAttribute("height", "ino:response/xql:result/figure"); 


$url = "http://vip.library.emory.edu/tamino/BECKCTR/ILN?_xql=/TEI.2//figure[@entity='" . $id ."']";

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
