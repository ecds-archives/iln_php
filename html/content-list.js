// Rebecca Sutton Koeser, August 26 2003
// Collapsible list functions for ILN contents 


// base url for close/open images
var base_url = "http://chaucer.library.emory.edu/iln/";


function toggle_ul (id) {
  if(document.getElementById){
   a = document.getElementById(id);
   //   alert("current style is " + a.style.display);
   if (a.style.display == '') {
     a.style.display = "none";
   }
   a.style.display = (a.style.display != "none") ? "none":"block";
  }
  toggle_gif('gif_'+id);  
}

function toggle_gif (id) {
  if(document.getElementById) {
    a=document.getElementById(id);
   if (a.style.display == '') {
     a.style.display = "closed";
   }
   a.status = (a.status == "open") ? "closed":"open";
   a.src = base_url + a.status + ".gif";
  }
}


// Initialize the lists & hide sublists
/* function toggle_init (max) {
  for (i=1; i <= max; i++) { 
    if(document.getElementById) { 
      a=document.getElementById('gif_list'+i); 
      // initialize img status  
        a.status = "open"; 
    } 
    // hide ul blocks 
    //    toggle_ul ('list'+i); 
  } 
} 

*/


// store current display properties in cookies
function store_status (max) {
  var crumb = new Cookie(document, "content-list-state");		

  // for each list & each graphic, create a cookie and store current setting 
  for (i = 1; i <= max; i++) { 
    if(document.getElementById) { 
      var list = document.getElementById('list' + i); 
      //var clist = new Cookie(document, 'list' + i);
      //clist.store(list.style.display);
      crumb["list" + i] = list.style.display;

      var gif = document.getElementById('gif_list'+i); 
      //var giflist = new Cookie(document, 'gif_list' + i);
      //giflist.store(gif.status);
      //set_cookie('gif_list' + i, list.style.display);
      crumb["gif" + i] = gif.status;
    }
  }
  crumb.store();
}

// store current display properties in cookies
function load_status (max) {
  var crumb = new Cookie(document, "content-list-state");
  //  var gif_crumb = new Cookie(document, "content-list-images-state");
  crumb.load();
  //  gif_crumb.load();
  // for each list & each graphic, create a cookie and store current setting 
  for (i = 1; i <= max; i++) { 
    if(document.getElementById) { 
      var list = document.getElementById('list' + i); 
      //var clist = new Cookie(document, 'list' + i);
      //list.style.display = clist.load();
      //list.style.display = get_cookie('list'+i);
      list.style.display = crumb["list" + i];

      var gif = document.getElementById('gif_list'+i); 
      //var giflist = new Cookie(document, 'gif_list' + i);
      //gif.status = giflist.load();
      //gif.status = get_cookie('gif_list'+i);
      gif.status = crumb["gif" + i];
      // default image is closed; change image if necessary
      if (gif.status == 'open')  gif.src = base_url + "open.gif";
    } 
  } 
}


