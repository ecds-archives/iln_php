<?php
include("../common_functions.php");

$subject = $_GET["subj"];
$mode = $_GET["mode"];  // should be add or del


if ($mode == 'add') {
  // get the current list of subjects-- don't add duplicates
  $status_url = "http://vip.library.emory.edu/tamino/BECKCTR/iln_links?_xquery=
declare namespace dc=\"http://purl.org/dc/elements/1.1/\"
for \$b in input()/link_collection/subject_list/dc:subject
where \$b eq \"$subject\"
return \$b";
  $status_url = encode_url($status_url);
  $xmlContent = file_get_contents($status_url);
  if (strpos($xmlContent, "<dc:subject>$subject</dc:subject>")) {
    //FIXME: why doesn't this detect duplicates?  does file_get_contents cache?
    print "Error! The subject heading <b>$subject</b> is already in the list.  Not adding.<br>";
  } else {
    /* update xquery -- add a new subject to subject list */
  $update_url = "http://vip.library.emory.edu/tamino/BECKCTR/iln_links?_xquery=
declare namespace dc=\"http://purl.org/dc/elements/1.1/\"  
update for \$b in input()/link_collection/subject_list
do insert <dc:subject>$subject</dc:subject> into \$b";
  }
} else if ($mode == 'del') {
  $update_url = "http://vip.library.emory.edu/tamino/BECKCTR/iln_links?_xquery=
declare namespace dc=\"http://purl.org/dc/elements/1.1/\"  
update for \$b in input()/link_collection/subject_list/dc:subject
where \$b eq \"$subject\"
do delete \$b";
}

$update_url = encode_url($update_url);
$xmlContent = file_get_contents($update_url);

/* Check that the update succeeded
 Note: this may not be a very stringent request... might be a good 
 idea to check for error messages. */
if (strpos($xmlContent, "XQuery Update Request processed")) {
  print "<h3>Successfully updated subject list.</h3>";
}


// display the newly-updated list of subjects
$status_url = 'http://vip.library.emory.edu/tamino/BECKCTR/iln_links?_xquery=
declare namespace dc="http://purl.org/dc/elements/1.1/"
for $b in input()/link_collection/subject_list
return $b';
$status_url = encode_url($status_url);
$xsl_file = "subjlist.xsl";

$xmlContent = file_get_contents($status_url);
$result = transform($xmlContent, $xsl_file); 

print "<h2>Newly updated subject heading list</h2>";
print $result;


?>