<?php
include("../common_functions.php");

$url = 'http://vip.library.emory.edu/tamino/BECKCTR/iln_links?_xquery=
declare namespace dc="http://purl.org/dc/elements/1.1/"
for $b in input()/link_collection/subject_list
return $b';
$url = encode_url($url);
$xsl_file = "subjsel.xsl";

$xmlContent = file_get_contents($url);
$result = transform($xmlContent, $xsl_file); 

print '<h2>Add a new link</h2>
<table border="1" align="center">
<form action="process_newlink.php" method="get"> 
  <tr><th>URL:</th> 
  <td><input type="text" size="50" name="url"></td></tr> 
  <tr><th>Title:</th> 
  <td><input type="text" size="50" name="title"></td></tr> 
  <tr><th>Description:</th> 
  <td><textarea cols="50" rows="4" name="desc"></td></tr> 
  <tr><th>Subject(s):</th> 
  <td><select name="subject" size="5" multiple> 
';

print $result;
print '</select>
  </td></tr>
<tr><td colspan="2" align="center">
<input type="submit" value="Submit">
<input type="reset">
</td></tr>

</form>

</table>


';

?>