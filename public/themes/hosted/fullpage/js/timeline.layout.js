// share.

$('.share-button').click(function(){
    $(this).find('.share-box').fadeToggle('fast');
});

$('.share-box').hover(function(){},function(){
    $(this).fadeOut('fast');
});



// jquery raty.

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



// description ajax edit.

$('.company-text').hover(
    function(){
        if( $('#desc_textbox_con').css('display') != 'block' ){
            $('.edit').css('display', 'inline-block');
        }
    },
    function(){
        $('.edit').css('display', 'none');
    }
);

$('.edit').click(function(){
    $('.edit').css('display', 'none');
    $('.save, .cancel').css('display', 'inline-block');
    $('#desc_text').css('display', 'none');
    $('#desc_textbox_con').css('display', 'block');
});

$('.cancel').click(function(){
    $('.edit').css('display', 'none');
    $('.save, .cancel').css('display', 'none');
    $('#desc_textbox_con').css('display', 'none');
    $('#desc_text').fadeIn();
    $('#desc_textbox').val( entities2html( br2nl($('#desc_text').html().replace(/\n/g,'')) ) );
});

$('.save').click(function(){
    
    var data = {};
    data['description'] = $('#desc_textbox').val();
    
    $.ajax({
        url: '/update_desc',
        type: 'post',
        data: data,
        success: function(result){
            // if result returned 1, it means he's not logged in.
            if( result == 1 ){
                display_error_mes( ['You should be logged in to do this action'] );
            }else{
                $('#desc_text').html( nl2br( html2entities($('#desc_textbox').val()) ) );
                $('.cancel').trigger('click');
            }
        }
    });
    
});



// feedback actions.

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

$(vote).click(function(e){
    
    e.preventDefault();
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
    
});

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
    
});

$(send_button).click(function(){  
    var widgetkey = $(this).attr('widgetkey');
    createLightboxes();
    s36_openLightbox(448, 600, '/widget/widget_loader/' + widgetkey); 
});

$(document).ready(function(){

	$('.feedback').each(function(){
		var leftOffset = $(this).css('left');
		if(leftOffset == '400px'){
			$(this).css('left','418px');
			$(this).find('.feedback-branch').css({'left':'-31px','top':'40px'});
		}
	});
});
