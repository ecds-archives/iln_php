<?php

//one possibe way to deal with messy xqueries & the urls they produce

include("iln_functions.php");

$url = 'http://tamino.library.emory.edu/passthru/servlet/transform/tamino/BECKCTR/ILN?_xquery=
for $b in input()/TEI.2//div1
let $fig := $b//figure
return <div1>
 {$b/@type}
 {$b/head}
 {$b/docDate}
 {$fig}
</div1>&_xslsrc=xsl:stylesheet/contents_ptolemy.xsl&xslt_mode=figure';

//clean up url for use
$url = encode_url($url);
?>

<html>
<head>
<title>Browse - The Civil War in America from The Illustrated London News</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="Javascript" 
	src="http://chaucer.library.emory.edu/iln/browser-css.js"></script>
<script language="Javascript" 
	src="http://chaucer.library.emory.edu/iln/content-list.js"></script>
<script language="Javascript" 
	src="http://chaucer.library.emory.edu/iln/image_viewer/launchViewer.js"></script>
<link rel="stylesheet" type="text/css" href="http://chaucer.library.emory.edu/iln/contents.css">

</head>

<?php
include("head.xml");
include("sidebar.xml");
?>

<div class="content"> 
      <h2>Illustrations</h2>


<?php
// get & display actual content
$lines = file ($url);
foreach ($lines as $l) echo "$l";
?>

  </div>
   
<?php
  include("foot.xml");
?>


</body>
</html>
