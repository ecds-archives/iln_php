<?php
include("../../config.php");
include("common_functions.php");
include("subjectList.class.php");

html_head("Links - Manage Subjects");
include("xml/head.xml");
include("xml/sidebar.xml");

$myargs = array('host' => $tamino_server,
		'db' => $tamino_db,
		'coll' => $link_coll,
		'debug' => false);
$subjects = new subjectList($myargs);

print '<div class="content">
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

print "</div>";
include("xml/foot.xml");
?>
</body>
</html>