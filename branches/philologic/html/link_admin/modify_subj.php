<?php
include_once ("subjectList.class.php");
include_once ("common_funcs.php");

link_head("Links - Modify Subjects");

$myargs = array('host' => "vip.library.emory.edu",
		'db' => "BECKCTR",
		'coll' => 'iln_links');
$subject_list = new subjectList($myargs);


print '<div class="content">
<h2>Modifying Subject</h2>';
include("nav.html");
print "<hr>";


$subject = htmlentities($_GET["subj"]);
$mode = $_GET["mode"];  // add or del

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

?>