<?php

include_once("link_admin/taminoConnection.class.php");
include("common_functions.php");

$args = array('host' => "vip.library.emory.edu",
		'db' => "BECKCTR",
	      //	      'debug' => true,
		'coll' => 'ILN');
$tamino = new taminoConnection($args);

$query = 'for $b in input()/TEI.2//div1
return <div1>
 {$b/@type}
 {$b/head}
 {$b/docDate}
 { for $c in $b/div2 return
   <div2>
     {$c/@id}
     {$c/@type}
     {$c/head}
     {$c/bibl}
     { for $d in $c/p/figure return $d}
   </div2>
}</div1>';

$rval = $tamino->xquery($query);
if ($rval) {       // tamino Error code (0 = success)
  print "<p>Error: failed to retrieve contents.<br>";
  print "(Tamino error code $rval)</p>";
  exit();
} 


html_head("Browse");

include("xml/head.xml");
include("xml/sidebar.xml");

print '<div class="content"> 
          <h2>Browse</h2>';
print "<hr>";
$xsl_file = "contents.xsl";
$tamino->xslTransform($xsl_file);
$tamino->printResult();

print "<hr>";

?> 
   
  </div>
   
<?php
  include("xml/foot.xml");
?>


</body>
</html>
