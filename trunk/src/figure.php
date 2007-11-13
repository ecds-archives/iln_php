<?php

// pass figure entity as argument, for example:
// figure.php?id=v38p87

include("config.php");
include_once("lib/xmlDbConnection.class.php");
include("common_functions.php");

$id = $_REQUEST["id"];
$js = $_REQUEST["js"]; 

if ($js == 'no') {
  //javascript disabled
  $mode = "&xslt_mode=no_js";
} else {
  $mode="";
}

html_head("Illustration", true);
print '</head>';
$exist_args{"debug"} = false;
$xmldb = new xmlDbConnection($exist_args);

$xquery = "/TEI.2//figure[@entity='" . $id . "']"; 

if ($id) {
  // run the query 
  $xmldb->xquery($xquery);
} else {
  print "<p class='error'>Error: No figure specified!</p>";
}

// retrieve values for head, width, & height
$head = $xmldb->findNode("head");
$head = urlencode($head);

$width = $xmldb->findNode("//figure/@width");
$height = $xmldb->findNode("//figure/@height");

//$width  = $tamino->xml->getTagAttribute("width", "ino:response/xql:result/figure");
//$height = $tamino->xml->getTagAttribute("height", "ino:response/xql:result/figure"); 


//$url = "http://vip.library.emory.edu/tamino/BECKCTR/ILN?_xql=/TEI.2//figure[@entity='" . $id ."']";

// Now, create the frameset with controller & image window
print "<frameset rows='150,*' border='0' >
 <frame noresize='true' marginwidth='0' framespacing='0' frameborder='no'
       border='0'
       marginheight='0' scrolling='no' name='control'
       src='web/image_viewer/controller.php?head=$head&id=$id&width=$width&height=$height' />
<frame noresize='true' marginwidth='0' framespacing='0' frameborder='no'
       border='0'
       marginheight='0'	name='image'
       src='web/image_viewer/image.php?id=$id&width=$width&height=$height' />
</frameset>";



?>
