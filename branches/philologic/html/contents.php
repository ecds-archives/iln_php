<?php

include_once("link_admin/taminoConnection.class.php");
include("common_functions.php");

$args = array('host' => $tamino_server,
	      'db' => $tamino_db,
	      'coll' => $tamino_coll,
	      'debug' => false);
$tamino = new taminoConnection($args);

$query = 'for $b in input()/TEI.2/:text/body/div1
sort by (@id)
return <div1 id="{$b/@id}" type="{$b/@type}">
 {$b/head}
 {$b/docDate}
 { for $c in $b/div2 return
   <div2 id="{$c/@id}" type="{$c/@type}" n="{$c/@n}">
     {$c/head}
     {$c/bibl}
     {for $d in $c/p/figure return $d}
   </div2>
}</div1>';

$rval = $tamino->xquery($query);
if ($rval) {       // tamino Error code (0 = success)
  print "<p>Error: failed to retrieve contents.<br>";
  print "(Tamino error code $rval)</p>";
  exit();
} 


html_head("Browse", true);

include("xml/head.xml");
include("xml/sidebar.xml");

print '<div class="content"> 
          <h2>Browse</h2>';
$xsl_file = "contents.xsl";
$tamino->xslTransform($xsl_file);
$tamino->printResult();

?> 
   
  </div>
   
<?php
  include("xml/foot.xml");
?>


</body>
</html>
