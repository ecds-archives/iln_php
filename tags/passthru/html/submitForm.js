function getSortVal () {
  for (var i=0; i < document.ilnquery.sort.length; i++) {
    if (document.ilnquery.sort[i].checked) {
      var val = document.ilnquery.sort[i].value;
    }
  }
 return val;
}

function submitForm () {

newurl = "http://tamino.library.emory.edu/passthru/servlet/transform/tamino/BECKCTR/ILN?_xql=//div2[*]sortby("+
    getSortVal() + ")&_xslsrc=xsl:stylesheet/ilncontents.xsl";
//alert(newurl);
document.location.href = newurl;

}

function reSort(newSortVal) {
 newurl = "http://tamino.library.emory.edu/passthru/servlet/transform/tamino/BECKCTR/ILN?_xql=//div2[*]sortby("+
    newSortVal + ")&_xslsrc=xsl:stylesheet/ilncontents.xsl";
//alert(newurl);
document.location.href = newurl;
}