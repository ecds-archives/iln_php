<?php
include("../../config.php");
include("common_functions.php");
include("subjectList.class.php");

html_head("Links - Modify Subjects");
include("xml/head.xml");
include("xml/sidebar.xml");

$myargs = array('host' => $tamino_server,
		'db' => $tamino_db,
		'coll' => $link_coll,
		'debug' => false);
$subject_list = new subjectList($myargs);

print '<div class="content">
<h2>Modifying Subject</h2>';
include("nav.html");
print "<hr>";

$subject = $_GET["subj"];
$mode = $_GET["mode"];  // add or del
if ($mode == "add")  { $subject = htmlentities($subject); }

switch ($mode):
  case 'add':  
  // Only add the subject if it is not already in the list
    if ( $subject_list->isSubject($subject)) {
      print "<p>Error: Subject <b>$subject</b> is already in the list.  Not adding.</p>";
    } else {
      $subject_list->taminoAdd($subject); 
    }
    break;
  case 'del':  
   // it is possible to have multiple subjects selected for deletion
    foreach ($subject as $s) {
      $subject_list->taminoDelete($s); 
    }
    break;
endswitch;

// update subject list from Tamino
$subject_list->taminoGetSubjects();
print "<hr><h2>Newly updated subject heading list</h2>\n";
$subject_list->printHTMLList();

print "</div>";
include("xml/foot.xml");
?>
</body>
</html>