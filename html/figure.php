<?php

// pass figure entity as argument, for example:
// figure.php?id=v38p87

$id = $_GET["id"];
$js = $_GET["js"]; 

if ($js == 'no') {
  //javascript disabled
  $mode = "&xslt_mode=no_js";
} else {
  $mode="";
}

$url = "http://tamino.library.emory.edu/passthru/servlet/transform/tamino/BECKCTR/ILN?_xql=TEI.2//figure[@entity='" . $id ."']&_xslsrc=xsl:stylesheet/imgview_ptolemy.xsl" . $mode;  

//echo $url;

$lines = file ($url);

foreach ($lines as $l) echo "$l";

?>
