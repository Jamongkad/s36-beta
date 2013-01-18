var S36FeedbackActions = new function() {    

    var feedback = '.feedback';  // should be the parent of other vars in its group.
    var flag = '.flag-as';
    var vote_container = '.vote-action';
    var vote = '.vote-action a';
    var vote_count = '.vote_count';
    var rating_stat = '.rating-stat';
    var share = '.share-button';
    var fb_like_dummy = '.fb_like_dummy';  // fb-like
    var tw_share_dummy = '.tw_share_dummy';  // twitter-share-button
    var send_button = '.send-button';

    var me = this;

    this.initialize_actions = function() {
        me.flag_inapprt();
        me.vote();
        me.share();
        me.open_submission_form();
        me.admin_reply();
        me.attachment_controls();
        me.masonry_initialize();
    }

    this.flag_inapprt = function() {
        $(flag).click(function(){
            
            var this_flag = $(this);
            
            $.ajax({
                url: '/feedback_action/flag',
                type: 'post',
                data: {'feedbackId' : this_flag.parents(feedback).attr('fid')},
                success: function(result){
                    this_flag.hide().text('Thanks for your flag!').fadeIn();
                }
            });
            
        }); 
    }

    this.vote = function() { 
        $(vote).click(function(e){
            
            var this_vote = $(this);
            var vote_count_obj = $(this).parents(feedback).find(vote_count);
            
            $.ajax({
                url: '/feedback_action/vote',
                type: 'post',
                data: {'feedbackId' : this_vote.parents(feedback).attr('fid')},
                success: function(result){
                    $(this_vote).parents(feedback).find(rating_stat).css('display', 'block');
                    vote_count_obj.hide().text( parseInt(vote_count_obj.text()) + 1 ).fadeIn();
                    $(this_vote).parents(feedback).find(vote_container).hide().text('Thanks for your vote!').fadeIn();
                }
            });
            e.preventDefault();
        });
    }

    this.share = function() {      
        $(share).click(function(){
     
            var fb_like = $(this).parents(feedback).find(fb_like_dummy);
            var tw_share = $(this).parents(feedback).find(tw_share_dummy);

            if( ! fb_like.is('.fb-like') ){
                fb_like.addClass('fb-like');
                FB.XFBML.parse();
            }
            
            if( ! tw_share.is('.twitter-share-button') ){
                tw_share.addClass('twitter-share-button');
                twttr.widgets.load();
            } 

            $(this).find('.share-box').fadeToggle('fast');
        });
    }

    this.open_submission_form = function() { 
        $(send_button).click(function(){  
            var widgetkey = $(this).attr('widgetkey');
            createLightboxes();
            s36_openLightbox(448, 600, '/widget/widget_loader/' + widgetkey); 
        });
    }

    this.admin_reply = function() {
        /* admin replies */
        $('.adminReply').click(function() {
            var my_parent = $(this).parents('.admin-comment-block');
            $.ajax({
                url: "/admin_reply",
                dataType: "json",
                data: {
                    feedbackId: $(my_parent).find('.admin-comment-id').val(),
                    userId: $(my_parent).find('.admin-user-id').val(),
                    adminReply: $(my_parent).find('.admin-comment-textbox').val()
                },
                type: "POST",
                success: function(result) {
                    if(undefined != result.feedbackid){
                        $(my_parent).find('.admin-comment .admin-message .message').html(result.adminreply);
                        $(my_parent).find('.admin-comment-box').css('display','none');
                        $(my_parent).find('.admin-comment').css('display','block');
                    }
              }
            });
        }); 
    }

    this.attachment_controls = function() { 
        /*lightbox attachment code*/
        $('.uploaded-images-close').click(function(){
            $(this).parent().fadeOut();
        });
        $('.the-thumb,.video-circle').click(function(){
            var scroll_offset = $(document).scrollTop();
            var top_offset = scroll_offset + 100;
            $('.lightbox').fadeIn().css('top',top_offset);
        });
        $('.uploaded-image').click(function(){
            var html = '<img src="'+$(this).find(' .the-thumb .large-image-url').val()+'" width="100%" />';
            $('.uploaded-images-content').html(html);
        });

        $('.video-thumb,.video-circle').click(function(){
            var embed_url = $(this).find('.link-url').val().replace('www.youtube.com/watch?v=','www.youtube.com/embed/');
            var html  = '<iframe width="770" height="400" src="'+embed_url+'" frameborder="0" allowfullscreen></iframe>';
            $('.uploaded-images-content').html(html);
        });
    }

    this.masonry_initialize = function() {
        $('.left-branch, .right-branch').remove();
        $.when($('.feedback-list').masonry({
			itemSelector: '.feedback',
			columnWidth: 100,
			isAnimated: !Modernizr.csstransitions,
            gutterWidth: 365,
			animationOptions: {
				duration: 750,
				easing: 'linear',
				queue: false
			}
		})).then(function() {
            me.add_branches();
        })
        
    }

    this.add_branches = function() { 
        var s = $('.feedback-list').find('.regular');
        $.each(s, function(i, obj){
            var posLeft = $(obj).css("left");
            if(posLeft == "0px"){
                html = "<span class='left-branch'></span>";
                $(obj).prepend(html); 
            }
            else{
                html = "<span class='right-branch'></span>";
                $(obj).prepend(html);
            }
        });
    }
}
