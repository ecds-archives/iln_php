<html>
<head>
<title>Search - The Civil War in America from The Illustrated London News</title>
<meta http-equiv="Content-Type" content="text/html;
      charset=iso-8859-1">
<script language="Javascript" 
	src="http://chaucer.library.emory.edu/iln/browser-css.js"></script> 
<!-- <LINK REL="STYLESHEET" TYPE="text/css" HREF="iln.css" />   -->

</head>

<body>

<?php
include("xml/head.xml");
include("xml/sidebar.xml");
?>

<div class="content">
<table><tr>
  <td>Search for:</td>
  <td>in:</td>
  </tr>
<tr>
<form name="ilnquery" 
      action="search.php" method="get">
<td><input type="text" size="30" name="term"></td>
<td>
<select name="region">
<!-- FIXME: is this a useful option? -->
  <option selected value="document">Entire Document</option> 
  <option value="article">Article </option>
  <option value="title">Article title</option>
  <option value="date">Date</option>
  <option value="illustration">Illustrations</option>
</select> 
</td>
<td>
 <select name="op">
   <option value="and">and</option>
   <option value="or">or</option>
 </select>
</td>
<tr>
<tr>
<td><input type="text" size="30" name="term2"></td>
<td>
<select name="region2">
  <option selected value="document">Entire Document</option> 
  <option value="article">Article </option>
  <option value="title">Article title</option>
  <option value="date">Date</option>
  <option value="illustration">Illustrations</option>
</select> 
</td>

</table>

<table cellspacing="8" border=0>
<tr><td>Sort by:</td>
<td>
  <input type="radio" name="sort" value="match" checked> Number of Matches</td>
<td>
  <input type="radio" name="sort" value="date" checked> Date</td>
<td>
  <input type="radio" name="sort" value="type"> Article Type</td>
<td> 
  <input type="radio" name="sort" value="title"> Title</td>
</tr></table>

<p align="left">
Results to display per page:
<select name="max">
  <option value="10">10</option>
  <option selected value="20">20</option>
  <option value="50">50</option>
  <option value="100">100</option>
</select>
</p>

<p align="left">
<input type="submit" value="Submit">
<input type="reset" value="Reset">
</p>

</form>
</table>

<hr width="60%" align="left">

<p><h4>Search tips:</h4>
<ul>
<li>Searches are <i>not</i> case-sensitive.</li>
<li>Search terms are matched against <i>whole words</i>.<br>
  For example, searching for
<b>america</b> will not match <b>american</b>.</li>

<li>To match part of a word, add an asterisk.<br>
For example, enter <b>resign*</b> to match <b>resign</b>, <b>resigned</b>, and
<b>resignation</b>.</li>
<li>Multiple words are allowed.<br>
For example, enter <b>South Carolina</b> or <b>far from
satisfactory</b> to match those exact strings.</li>

<li>Asterisks may also be used with multiple words.<br>
For example, enter <b>*th Carolina</b> to match both
<b>North Carolina</b> and <b>South Carolina</b>.</li>
</ul>
</p>

<p>If you are interested in doing a more complex search, please
contact the <a href="mailto:beckcenter@emory.edu">Beck Center
Staff</a>.</p>



</div>

<?php
  include("xml/foot.xml");
?>

</body>
</html>
