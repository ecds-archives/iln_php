<?php


$id = $_GET["id"];
$width = $_GET["width"];
$height = $_GET["height"];

print "<center><img src=\"http://chaucer.library.emory.edu/iln/images/ILN$id.jpg\"";
if ($width != '') {
   print " width=\"$width\" ";
}
if ($height != '') {
  print " height=\"$height\" ";
  }
print "></center>";
?>