var S36FeedbackActions = new function() {    

    var feedback = '.feedback';  // should be the parent of other vars in its group.
    //var flag = '.flag-as';
    var flag = '.flag-as-inapp';
    //var undo_flag = '.undo_flag';
    var undo_flag = '.undo_flag_inapp';
    var vote_container = '.vote-action';
    var vote = '.vote-action a';  // text type 
    //var vote = '.vote-action';  // icon type
    var undo_vote = '.undo_vote';
    var vote_count = '.vote_count';
    var rating_stat = '.rating-stat';
    //var share = '.share-button';
    var share = '.share-icon';
    var fb_like_dummy = '.fb_like_dummy';  // fb-like
    var tw_share_dummy = '.tw_share_dummy';  // twitter-share-button
    var send_button = '.send-button';

    var me = this;
    //var common = new S36FullpageCommon;

    this.initialize_actions = function(layoutObj, common) {
        me.feedback_report_fancy();
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
    
    this.vertically_center_attachments = function(){
        $('.uploaded-image').not('.adjusted').each(function(){
            var uploaded_image_h = $(this).height();
            var att_container_h = $(this).find('.att_container').height();
            var att_container = $(this).find('.att_container');
            
            if( att_container_h > uploaded_image_h ){
                att_container.css('margin-top', -((att_container_h - uploaded_image_h) / 2));
            }
            $(this).addClass('adjusted');
        });
    }

    /*
    | Start Feedback Flag Actions
    */
    var validateEmail = new function(email){
        this.valid = function(email){
                if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){
                return true;
                }else{
                return false;}
        }
    }
    var FormValidateReport = new function() {
        this.getFeedbackId = function(){
            return $('#flagBox .flag-feedback-id').val();
        }
        this.setDefaults = function(){
                $('#flagBoxDiv').hide();
                $('.fancybox-inner #report_name').val('');
                $('.fancybox-inner #report_email').val('');
                $('.fancybox-inner #report_company').val('');
                $('.fancybox-inner #report_comment').val('');
                $('.fancybox-inner .continue_report').removeClass('continue_report_user');
                $('.fancybox-inner #flagBox #report_type_list').show();
                $('.fancybox-inner #flagBox #report_user_info').hide();
                $('.fancybox-inner .alert-message').hide();
                //$('input:radio[name=flag-item]').attr('checked',false);
        }

        this.validate = function() {
                var report_type = $(".fancybox-inner .feedbackReportItem:checked").val();
                var get_report_user = $('.fancybox-inner .continue_report').hasClass('continue_report_user');
                if(report_type != undefined){
                    if(get_report_user){
                            var report_name     = $('.fancybox-inner #report_name');
                            var report_email    = $('.fancybox-inner #report_email');
                            var report_company  = $('.fancybox-inner #report_company');
                            var report_comment  = $('.fancybox-inner #report_comment');
                            $('.fancybox-inner .alert-message').hide();

                            if(report_name.val()==''){
                                $('.fancybox-inner .alert-message').html(
                                    '<div class="warning">Please enter your name</div>'
                                );
                                $('.fancybox-inner .alert-message').show();
                                return false;
                            }
                            else if(report_email.val()==''){
                                $('.fancybox-inner .alert-message').html(
                                    '<div class="warning">Please enter your email address</div>'
                                );
                                $('.fancybox-inner .alert-message').show();
                                return false;
                            }
                            else if(report_email.val() !='' && !validateEmail.valid(report_email.val())){
                                $('.fancybox-inner .alert-message').html(
                                    '<div class="warning">Please enter a valid email address</div>'
                                );
                                $('.fancybox-inner .alert-message').show();
                                return false;
                            }
                            else{
                                $('.fancybox-inner .continue_report').removeClass('continue_report_user');
                                return true;
                            }
                    }else{
                            return true;
                    }
                }else{
                        $('.fancybox-inner .alert-message').html(
                            '<div class="warning">Please select a report option below</div>'
                        );
                        $('.fancybox-inner .alert-message').show();
                        return false;
                    }
                }
    }

    this.feedback_report_fancy = function(){
        $(".flag-feedback-fancy").fancybox({
            'scrolling'         : 'no',
            'overlayOpacity'    : 0.1,
            'showCloseButton'   : false,
            'content'           : $('#flagBoxDiv').html()
        });
    }

    $(document).delegate('.flag-as-inapp', 'click', function(){
        $('#flagBox .flag-feedback-id').val($(this).parent().attr('fid'));
    });

    $(document).delegate('.undo_flag_inapp', 'click', function(){
        var this_undo = $(this);
        $.ajax({
            url: '/feedback_action/unflag',
            type: 'post',
            dataType: 'json',
            data: {'feedback_id' : this_undo.parents(feedback).attr('fid')},
            success: function(result){
                if(result.success==true){
                    this_undo.addClass('flag-as-inapp');
                    this_undo.removeClass('undo_flag_inapp active-icon');
                    this_undo.parent().find('.icon-tooltip-text').text('Flag as Inappropriate');
                    this_undo.parent().addClass('flag-feedback-fancy');
                }
                else{
                    console.log('unflag feedback failed');
                }
            }
        });
        return false;
    });

    $(document).delegate('.reportTypeLabel', 'click', function(){
        $('input:radio[name=flag-item]'+'.'+this.id).attr('checked',true);
    });

    $(document).delegate('#back_report', 'click', function(){
        $('#flagBox #report_type_list').show();
        $('#flagBox #report_user_info').hide();
        FormValidateReport.setDefaults();
    });
    

    $(document).delegate('.fancybox-inner .continue_report', 'click', function(){
        var report_type = $(".fancybox-inner .feedbackReportItem:checked").val();
        if(report_type=='7' && !$('.fancybox-inner .continue_report').hasClass('continue_report_user')){
            $('.fancybox-inner #report_type_list').hide();
            $('.fancybox-inner #report_user_info').show();
            $('.fancybox-inner .continue_report').addClass('continue_report_user');
            $('.fancybox-inner .alert-message').hide();
            return false;
        }
        if(FormValidateReport.validate()){
            var report_user_info = '';
            if(report_type=='7'){
                var report_user_info = {
                    name        : $('.fancybox-inner #report_name').val(),
                    email       : $('.fancybox-inner #report_email').val(),
                    company     : $('.fancybox-inner #report_company').val(),
                    comments    : $('.fancybox-inner #report_comment').val()
                }
            }
            var report_data = {
                feedback_id     :FormValidateReport.getFeedbackId(),
                report_type     :$(".fancybox-inner .feedbackReportItem:checked").val(),
                report_user     :report_user_info
            }

            $.ajax({
                    url: '/feedback_action/report_feedback',
                    type: 'post',
                    dataType: 'json',
                    data: report_data,
                    success: function(result){
                        if(result.success==true){
                            var this_flag = $('#flag-feedback-icon-'+FormValidateReport.getFeedbackId());
                            this_flag.addClass('undo_flag_inapp active-icon');
                            this_flag.removeClass('flag-as-inapp');
                            this_flag.parent().find('.icon-tooltip-text').text('Undo flag');
                            this_flag.parent().removeClass('flag-feedback-fancy');
                            $('.fancybox-inner .alert-message').html(
                                '<div class="success">Your feedback report has been submitted</div>'
                            );
                            $('.fancybox-inner .flagbox-body').hide();
                            $('.fancybox-inner .alert-message').show();
                            $('.fancybox-inner #report_final').fadeIn();
                        }else{
                            $('.fancybox-inner .alert-message').html(
                                '<div class="error">Feedback report was not submitted</div>'
                            );
                            $('.fancybox-inner .flagbox-body').hide();
                            $('.fancybox-inner .alert-message').show();
                            $('.fancybox-inner #report_final').fadeIn();
                        }
                    }
            });
        }   
    });

    /*
    | End Feedback Flag Actions
    */
    this.vote = function() { 
        $(vote).unbind('click.vote_feedback').bind('click.vote_feedback', function(e) {
            e.preventDefault();
            
            if( $(this).is('.off') ) return;
            $(this).addClass('off');
            
            var this_vote = $(this);
            var vote_count_obj = $(this).parents(feedback).find(vote_count);
            
            $.ajax({
                url: '/feedback_action/vote',
                type: 'post',
                data: {'feedbackId' : this_vote.parents(feedback).attr('fid')},
                success: function(result){
                    // increment the vote count.
                    this_vote.parents(feedback).find(rating_stat).css('display', 'block');
                    vote_count_obj.hide().text( parseInt(vote_count_obj.text()) + 1 ).fadeIn();
                    
                    // action for icon type.
                    //this_vote.addClass('active-icon');
                    //this_vote.parent().find('.icon-tooltip-text').text('You found this useful');
                    
                    // action for text type.
                    this_vote.parents(feedback).find(vote_container).hide();
                    //this_vote.parents(feedback).find(undo_vote).show();  // don't show the undo text.
                }
            });
        });
    }
    
    this.undo_vote = function(e){
        $(undo_vote).unbind('click.undo_vote').bind('click.undo_vote', function(e) {
            e.preventDefault();
            var this_undo = $(this);
            var vote_count_obj = $(this).parents(feedback).find(vote_count);
            var this_vote = $(this).parent().find(vote);
            $.ajax({
                url: '/feedback_action/unvote',
                type: 'post',
                data: {'feedbackId' : this_undo.parents(feedback).attr('fid')},
                success: function(){
                    vote_count_obj.hide().text( parseInt(vote_count_obj.text()) - 1 ).fadeIn();
                    if( vote_count_obj.text() == '0' ) this_undo.parents(feedback).find(rating_stat).fadeOut();
                    
                    this_undo.parents(feedback).find(vote_container).show();
                    this_undo.hide();
                    this_vote.removeClass('off');
                }
            });
        });
    }

    this.share = function() {
        $(share).unbind('click.share_feedback').bind('click.share_feedback', function(e) {
            
            var this_share = $(this);
            var fb_like = $(this).parents(feedback).find(fb_like_dummy);
            var tw_share = $(this).parents(feedback).find(tw_share_dummy);
            
            if( ! this_share.is('.active-icon') ) $(this).addClass('active-icon');
            else this_share.removeClass('active-icon');

            if( ! fb_like.is('.fb-like') ){
                fb_like.addClass('fb-like');
                FB.XFBML.parse();
            }
            
            if( ! tw_share.is('.twitter-share-button') ){
                tw_share.addClass('twitter-share-button');
                twttr.widgets.load();
            } 
            
            $(this).parents(feedback).find('.share-box').toggle().hover(function(){},function(){
                $(this).fadeOut('fast');
                this_share.removeClass('active-icon');
            });
            
            /*
            $(this).find('.share-box').fadeIn('fast').hover(function() {
                fb_like.addClass('fb-like');
            }, function() {
                $(this).fadeOut('fast');
            });
            */

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

        $('.video-thumb, .video-circle').unbind('click.video_link_open').bind('click.video_link_open', function(e) {
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

