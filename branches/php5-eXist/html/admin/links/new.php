<?php

include("../../config.php");
include("common_functions.php");
include("linkRecord.class.php");

html_head("Links - Add a new link");

include("xml/head.xml");
include("xml/sidebar.xml");

// needs tamino info to grab subject
$myargs = array('host' => $tamino_server,
		'db' => $tamino_db,
		'coll' => $link_coll,
		'debug' => false);
$link = new LinkRecord($myargs);

print '<div class="content">
<h2>Add a new record</h2>';

include("nav.html");

print '<hr>';
$link->printHTMLForm("add");

print '<hr>';

include("nav.html");

print '</div>';
include("xml/foot.xml");
?>
</body>
</html>
