// Rebecca Sutton Koeser, August 26 2003
// Collapsible list functions for ILN contents 

function toggle_ul (id) {
  if(document.getElementById){
   a=document.getElementById(id);
   a.style.display=(a.style.display!="none")?"none":"block";
  }
  toggle_gif('gif_'+id);  
}

function toggle_gif (id) {
var base_url = "http://chaucer.library.emory.edu/iln/";
  if(document.getElementById) {
    a=document.getElementById(id);
      a.status = (a.status == "open") ? "closed":"open";
      a.src = base_url + a.status + ".gif";
  }
}


// Initialize the lists & hide sublists
function toggle_init (max) {
  for (i=1; i <= max; i++) {
    if(document.getElementById) {
      a=document.getElementById('gif_list'+i);
      // initialize img status 
        a.status = "open";
    }
    // hide ul blocks
    toggle_ul ('list'+i);
  }
}
