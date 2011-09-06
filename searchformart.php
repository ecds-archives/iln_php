<h2>Search Entire Text</h2>

<form name="ilnquery" action="search.php" method="get">
<table class="searchform" border="0">
<tr><th>Keyword</th><td class="input"><input type="text" size="40" name="keyword" value="<?php print $kw ?>"></td></tr>
<tr><th>Title</th><td class="input"><input type="text" size="40" name="doctitle" value="<?php print $doctitle ?>"></td></tr>
<tr><th>Article Date</th><td class="input"><input type="text" size="40" name="date" value="<?php print $date ?>"></td></tr>
<tr><td></td><td><input type="submit" value="Submit"> <input type="reset" value="Reset"></td></tr>
</table>
</form>
