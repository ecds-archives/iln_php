<?php

//one possibe way to deal with messy xqueries & the urls they produce

include("iln_functions.php");
$url = 'http://tamino.library.emory.edu/passthru/servlet/transform/tamino/BECKCTR/ILN?_xquery=
for $b in input()/TEI.2//div1
return <div1>
 {$b/@type}
 {$b/head}
 {$b/docDate}
 { for $c in $b/div2 return
   <div2>
     {$c/@id}
     {$c/@type}
     {$c/head}
     {$c/bibl}
     { for $d in $c/p/figure return $d}
   </div2>
}</div1>&_xslsrc=xsl:stylesheet/contents_ptolemy.xsl';

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
<link rel="stylesheet" type="text/css" href="http://chaucer.library.emory.edu/iln/contents.css">

</head>

<?php
include("head.xml");
include("sidebar.xml");
?>

   <div class="content"> 
          <h2>Browse</h2>

<?php
   // now get actual contents
$lines = file ($url);
foreach ($lines as $l) echo "$l";
?> 
   
  </div>
   
<?php
  include("foot.xml");
?>


</body>
</html>
