<?php

//one possibe way to deal with messy xqueries & the urls they produce

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
}</div1>&_xslsrc=xsl:stylesheet/contents.xsl';


// get rid of multiple white spaces
$url = preg_replace("/\s+/", " ", $url);
// convert spaces to hex equivalent
$url = str_replace(" ", "%20", $url);

//$lines = file ($url);

//foreach ($lines as $l) echo "$l";
include($url);
?> 