<?php
include("../common_functions.php");

$url = 'http://vip.library.emory.edu/tamino/BECKCTR/iln_links?_xquery=
declare namespace dc="http://purl.org/dc/elements/1.1/"
for $b in input()/link_collection/subject_list
return $b';
$url = encode_url($url);
$list_xsl = "subjlist.xsl";
$select_xsl = "subjsel.xsl";

$xmlContent = file_get_contents($url);
$result = transform($xmlContent, $list_xsl); 
print "<h2>Current subject headings</h2>";
print $result;

print "<hr><h2>Add a new subject</h2>";
print '<form action="process_subj.php" method="get"> 
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


// retransform xml into form select option list
$result = transform($xmlContent, $select_xsl); 
print "<hr><h2>Remove an existing subject</h2>";
print '<form action="process_subj.php" method="get"> 
<input type="hidden" name="mode" value="del">
<select name="subj" size="5" multiple>'; 
print $result; 
print '</select>
<input type="submit" value="Remove">
<input type="reset">
</form>
';


?>