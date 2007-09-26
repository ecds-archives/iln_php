<?php


$id = $_GET["id"];
$width = $_GET["width"];
$height = $_GET["height"];

print "<center><img src=\"http://beck.library.emory.edu/iln/image-content/ILN$id.jpg\"";
if ($width != '') {
   print " width=\"$width\" ";
}
if ($height != '') {
  print " height=\"$height\" ";
  }
print "></center>";
?>
