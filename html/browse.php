<?php

// pass article id as argument, for example:
// browse.php?id=iln38.1068.002
// optionally, pass search terms for highlighting; for example;
// browse.php?id=iln38.1068.002&match=lincoln  (for two terms: match=lincoln|america)

include("iln_functions.php");
$id = $_GET["id"];
$match = $_GET["match"];


$url = "http://tamino.library.emory.edu/passthru/servlet/transform/tamino/BECKCTR/ILN?_xql=TEI.2//div1/div2[@id='" . $id . "']&_xslsrc=xsl:stylesheet/browse_ptolemy.xsl";
?>



<html>
<head>
<title>Browse - The Civil War in America from The Illustrated London News</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="Javascript" 
	src="http://chaucer.library.emory.edu/iln/browser-css.js"></script>
<script language="Javascript" 
	src="http://chaucer.library.emory.edu/iln/content-list.js"></script>
<link rel="stylesheet" type="text/css" href="http://chaucer.library.emory.edu/iln/contents.css">

</head>

<?php
include("head.xml");
include("sidebar.xml");
?>

   <div class="content"> 


<?php
$lines = file ($url);
if ($match != '') {
  foreach ($lines as $l) echo highlight($l, $match);
} else {
  foreach ($lines as $l) echo $l;
}
?>


  </div>
   
<?php
  include("foot.xml");
?>


</body>
</html>
