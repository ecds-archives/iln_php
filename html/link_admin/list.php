<?php
include_once ("linkCollection.class.php");
include_once ("common_funcs.php");

link_head("Links - Full Listing");

$sort = $_GET["sort"]; // options: title|contrib|date

print '<div class="content"> 
          <h2>All Links - Full Listing</h2>';

include("nav.html");

$myargs = array('host' => "vip.library.emory.edu",
		'db' => "BECKCTR",
		'coll' => 'iln_links',
		'sort' => $sort);
$linkset = new LinkCollection($myargs);

$linkset->printSortOptions("list.php");
$linkset->printRecords();

include("nav.html");


?> 



  </div>
   
<?php
    //include("xml/foot.xml");
?>


</body>
</html>
