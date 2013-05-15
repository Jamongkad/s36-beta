/* 
* Copyright (c) 2012 Leonardo Cardoso (http://leocardz.com)
* Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
* and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
*
* Version: 0.4.47
* 
*/
(function ($) {
	$.fn.linkPreview = function(){
		
		function trim(str) {
			return str.replace(/^\s+|\s+$/g,"");
		}
		
		var text;
		var urlRegex = /(https?\:\/\/|\s)[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})(\/+[a-z0-9_.\:\;-]*)*(\?[\&\%\|\+a-z0-9_=,\.\:\;-]*)?([\&\%\|\+&a-z0-9_=,\:\;\.-]*)([\!\#\/\&\%\|\+a-z0-9_=,\:\;\.-]*)}*/i;
		
		$(this).keyup(function(e){
			if((e.which == 13 || e.which == 32 || e.which == 17 || e.which == 224) && trim( $(this).val() ) != ""){
				text = $(this).val();
				if( urlRegex.test(text) ){
					$('.loading-box').fadeIn('fast');
					//$.get('/imageprocessing/linkpreview/', {'text': text}, function(answer) {  // replaced with $_POST because $_GET has char limit.
					$.post('/imageprocessing/linkpreview/', {'text': text}, function(answer) {
						if(answer.url == null) answer.url = "";
						if(answer.pageUrl == null) answer.pageUrl = "";
						if(answer.title == null) answer.title = answer.titleEsc;
						if(answer.description == null) answer.description = answer.descriptionEsc;
						if(answer.title == null) answer.title = "";
						if(answer.description == null) answer.description = "";
						if(answer.cannonicalUrl == null) answer.cannonicalUrl = "";
						if(answer.images == null) answer.images = "";
						if(answer.video == null) answer.video = "";
						if(answer.videoIframe == null) answer.videoIframe = "";
						
						var e_title = answer.title.substr(0, 38);
						var e_desc = answer.description.substr(0, 50);
						e_title = e_title + ( e_title != answer.title ? '...' : '' );
						e_desc = e_desc + ( e_desc != answer.description ? '...' : '' );
						
						var result = 
					       'url => ' + answer.url + '\n\n' +
					       'title => ' + answer.title + '\n\n' +
					       'desc => ' + answer.description + '\n\n' +
					       'images => ' + answer.images + '\n\n' + 
					       'video => ' + answer.video + '\n\n';
				      var link_image = answer.images.split('|');
				      $('#link-data #hasLink').val(1);
				      $('#link-data #link-title').val(answer.title);
				      $('#link-data #link-description').val(answer.description);
				      $('#link-data #link-image').val(link_image[0]);
				      $('#link-data #link-url').val(answer.url);
				      $('#link-data #link-video').val(answer.video);

						$('.form-video-thumbs')
							.html(
								$('<div class="video-container clear" />')
								.append($('<div />')
									.addClass('form-video-meta')
									.append(
										$('<div />')
											.addClass('video-thumb e_vid_check')
											.append($('<img />').attr({'src':link_image[0],'width':'100%'}))
									)
									.append(
										$('<div />')
											.addClass('video-details')
											.append('<h3>'+e_title+'</h3>')
											.append('<p>'+e_desc+'</p>')
									)
								)
								.append($('<div />').addClass('thumb-vid-close'))
							);
						init_thumbnail_vid_close_btn();
						scale_review_textbox();
						scale_feedback_textbox();
						$('.loading-box').fadeOut('fast');
					}, "json");
				}
				
			}
		});


	}
})(jQuery);
