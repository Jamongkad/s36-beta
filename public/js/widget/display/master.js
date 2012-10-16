var S36Display = new function() {
    
    var that = this;

    this.load_socialbuttons = function(link, target) {
		if(target.find('.twitter-button').length == 0){

            var twitter = '<a class="twitter-share-button" href="'+link+'" data-url="'+link+'"></a>';
            var facebook = '<div class="facebook-button"><fb:like href="'+link+'" send="false" layout="button_count" width="100" show_faces="false"></fb:like></div>';
			target.html(twitter + facebook);

            console.log(target);
			
            that.load_socialxml();
		}
		target.slideToggle('fast'); 
    },

    this.load_socialxml = function() { 
        twttr.widgets.load(); // parse the twitter widgets
        FB.XFBML.parse();	  // parse the facebook widgets
    },

    this.before_cycle = function(curr, next, opts, fwd) { 
        that.hide_socialbuttons();
	    that.create_pagination(curr, next, opts, fwd);
    },

    this.hide_socialbuttons = function() { 
		$('.theSocialButtons').hide('fast');			
    },

    this.create_pagination = function(curr, next, opts, fwd) {
        
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
		$('.pagination a').each(function(e) {
			var page = parseInt($(this).text());
				if(curr_count == (page-1)){
					$(this).addClass('activeSlide');
				}
			$(this).click(function(){
				$('#theSlides').cycle((page - 1));
			});
		});
    },

    this.show_overflow = function() {
 	    $('.feedBoxes').css('overflow','visible');       
    },

    this.display_solofeedback = function(link) {

        var linky = link;

		$('.theFeedbackText').click(function(){
			var feedid	 = $(this).attr('feed-id');
			var feedback_container = $('#feedbackid-'+feedid);
			var link = linky + '/' + feedid;
			var meta = {
				text 	 : feedback_container.find('.theFullFeedbackText').val(),
				flag 	 : feedback_container.find('.theFullFeedbackText').attr('data-flag'),
				avatar 	 : feedback_container.find('.theFeedbackAvatar img').attr('src'),
				name 	 : feedback_container.find('.theFeedbackAuthorName').html(),
				company  : feedback_container.find('.theFeedbackAuthorCompany').html(),
				location : feedback_container.find('.theFeedbackAuthorLocation').html(),
				date 	 : feedback_container.find('.theFeedbackDate').html(),
                link     : link 
			}			

			$('#theSoloBox').fadeIn('fast');
			$('#theLoopBox').fadeOut('fast');
			$('.thePagination').fadeOut('fast');

            that.transfer_solofeedback_metadata(meta);
		}); 
    },

    this.transfer_solofeedback_metadata = function(meta) {
        
        $('.soloFeedbackText').html(meta.text);	
        $('.soloFeedbackText').jScrollPane();
        $('.soloFeedbackAvatar').find('img').attr('src',meta.avatar);
        $('.soloFeedbackAuthorName').html(meta.name);
        $('.soloFeedbackAuthorCompany').html(meta.company);
        $('.soloFeedbackAuthorLocation').html(meta.location);
        $('.soloFeedbackDate').html(meta.date);
        $('.soloFeedbackAuthor').find('.flag').removeClass().addClass("flag flag-" + meta.flag);
        $('.soloFeedbackSocialButtons .facebook-button').html( 
            '<fb:like href="' + meta.link + '" send="false" layout="button_count" width="100" show_faces="false"></fb:like>'
        );

        var data_text = meta.text.replace(/(<([^>]+)>)/ig,"");
        var twitter = '<a class="twitter-share-button" href="'+meta.link+'" data-url="'+meta.link+'" data-text="'+data_text+'"></a>';
        $('.soloFeedbackSocialButtons .twitter-button').html(twitter);

        that.load_socialxml();
    },

    this.show_sharebuttons = function(link) { 

        var linky = link;

		$('.share').click(function(){
            var feedid = $(this).attr('feed-id');		
			var link = linky + '/' + feedid;
			var social_box = $('#feedbackid-' + feedid).find('.theSocialButtons');

            that.load_socialbuttons(link, social_box);
		});	
    },

    this.sharebutton_hover = function() { 
		$('.theFeedback').hover(function(){
			$(this).find('.share').fadeIn();
		},function(){
			$(this).find('.share').fadeOut('fast');
			$(this).find('.theSocialButtons').fadeOut('fast');
		});
    }
}
