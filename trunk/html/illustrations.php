<?php

//one possibe way to deal with messy xqueries & the urls they produce

include("common_functions.php");

//$url = 'http://tamino.library.emory.edu/passthru/servlet/transform/tamino/BECKCTR/ILN?_xquery=
$url = 'http://tamino.library.emory.edu/tamino/BECKCTR/ILN?_xquery=
for $b in input()/TEI.2//div1
let $fig := $b//figure
return <div1>
 {$b/@type}
 {$b/head}
 {$b/docDate}
 {$fig}
</div1>';

//&_xslsrc=xsl:stylesheet/contents_ptolemy.xsl&xslt_mode=figure';

//clean up url for use
$url = encode_url($url);
$xsl_file = "contents.xsl";
$params = array('mode' => "figure");

html_head("Browse - Illustrations");

include("xml/head.xml");
include("xml/sidebar.xml");
?>

<div class="content"> 
      <h2>Illustrations</h2>


<?php

    // use sablotron to transform xml
   $xmlContent = file_get_contents($url);
$result = transform($xmlContent, $xsl_file, $params); 
   print $result;

// old code
   // now get actual contents
//$lines = file ($url);
//foreach ($lines as $l) echo "$l";


// get & display actual content
//$lines = file ($url);
//foreach ($lines as $l) echo "$l";
?>

  </div>
   
<?php
  include("xml/foot.xml");
?>


</body>
</html>
