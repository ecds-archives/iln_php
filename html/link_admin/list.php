<?php
include("../common_functions.php");
html_head("Links - Listing");

//include("xml/head.xml");
//include("xml/sidebar.xml");

$url = 'http://vip.library.emory.edu/tamino/BECKCTR/iln_links?_xquery=
declare namespace dc="http://purl.org/dc/elements/1.1/"
for $b in input()/link_collection/link_record
return $b';

$url = encode_url($url);
$xsl_file = "links.xsl";
?>

   <div class="content"> 
          <h2>Links - Full Listing</h2>


<?php

print "<hr>";

// use sablotron to transform xml
$xmlContent = file_get_contents($url);
$result = transform($xmlContent, $xsl_file); 
print $result;

print "<hr>";

?> 



  </div>
   
<?php
    //include("xml/foot.xml");
?>


</body>
</html>
