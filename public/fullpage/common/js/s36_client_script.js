/****************************************************************
/*  this function will create necessary lightboxes for the popup
****************************************************************/
var userAgent = navigator.userAgent.toLowerCase();

var browser = {
    version: (userAgent.match( /.+(?:rv|it|ra|ie)[\/: ]([\d.]+)/ ) || [])[1],
    safari: /webkit/.test(userAgent),
    opera: /opera/.test(userAgent),
    msie: (/msie/.test(userAgent)) && (!/opera/.test( userAgent )),
    mozilla: (/mozilla/.test(userAgent)) && (!/(compatible|webkit)/.test(userAgent))
};    

function createLightboxes(){
		
	// Create the s36 modal shadow	
	var s36_modalboxshadow = document.createElement("div");
		s36_modalboxshadow.id = "s36_modalshadow";        
		s36_modalboxshadow.className = "s36_modalshadow";
	
	if(browser.msie) {
        //s36_modalboxshadow.attachEvent("onclick", s36_closeLightbox);
        s36_modalboxshadow.attachEvent("onclick", open_s36_pop_up_box);
        
    } else {
        //s36_modalboxshadow.setAttribute("onclick","s36_closeLightbox()");            
        s36_modalboxshadow.setAttribute("onclick","open_s36_pop_up_box()");
    }
        
		document.body.appendChild(s36_modalboxshadow);
	
	
	// Create the s36 modal box
	var s36_modalbox = document.createElement("div");
		s36_modalbox.id = "s36_modalbox";        
		s36_modalbox.className = "s36_modalbox";
		document.body.appendChild(s36_modalbox);
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

        if(browser.msie) {
            //s36_closebtn.attachEvent("onclick", s36_closeLightbox);
            s36_closebtn.attachEvent("onclick", open_s36_pop_up_box);
        } else {
            //s36_closebtn.setAttribute("onclick","s36_closeLightbox()");
            s36_closebtn.setAttribute("onclick","open_s36_pop_up_box()");
        }
	
		s36_closebtn.className = "s36_closebtn";
		s36_modalbox.appendChild(s36_closebtn);
	// build that awesome iframe
	var s36_iframe = document.createElement('iframe');
		s36_iframe.setAttribute('src',src);
		s36_iframe.setAttribute('width',width);
		s36_iframe.setAttribute('height',height);
		s36_iframe.setAttribute('frameborder',0);
		s36_iframe.setAttribute('noresize','noresize');
		s36_iframe.setAttribute('scrolling','no');
		s36_iframe.setAttribute('id','s36_iframe');
		
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
// NEW!!!!!!!! ADDED 03-08-12
function s36_open_popup_widget(){
	var s36_popupmodalbox 	= document.getElementById('s36PopupWidgetBox');
	var s36_popupmodalshadow = document.getElementById('s36PopupWidgetShadow');
	s36_popupmodalbox.style.display = 'block';
	s36_popupmodalshadow.style.display 	= 'block';	
}
// NEW!!!!!!!! ADDED 03-08-12
function s36_closePopupWidget(){	
	var s36_popupmodalbox 	= document.getElementById('s36PopupWidgetBox');
	var s36_popupmodalshadow = document.getElementById('s36PopupWidgetShadow');
	s36_popupmodalbox.style.display = 'none';
	s36_popupmodalshadow.style.display 	= 'none';		
}

function s36_openForm(form_url) {

    var topoffset = document.body.scrollTop - 1;
    var boxheight = -295;
    var fixoffset = boxheight + topoffset;

	var s36_modalbox 	= document.getElementById('s36_modalbox');
	var s36_modalshadow = document.getElementById('s36_modalshadow');
	
	// create that close button
	var s36_closebtn 			= document.createElement("div");
		s36_closebtn.id 		= "s36_closebtn";
		s36_closebtn.className 	= "s36_closebtn";

        if(browser.msie) {
            s36_closebtn.attachEvent("onclick", s36_closeLightbox);
        } else {
            s36_closebtn.setAttribute("onclick","s36_closeLightbox()");            
        }

		s36_modalbox.appendChild (s36_closebtn);
		
	var width 	= 447;
	var height 	= 590;
	// needed for the marginLeft property of the lightbox. 
	// This is to assure that its position is centered
	var divide	= Math.round(width / 2); 
	
	// build that awesome iframe
	var s36_iframe = document.createElement('iframe');
		s36_iframe.setAttribute('src',form_url);
		s36_iframe.setAttribute('width',width);
		s36_iframe.setAttribute('height',height);
		s36_iframe.setAttribute('frameborder',0);
		s36_iframe.setAttribute('noresize','noresize');
		s36_iframe.setAttribute('scrolling','no');
		
	if(s36_modalbox != null){

        s36_modalbox.style.marginTop = fixoffset + 'px';

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
function s36_closeLightbox(){
	
	//new s36_pop_up_box( 'Are you sure you want to return to the display page? All your changes will be lost', 'confirm', 'You haven\'t finished your feedback' );
	
	var s36_modalbox 	= document.getElementById('s36_modalbox');
	var s36_modalshadow = document.getElementById('s36_modalshadow');
	
	while (s36_modalbox.hasChildNodes()) {
        s36_modalbox.removeChild(s36_modalbox.firstChild);
    }
	
	s36_modalbox.style.display 		= 'none';
	s36_modalshadow.style.display 	= 'none';		
}

function form_value_changed(){
	
	var s36_iframe = document.getElementById('s36_iframe');
	var s36_iframe_contents = s36_iframe.contentDocument || s36_iframe.contentWindow.document;
	
	var rating = s36_iframe_contents.getElementById('rating');
	var title = s36_iframe_contents.getElementById('feedbackTitle');
	var feedback_text = s36_iframe_contents.getElementById('feedbackText');
	var recommend = s36_iframe_contents.getElementById('recommend');
	var uploaded_images = s36_iframe_contents.getElementById('uploaded_images_preview');
	var uploaded_video = s36_iframe_contents.getElementById('uploaded_video_preview');
	var all_done_page = s36_iframe_contents.getElementById('step4');
	
	// don't show the confirm box in all done page.
	if( all_done_page.className == 'form-page current' ) return false;
	
	if( rating.value != 0 ) return true;
	if( title.value != '' ) return true;
	if( feedback_text.value != '' ) return true;
	if( recommend.value != '1' ) return true;
	if( uploaded_images.hasChildNodes() ) return true;
	if( uploaded_video.hasChildNodes() ) return true;
	
	return false;
	
}

// function confirm_close_lightbox(){
// 	s36_closeLightbox();
// }

// function cancel_dialog(){
// 	// close pop up box.
// }

function close_s36_pop_up_box(){
	var s36_modalbox = document.getElementById('s36_modalbox');
	var lightbox = document.getElementById('lightbox');
	s36_modalbox.removeChild(lightbox);
}

//var s36_pop_up_box = new function (){
function s36_pop_up_box(title, msgs, type){
	
	// this.ok_callback;
	// this.cancel_callback;
	// this.callbacks = function(ok_function, cancel_function){
	// 	this.ok_callback = ok_function;
	// 	this.cancel_callback = cancel_function;
	// };
	// this.dialog_ok = function(){
	// 	return this.ok_callback();
	// }
	// this.dialog_cancel = function(){
	// 	return this.cancel_callback();
	// }
	
	//this.init = function(title, msgs, type){
	
		// default values.
		title = ( typeof(title) == 'undefined' ? 'Oops! Something went wrong...' : title );
		msgs = ( typeof(msgs) == 'undefined' ? ['ang kapal ng muka ni dan calpatura'] : msgs );
		msgs = ( typeof(msgs) != 'object' ? [msgs] : msgs );
		type = ( typeof(type) == 'undefined' ? 'alert' : type );
		type = type.toLowerCase();
		
		// objects.
		var s36_iframe = document.getElementById('s36_iframe');
		var s36_iframe_contents = s36_iframe.contentDocument || s36_iframe.contentWindow.document;
		var form_box = s36_iframe_contents.getElementById('formBox');
		var s36_modalbox = document.getElementById('s36_modalbox');
		var s36_pop_up_box = document.createElement('div');
		var pandora = document.createElement('div');
		var header = document.createElement('div');
		var body = document.createElement('div');
		var msg_list_container = document.createElement('div');
		var msg_list = document.createElement('ul');
		var button_container = document.createElement('div');
		var ok_button = document.createElement('a');
		var cancel_button = document.createElement('a');
		
		// properties.
		s36_pop_up_box.id = 'lightbox';
		pandora.className = 'lightbox-pandora';
		header.className = 'lightbox-header';
		body.className = 'lightbox-body';
		msg_list_container.className = 'lightbox-message error';
		msg_list.className = 'lightbox-message error';
		button_container.className = 'lightbox-buttons';
		ok_button.className = 'lightbox-button';
		cancel_button.className = 'lightbox-button';
		
		// css.
		s36_pop_up_box.style.display = 'block';
		s36_pop_up_box.style.position = 'absolute';
		s36_pop_up_box.style.width = '290px';
		s36_pop_up_box.style.background = 'url(../../img/faded-black.png)';
		s36_pop_up_box.style.zIndex = '1000';
		s36_pop_up_box.style.webkitBorderRadius = '5px';
		s36_pop_up_box.style.MozBorderRadius = '5px';
		s36_pop_up_box.style.borderRadius = '5px';
		s36_pop_up_box.style.top = '30%';
		s36_pop_up_box.style.left = '50%';
		s36_pop_up_box.style.marginLeft = '-145px';
		
		// contents.
		header.textContent = title;
		msg_list.innerHTML = '<li>' + msgs.join('</li><li>') + '</li>';
		ok_button.textContent = 'OK';
		cancel_button.textContent = 'Cancel';
		
		// events here probably.
		if(browser.msie){
	    	ok_button.attachEvent("onclick", s36_closeLightbox);
	    	cancel_button.attachEvent("onclick", close_s36_pop_up_box);
	        
	    }else{
			ok_button.setAttribute('onclick', 's36_closeLightbox()');
			cancel_button.setAttribute('onclick', 'close_s36_pop_up_box()');
	    }
		
		// birth of the objects.
		s36_pop_up_box.appendChild(pandora);
		pandora.appendChild(header);
		pandora.appendChild(body);
		body.appendChild(msg_list_container);
		msg_list_container.appendChild(msg_list);
		body.appendChild(button_container);
		( type == 'confirm' ? button_container.appendChild(cancel_button) : '' );
		button_container.appendChild(ok_button);
		s36_modalbox.appendChild(s36_pop_up_box);
		//form_box.appendChild(s36_pop_up_box);
		//s36_iframe.appendChild(s36_pop_up_box);
		
	//}
	
}

function open_s36_pop_up_box(){
	if( form_value_changed() ){
		//if( ! confirm('Are you sure you want to return to the display page? All your changes will be lost') ) return;
		//s36_pop_up_box.callbacks(confirm_close_lightbox, cancel_dialog);
		//s36_pop_up_box.init( 'You haven\'t finished your feedback', 'Are you sure you want to return to the display page? All your changes will be lost', 'confirm' );
		
		if( document.getElementById('lightbox') != null ) return;
		
		s36_pop_up_box( 'You haven\'t finished your feedback', 'Are you sure you want to return to the display page? All your changes will be lost', 'confirm' );
		return;
	}
	
	s36_closeLightbox();
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
