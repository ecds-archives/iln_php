


//sample update xquery
$url = 'http://vip.library.emory.edu/tamino/BECKCTR/iln_links?_xquery=
declare namespace dc="http://purl.org/dc/elements/1.1/" 
update for $b in input()/link_collection 
do insert <link_record> 
<dc:title>Nineteenth Century Railway History through the Illustrated London News</dc:title> 
 <dc:subject>Illustrated London News</dc:subject> 
 <dc:description>A selection of railway-related ILN articles and illustrations.</dc:description> 
 <dc:contributor>Rebecca Sutton Koeser</dc:contributor> 
 <dc:date>2004-04-06</dc:date> 
 <dc:identifier>http://www.mtholyoke.edu/courses/rschwart/ind_rev/iln/ilnhome.html</dc:identifier> 
</link_record> into $b';