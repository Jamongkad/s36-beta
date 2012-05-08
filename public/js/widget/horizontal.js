/* ----------------  end of document ready function  --------------------------*/
	function assignSoloFeedback(meta){
		
		$('.soloFeedbackText').html(meta.text);	
		$('.soloFeedbackText').jScrollPane();
		$('.soloFeedbackAvatar').find('img').attr('src',meta.avatar);
		$('.soloFeedbackAuthorName').html(meta.name);
		$('.soloFeedbackAuthorCompany').html(meta.company);
		$('.soloFeedbackAuthorLocation').html(meta.location);
		$('.soloFeedbackDate').html(meta.date);
		$('.soloFeedbackAuthor').find('.flag').removeClass().addClass("flag flag-" + meta.flag);
	}
	
	function loadSocialButtons(link, target){
		
		if(target.find('.twitter-button').length == 0){
			target.append(
						$('<div />').addClass('twitter-button')
									.append('<a href="'+link+'" class="twitter-share-button">Tweet</a>'))
				  .append(
						$('<div />').addClass('facebook-button')
									.append('<fb:like href="'+link+'" send="false" layout="button_count" width="100" show_faces="false"></fb:like>')
				  );
			
			twttr.widgets.load(); // parse the twitter widgets
			FB.XFBML.parse();	  // parse the facebook widgets
		}
		target.slideToggle('fast');
	}
	
	function createPagination(curr,next,opts,fwd){
		
		var obj 		= $(next);	  
		var curr_count  = obj.index();
		var max_count   = obj.parent().children().length;
		var pager 		= $('.pagination');   // the div where you want the pagination to appear
		var prev  		= $('#prev');		  // element for prev
		var next  		= $('#next');		  // element for next
		
		if(max_count > 5){
			if(curr_count <= 2){ 					 // check if the current slide is on 1 , 2 and 3
				pager.empty();
				for(ctr = 1;ctr <= 5;ctr++){
					pager.append(
						'<a href="javascript:;">'+ctr+'</a>'
					);
				}
			}else if(curr_count >= (max_count - 3)){ // check if the current slide is on the last 3 slides
				pager.empty();
				for(ctr = (max_count - 4);ctr <= max_count;ctr++){
					pager.append('<a href="javascript:;">'+ctr+'</a>');
				}
			}else{									// generate an awesome custom pagination gadamit
				pager.empty();
				pager.append('<a href="javascript:;">'+(curr_count - 1)+'</a>')
					 .append('<a href="javascript:;">'+(curr_count)+'</a>')
					 .append('<a href="javascript:;">'+(curr_count + 1)+'</a>')
					 .append('<a href="javascript:;">'+(curr_count + 2)+'</a>')
					 .append('<a href="javascript:;">'+(curr_count + 3)+'</a>');
			}
		}else{
			pager.empty();
			for(ctr = 1;ctr <= max_count;ctr++){
				pager.append(
					'<a href="javascript:;">'+ctr+'</a>'
				);
			}
		}
		
		if(curr_count == 0){
			prev.fadeOut();
		}else{
			prev.fadeIn();
		}
		if(curr_count == max_count - 1){
			next.fadeOut();
		}else{
			next.fadeIn();
		}
		// assign a click to each of the paginations
		$('.pagination a').each(function(e){
			var page = parseInt($(this).text());
				if(curr_count == (page-1)){
					$(this).addClass('activeSlide');
				}
			$(this).click(function(){
				$('#theSlides').cycle((page - 1));
			});
		});

	}
	
	function beforeCycle(curr,next,opts,fwd){
		hideSocialButtons();
		createPagination(curr,next,opts,fwd);
	}
	function hideSocialButtons(){
		$('.theSocialButtons').hide('fast');			
	}
	function showOverFlow(){
		$('.feedBoxes').css('overflow','visible');
	}
	
	function adjustHeight(curr, next, opts, fwd) {
		var $ht = $(this).height();
		$(this).parent().animate({height: $ht},500);
	}		
