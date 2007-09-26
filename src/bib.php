<?php
include("common_functions.php");
include_once ("lib/biblCollection.class.php");

html_head("Bibliography");

include("xml/head.xml");
include("xml/sidebar.xml");

print "<div class='content'>
  <h2>Bibliography</h2>";   
print "<hr>"; 

$sort = $_GET["sort"]; // options: title|contrib|date 
$subject = $_GET['subj'];  

$args = array('host' => $tamino_server,
	      'db' => $tamino_db, 
	      'coll' => $bibl_coll,  
	      'limit_subject' => $subject[0], 
	      'sort' => $sort,  
	      'debug' => false);  

$linkset = new biblCollection($args);  

$linkset->printSortOptions("bib.php");  
$linkset->printSubjectOptions("bib.php", $subject);  
print "<hr width='50%'>";  
$linkset->printSummary(); 

print "<hr>";  
print "</div>";  
include("xml/foot.xml"); 

?>


</body>
</html>
