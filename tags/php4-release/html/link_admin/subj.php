<?php
include_once ("subjectList.class.php");
include_once ("common_funcs.php");

link_head("Links - Manage Subjects");

$myargs = array('host' => "vip.library.emory.edu",
		'db' => "BECKCTR",
		'coll' => 'iln_links');
$subjects = new subjectList($myargs);

print '<div class="contents">
<h2>Manage Subjects</h2>';
include("nav.html");
print "<hr>";
print "<h3>Current subject headings</h3>";
$subjects->printHTMLList();

print '<hr><h3>Add a new subject</h3>
<form action="modify_subj.php" method="get"> 
<input type="hidden" name="mode" value="add">
<table>
 <tr>
  <th>Subject:</th>
  <td><input type="text" size="50" name="subj"></td>
  <td><input type="submit" value="Submit"></td>
  <td><input type="reset"></td>
 </tr>
</table>
</form>
';

print "<hr><h3>Remove an existing subject</h3>";
$subjects->printRemovalForm();

?>