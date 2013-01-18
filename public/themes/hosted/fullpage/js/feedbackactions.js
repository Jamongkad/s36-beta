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
    }

    this.flag_inapprt = function() {
        $(me.flag).click(function(){
            
            var this_flag = $(this);
            
            $.ajax({
                url: '/feedback_action/flag',
                type: 'post',
                data: {'feedbackId' : this_flag.parents(me.feedback).attr('fid')},
                success: function(result){
                    this_flag.hide().text('Thanks for your flag!').fadeIn();
                }
            });
            
        }); 
    }

    this.vote = function() { 
        $(me.vote).click(function(e){
            
            var this_vote = $(this);
            var vote_count_obj = $(this).parents(me.feedback).find(me.vote_count);
            
            $.ajax({
                url: '/feedback_action/vote',
                type: 'post',
                data: {'feedbackId' : this_vote.parents(me.feedback).attr('fid')},
                success: function(result){
                    $(this_vote).parents(me.feedback).find(me.rating_stat).css('display', 'block');
                    vote_count_obj.hide().text( parseInt(vote_count_obj.text()) + 1 ).fadeIn();
                    $(this_vote).parents(me.feedback).find(me.vote_container).hide().text('Thanks for your vote!').fadeIn();
                }
            });
            e.preventDefault();
        });
    }

    this.share = function() {      
        $(me.share).click(function(){
            
            var fb_like = $(this).parents(me.feedback).find(me.fb_like_dummy);
            var tw_share = $(this).parents(me.feedback).find(me.tw_share_dummy);
            
            if( ! fb_like.is('.fb-like') ){
                fb_like.addClass('fb-like');
                FB.XFBML.parse();
            }
            
            if( ! tw_share.is('.twitter-share-button') ){
                tw_share.addClass('twitter-share-button');
                twttr.widgets.load();
            } 
        });
    }

    this.open_submission_form = function() { 
        $(me.send_button).click(function(){  
            var widgetkey = $(this).attr('widgetkey');
            createLightboxes();
            s36_openLightbox(448, 600, '/widget/widget_loader/' + widgetkey); 
        });
    }
}
