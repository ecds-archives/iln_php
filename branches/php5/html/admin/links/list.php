<?php
include_once ("../../config.php");
include_once ("linkCollection.class.php");
include_once ("common_functions.php");

html_head("Links - Full Listing");

include("xml/head.xml");
include("xml/sidebar.xml");

$sort = $_GET["sort"]; // options: title|contrib|date
// default sort
if ($sort == '') { $sort = 'title'; }
$show_edits = $_GET["show_edits"];   // options : 1 | 0
$subject = $_GET['subj'];

print '<div class="content"> 
          <h2>All Links - Full Listing</h2>';

include("nav.html");

$myargs = array('host' => $tamino_server,
		'db' => $tamino_db,
		'coll' => $link_coll,
		'limit_subject' => $subject[0],
		'sort' => $sort,
		'debug' => false);
$linkset = new LinkCollection($myargs);


print "<p align='center'>Currently sorting by <b>$sort</b>, edits are <b>" . ($show_edits ? "visible" : "hidden") . "</b>";
if ($subject[0]) {
  print ", and subject is limited to <b>$subject[0]</b>";
} 
print ".</p>";

print "<p><table border='1' align='center' cellpadding='5'><tr><td>";
$linkset->printSortOptions("list.php");
print "</td><td>";
if ($show_edits) {
  print "<a href='list.php?sort=$sort&show_edits=0&subj[]=$subject[0]'>Hide Edits</a>";
} else {
  $show_edits = 0;
  print "<a href='list.php?sort=$sort&show_edits=1&subj[]=$subject[0]'>Show Edits</a>";
}
print "</td><td>";
$linkset->printSubjectOptions("list.php?sort=$sort&show_edits=$show_edits", $subject);
print "</td></tr></table></p>";

$linkset->printRecords($show_edits);

include("nav.html");

print "</div>";
   
include("xml/foot.xml");

?>
</body>
</html>
