//javascript to colorize a search string

//multiple terms should be passed in as match1|match2|match3
function highlight (string, match) {
 var fixre = new RegExp("\*");
 match = match.replace(fixre, "\w\*");

 var pattern = new RegExp("("+match+")", "gi");
 var color = string.replace( pattern,
	"<font color='red'><b>$1</b></font>");
  
 document.write(color);

}