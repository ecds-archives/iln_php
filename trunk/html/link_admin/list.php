<?php
include_once ("linkRecord.class.php");
include_once("../phpDOM/classes/include.php");
import("org.active-link.xml.XML");
include_once ("common_funcs.php");

html_head("Links - Full Listing");


// url to retrieve all url identifiers from tamino
$url = 'http://vip.library.emory.edu/tamino/BECKCTR/iln_links?_xquery=
declare namespace dc="http://purl.org/dc/elements/1.1/"
for $b in input()/link_collection/link_record/dc:identifier
return $b';

$url = encode_url($url);

$xmlContent = file_get_contents($url);
$xml = new XML($xmlContent);
if (!($xml)) {        ## call failed
  print "Error! unable to open xml content.<br>";
}

$id_list = array();
// convert xml identifiers into a php array
$xml_result = $xml->getBranches("ino:response/xq:result");
if ($xml_result) {
  // Cycle through all of the branches 
  foreach ($xml_result as $branch) {
       if ($val = $branch->getTagContent("dc:identifier")) {
	 array_push($id_list, $val);
       }       
  }
}
?>

   <div class="content"> 
          <h2>All Links - Full Listing</h2>


<?php
include("nav.html");

$id_count = count($id_list);
$link = array();

// Create & initialize one linkRecord object for each id in tamino
for ($i = 0; $i < $id_count; $i++) {
  $myargs = array('host' => "vip.library.emory.edu",
		  'db' => "BECKCTR",
		  'coll' => 'iln_links',
		  'url' => $id_list[$i]);
  $link[$i] = new LinkRecord($myargs);
  $link[$i]->taminoGetRecord();
}
print "<hr>";

print "<table border='1' width='90%'>";
for ($i = 0; $i < count($link); $i++) {
  print "<tr><td>";
  $link[$i]->printHTMl();
  print "</td>";
  print "<td><p><a href='delete.php?url=" . $link[$i]->url . "'>Delete</a></p>";
  print "<p><a href='modify.php?url=" . $link[$i]->url . "'>Modify</a></p></td></tr>";
}
print "</table>";


print "<hr>";
include("nav.html");


?> 



  </div>
   
<?php
    //include("xml/foot.xml");
?>


</body>
</html>
