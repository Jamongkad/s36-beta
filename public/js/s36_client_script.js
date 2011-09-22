/****************************************************************
/*  this function will create necessary lightboxes for the popup
****************************************************************/
function createLightboxes(){
	
	// Create the s36 modal box
	var s36_modalbox = document.createElement("div");
		s36_modalbox.id = "s36_modalbox";        
		s36_modalbox.className = "s36_modalbox";
		document.body.appendChild(s36_modalbox);
		
	// Create the s36 modal shadow	
	var s36_modalboxshadow = document.createElement("div");
		s36_modalboxshadow.id = "s36_modalshadow";        
		s36_modalboxshadow.setAttribute("onclick","s36_closeLightbox()");
		s36_modalboxshadow.className = "s36_modalshadow";
		document.body.appendChild(s36_modalboxshadow);
}

/****************************************************************
/*	function that will open the modal window
****************************************************************/
function s36_openLightbox(width,height,src) {
	
	var s36_modalbox 	= document.getElementById('s36_modalbox');
	var s36_modalshadow = document.getElementById('s36_modalshadow');
	// needed for the marginLeft property of the lightbox. 
	// This is to assure that its position is centered
	var divide = Math.round(width / 2); 
	
	// create that close button
	var s36_closebtn = document.createElement("div");
		s36_closebtn.id = "s36_closebtn";
		s36_closebtn.setAttribute("onclick","s36_closeLightbox()");
		s36_closebtn.className = "s36_closebtn";
		s36_modalbox.appendChild(s36_closebtn);
	// build that awesome iframe
	var s36_iframe = document.createElement('iframe');
		s36_iframe.setAttribute('src','http://localhost/templates');
		s36_iframe.setAttribute('width',width);
		s36_iframe.setAttribute('height',height);
		s36_iframe.setAttribute('frameborder',0);
		s36_iframe.setAttribute('noresize','noresize');
		s36_iframe.setAttribute('scrolling','no');
		
	if(s36_modalbox != null){
		
		s36_modalbox.style.width 	  = width + "px";
		s36_modalbox.style.height	  = height + "px";			
		s36_modalbox.style.marginLeft = '-' + divide + 'px';
		s36_modalbox.style.display 	  = 'block';
		s36_modalbox.appendChild(s36_iframe);
		
		s36_modalshadow.style.display = 'block';
		
	}else{
		alert('there is no modal box detected!!!');
	}
	
}

/****************************************************************
/*	function that will open the form in a modal window
****************************************************************/
function s36_openForm(siteId,companyId) {
	
	var s36_modalbox 	= document.getElementById('s36_modalbox');
	var s36_modalshadow = document.getElementById('s36_modalshadow');
	
	// create that close button
	var s36_closebtn 			= document.createElement("div");
		s36_closebtn.id 		= "s36_closebtn";
		s36_closebtn.className 	= "s36_closebtn";
		s36_closebtn.setAttribute("onclick","s36_closeLightbox()");		
		s36_modalbox.appendChild (s36_closebtn);
		
	var src 	= "http://dev.gearfish.com/widget/form?siteId="+siteId+"&companyId="+companyId;
	
	var width 	= 447;
	var height 	= 590;
	// needed for the marginLeft property of the lightbox. 
	// This is to assure that its position is centered
	var divide	= Math.round(width / 2); 
	
	// build that awesome iframe
	var s36_iframe = document.createElement('iframe');
		s36_iframe.setAttribute('src',src);
		s36_iframe.setAttribute('width',width);
		s36_iframe.setAttribute('height',height);
		s36_iframe.setAttribute('frameborder',0);
		s36_iframe.setAttribute('noresize','noresize');
		s36_iframe.setAttribute('scrolling','no');
		
	if(s36_modalbox != null){
		
		s36_modalbox.style.width 	  = width + "px";
		s36_modalbox.style.height	  = height + "px";			
		s36_modalbox.style.marginLeft = '-' + divide + 'px';
		s36_modalbox.style.display 	  = 'block';
		s36_modalbox.appendChild(s36_iframe);
		
		s36_modalshadow.style.display = 'block';
		
	}else{
		alert('there is no modal box detected!!!');
	}
	
}

/****************************************************************
/* Create that widget button
****************************************************************/
function s36_create_widget_button(opts){
	console.log(opts);
	// Create the s36 modal box
	var s36_widget_button 			= document.createElement("div");
		s36_widget_button.id 		= "s36_widget_button";
		s36_widget_button.className = "s36_widget_button";
		s36_widget_button.setAttribute('onclick','s36_openForm('+opts.siteId+','+opts.companyId+')');
		document.body.appendChild(s36_widget_button);
}

function s36_closeLightbox(){	
	var s36_modalbox 	= document.getElementById('s36_modalbox');
	var s36_modalshadow = document.getElementById('s36_modalshadow');
	
	while (s36_modalbox.hasChildNodes()) s36_modalbox.removeChild(s36_modalbox.firstChild);
	
	s36_modalbox.style.display 		= 'none';
	s36_modalshadow.style.display 	= 'none';		
}

function s36_modal_widget(opts){	
	var width  = 960;
	var height = 480;
	var widget = document.getElementById(opts.target);
		widget.setAttribute('onclick','s36_openLightbox('+width+','+height+',"'+opts.src+'")');
}















/****************************************************************
/* This is the document ready function
****************************************************************/
(function(){
    var DomReady = window.DomReady = {};
	// Everything that has to do with properly supporting our document ready event. Brought over from the most awesome jQuery. 
    var userAgent = navigator.userAgent.toLowerCase();
    // Figure out what browser is being used
    var browser = {
    	version: (userAgent.match( /.+(?:rv|it|ra|ie)[\/: ]([\d.]+)/ ) || [])[1],
    	safari: /webkit/.test(userAgent),
    	opera: /opera/.test(userAgent),
    	msie: (/msie/.test(userAgent)) && (!/opera/.test( userAgent )),
    	mozilla: (/mozilla/.test(userAgent)) && (!/(compatible|webkit)/.test(userAgent))
    };    

	var readyBound = false;	
	var isReady = false;
	var readyList = [];

	// Handle when the DOM is ready
	function domReady() {
		// Make sure that the DOM is not already loaded
		if(!isReady) {
			// Remember that the DOM is ready
			isReady = true;
        
	        if(readyList) {
	            for(var fn = 0; fn < readyList.length; fn++) {
	                readyList[fn].call(window, []);
	            }
            
	            readyList = [];
	        }
		}
	};

	// From Simon Willison. A safe way to fire onload w/o screwing up everyone else.
	function addLoadEvent(func) {
	  var oldonload = window.onload;
	  if (typeof window.onload != 'function') {
	    window.onload = func;
	  } else {
	    window.onload = function() {
	      if (oldonload) {
	        oldonload();
	      }
	      func();
	    }
	  }
	};

	// does the heavy work of working through the browsers idiosyncracies (let's call them that) to hook onload.
	function bindReady() {
		if(readyBound) {
		    return;
	    }
	
		readyBound = true;

		// Mozilla, Opera (see further below for it) and webkit nightlies currently support this event
		if (document.addEventListener && !browser.opera) {
			// Use the handy event callback
			document.addEventListener("DOMContentLoaded", domReady, false);
		}

		// If IE is used and is not in a frame
		// Continually check to see if the document is ready
		if (browser.msie && window == top) (function(){
			if (isReady) return;
			try {
				// If IE is used, use the trick by Diego Perini
				// http://javascript.nwbox.com/IEContentLoaded/
				document.documentElement.doScroll("left");
			} catch(error) {
				setTimeout(arguments.callee, 0);
				return;
			}
			// and execute any waiting functions
		    domReady();
		})();

		if(browser.opera) {
			document.addEventListener( "DOMContentLoaded", function () {
				if (isReady) return;
				for (var i = 0; i < document.styleSheets.length; i++)
					if (document.styleSheets[i].disabled) {
						setTimeout( arguments.callee, 0 );
						return;
					}
				// and execute any waiting functions
	            domReady();
			}, false);
		}

		if(browser.safari) {
		    var numStyles;
			(function(){
				if (isReady) return;
				if (document.readyState != "loaded" && document.readyState != "complete") {
					setTimeout( arguments.callee, 0 );
					return;
				}
				if (numStyles === undefined) {
	                var links = document.getElementsByTagName("link");
	                for (var i=0; i < links.length; i++) {
	                	if(links[i].getAttribute('rel') == 'stylesheet') {
	                	    numStyles++;
	                	}
	                }
	                var styles = document.getElementsByTagName("style");
	                numStyles += styles.length;
				}
				if (document.styleSheets.length != numStyles) {
					setTimeout( arguments.callee, 0 );
					return;
				}
			
				// and execute any waiting functions
				domReady();
			})();
		}

		// A fallback to window.onload, that will always work
	    addLoadEvent(domReady);
	};

	// This is the public function that people can use to hook up ready.
	DomReady.ready = function(fn, args) {
		// Attach the listeners
		bindReady();
    
		// If the DOM is already ready
		if (isReady) {
			// Execute the function immediately
			fn.call(window, []);
	    } else {
			// Add the function to the wait list
	        readyList.push( function() { return fn.call(window, []); } );
	    }
	};
    
	bindReady();
	
})();

/****************************************************************
/*	functions under the onload event must run or else boom!
****************************************************************/
DomReady.ready(function() {
   createLightboxes();
});
