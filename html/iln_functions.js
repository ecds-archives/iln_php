
function getSortVal () {
  for (var i=0; i < document.ilnquery.sort.length; i++) {
    if (document.ilnquery.sort[i].checked) {
      var val = document.ilnquery.sort[i].value;
    }
  }
 return val;
}

function submitForm () {
  newurl = "http://tamino.library.emory.edu/passthru/servlet/transform/tamino/BECKCTR/ILN?_xql=TEI.2//div2[*]sortby("+
    getSortVal() + ")&_xslsrc=xsl:stylesheet/ilncontents.xsl";

  //alert(newurl);
  document.location.href = newurl;
}

function reSort(newSortVal) {
 newurl = "http://tamino.library.emory.edu/passthru/servlet/transform/tamino/BECKCTR/ILN?_xql=TEI.2//div2[*]sortby("+
    newSortVal + ")&_xslsrc=xsl:stylesheet/ilncontents.xsl";
//alert(newurl);
document.location.href = newurl;
}


// determine user's browser & version; load appropriate css file
function getBrowserCSS () {
  var name = navigator.appName;
  var version = navigator.appVersion;
  var os = navigator.platform;
  var css = "iln.css";

  if (name.match(/Internet Explorer/i)) {
    if (os.match(/mac/i)) {
      css = "iln-iemac.css";
    } else if (os.match(/win/i)) {
      css = "iln-iewin.css";
    }
  }
  //link to the appropriate stylesheet 
  var css_link = '<link rel="stylesheet" type="text/css" href="http://chaucer.library.emory.edu/iln/';
  var end_css = '"/>';

  document.write(css_link+css+end_css);
}
