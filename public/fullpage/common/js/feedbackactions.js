var S36FeedbackActions = new function() {    

    var feedback = '.feedback';  // should be the parent of other vars in its group.
    var flag = '.flag-as';
    var undo_flag = '.undo_flag';
    var vote_container = '.vote-action';
    var vote = '.vote-action a';
    var undo_vote = '.undo_vote';
    var vote_count = '.vote_count';
    var rating_stat = '.rating-stat';
    var share = '.share-button';
    var fb_like_dummy = '.fb_like_dummy';  // fb-like
    var tw_share_dummy = '.tw_share_dummy';  // twitter-share-button
    var send_button = '.send-button';

    var me = this;
    var common = new S36FullpageCommon;

    this.initialize_actions = function(layoutObj) {
        me.flag_inapprt();
        me.undo_flag();
        me.vote();
        me.undo_vote();
        me.share();
        me.open_submission_form();
        me.admin_reply();
        me.attachment_controls();
        //me.masonry_initialize();
        common.reload_layout_masonry(layoutObj);
        Helpers.close_lightbox();
        $('.star_rating').raty({
            hints: ['BAD', 'POOR', 'AVERAGE', 'GOOD', 'EXCELLENT'],
            score: function(){
                return $(this).attr('rating');
            },
            path: '/img/',
            starOn: 'star-fill.png',
            starOff: 'star-empty.png',
            readOnly: true
        });
    }

    this.flag_inapprt = function() {
        $(flag).unbind('click.flag_inapprt').bind('click.flag_inapprt', function(e) {
            
            var this_flag = $(this);
            
            $.ajax({
                url: '/feedback_action/flag',
                type: 'post',
                data: {'feedbackId' : this_flag.parents(feedback).attr('fid')},
                success: function(result){
                    this_flag.addClass('hidden');
                    this_flag.parents(feedback).find(undo_flag).removeClass('hidden');
                }
            });

            e.preventDefault();
            
        }); 
    }
    
    this.undo_flag = function(){
        $(undo_flag).unbind('click.undo_flag').bind('click.undo_flag', function(e) {
            var this_undo = $(this);
            $.ajax({
                url: '/feedback_action/unflag',
                type: 'post',
                data: {'feedbackId' : this_undo.parents(feedback).attr('fid')},
                success: function(){
                    this_undo.addClass('hidden');
                    this_undo.parents(feedback).find(flag).removeClass('hidden');
                }
            });
            e.preventDefault();
        });
    }

    this.vote = function() { 
        $(vote).unbind('click.vote_feedback').bind('click.vote_feedback', function(e) {
            
            var this_vote = $(this);
            var vote_count_obj = $(this).parents(feedback).find(vote_count);
            
            $.ajax({
                url: '/feedback_action/vote',
                type: 'post',
                data: {'feedbackId' : this_vote.parents(feedback).attr('fid')},
                success: function(result){
                    this_vote.parents(feedback).find(rating_stat).css('display', 'block');
                    vote_count_obj.hide().text( parseInt(vote_count_obj.text()) + 1 ).fadeIn();
                    
                    this_vote.parents(feedback).find(vote_container).addClass('hidden');
                    this_vote.parents(feedback).find(undo_vote).removeClass('hidden');
                }
            });
            e.preventDefault();
        });
    }
    
    this.undo_vote = function(e){
        $(undo_vote).unbind('click.undo_vote').bind('click.undo_vote', function(e) {
            var this_undo = $(this);
            var vote_count_obj = $(this).parents(feedback).find(vote_count);
            $.ajax({
                url: '/feedback_action/unvote',
                type: 'post',
                data: {'feedbackId' : this_undo.parents(feedback).attr('fid')},
                success: function(){
                    vote_count_obj.hide().text( parseInt(vote_count_obj.text()) - 1 ).fadeIn();
                    if( vote_count_obj.text() == '0' ) this_undo.parents(feedback).find(rating_stat).fadeOut();
                    
                    this_undo.parents(feedback).find(vote_container).removeClass('hidden');
                    this_undo.addClass('hidden');
                }
            });
            e.preventDefault();
        });
    }

    this.share = function() {      
        $(share).unbind('click.share_feedback').bind('click.share_feedback', function(e) {
     
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

            $(this).find('.share-box').fadeIn('fast').hover(function() { 
                fb_like.addClass('fb-like');
            }, function() {
                $(this).fadeOut('fast');
            });

            e.preventDefault();
        });
    }

    this.open_submission_form = function() { 
        $(send_button).unbind('click.open_form').bind('click.open_form', function(e) {  
            var widgetkey = $(this).attr('widgetkey');
            createLightboxes();
            s36_openLightbox(448, 600, '/widget/widget_loader/' + widgetkey); 

            e.preventDefault();
        });
    }

    this.admin_reply = function() {
        /* admin replies */
        $('.adminReply').unbind('click.admin_reply').bind('click.admin_reply', function(e) {
            var my_parent = $(this).parents('.admin-comment-block');
            var admin_reply = {
                feedbackId: $(my_parent).find('.admin-comment-id').val(),
                userId: $(my_parent).find('.admin-user-id').val(),
                adminReply: $(my_parent).find('.admin-comment-textbox').val()
            };

            if($.trim($(my_parent).find('.admin-comment-textbox').val()).length > 0) {
                $.ajax({
                    url: "/admin_reply",
                    dataType: "json",
                    data: admin_reply,
                    type: "POST",
                    success: function(result) {
                        if(undefined != result.feedbackid){
                            $(my_parent).find('.admin-comment .admin-message .message').html(result.adminreply);
                            $(my_parent).find('.admin-comment-box').css('display','none');
                            $(my_parent).find('.admin-comment').css('display','block');
                        }
                  }
                });
            } else {
                Helpers.display_error_mes(['Cannot be blank.']); 
            }  

            e.preventDefault();
        }); 
        
        //we do this to prevent multiple event bindings from happening
        $('.admin-delete-reply').unbind('click.delete_admin').bind('click.delete_admin', function(e) {
            var feedid = $(this).attr('feedid');
            var me = $(this);
            $.ajax({
                url: "/delete_admin_reply/" + feedid
              , type: "GET"
              , success: function(result) {
                    me.parents('.admin-comment').hide();
                    $('.admin-comment-box[feedid=' + feedid + ']').removeAttr('style');
                    $('.admin-comment-box[feedid=' + feedid + '] textarea').val("");
                }
            });
            e.preventDefault();
        });
    }

    this.attachment_controls = function() { 
        /*lightbox attachment code*/
        $('.uploaded-images-close').unbind('click.upload_images_close').bind('click.upload_images_close', function(e) {
            $(this).parent().fadeOut();
            e.preventDefault();
        });

        $('.the-thumb, .video-circle').unbind('click.video_link').bind('click.video_link', function(e) {
            var scroll_offset = $(document).scrollTop();
            var top_offset = scroll_offset + 100;
            $('.lightbox').fadeIn().css('top',top_offset);
            e.preventDefault();
        });

        $('.uploaded-image').unbind('click.upload_image_open').bind('click.upload_image_open', function(e) {
            var html = '<img src="'+$(this).find(' .the-thumb .large-image-url').val()+'" width="100%" />';
            $('.uploaded-images-content').html(html);
            e.preventDefault();
        });

        $('.video-thumb,.video-circle').unbind('click.video_link_open').bind('click.video_link_open', function(e) {
            var embed_url = $(this).find('.link-url').val().replace('www.youtube.com/watch?v=','www.youtube.com/embed/');
            var html  = '<iframe width="770" height="400" src="'+embed_url+'" frameborder="0" allowfullscreen></iframe>';
            $('.uploaded-images-content').html(html);
            e.preventDefault();
        });
    }

    /*this.masonry_initialize = function() {
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
        
    }*/

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
