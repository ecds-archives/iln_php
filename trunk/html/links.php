<?php
include("common_functions.php");
include_once ("link_admin/linkCollection.class.php");

html_head("Links");

include("xml/head.xml");
include("xml/sidebar.xml");

//$url = 'http://tamino.library.emory.edu/passthru/servlet/transform/tamino/BECKCTR/ILN?_xquery=
/*$url = 'http://vip.library.emory.edu/tamino/BECKCTR/iln_links?_xquery=
declare namespace dc="http://purl.org/dc/elements/1.1/"
for $b in input()/link_collection/link_record
return <link_record>
 {$b/dc:title}
 {$b/dc:description}
 {$b/dc:identifier}
</link_record>';

$url = encode_url($url);
$xsl_file = "links.xsl"; */

?>

   <div class="content"> 
          <h2>Links</h2>


<?php

print "<hr>";

// use sablotron to transform xml
/*$xmlContent = file_get_contents($url);
$result = transform($xmlContent, $xsl_file); 
print $result; */

$sort = $_GET["sort"]; // options: title|contrib|date

$args = array('host' => "vip.library.emory.edu",
	      'db' => "BECKCTR",
	      'coll' => 'iln_links',
	      'sort' => $sort);

$linkset = new LinkCollection($args);

$linkset->printSortOptions("links.php");
$linkset->printSummary();


print "<hr>";

?> 



  </div>
   
<?php
  include("xml/foot.xml");
?>


</body>
</html>
