<?php
	$layout = "timeline"; //layout
	$as = false; 		  //set true to admin view
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html ng-app="S36FullPageModule" xmlns:fb="http://ogp.me/ns/fb#">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link type="text/css" rel="stylesheet" href="themes/hosted/fullpage/css/master.css" />
<link type="text/css" rel="stylesheet" href="themes/hosted/fullpage/css/flags.css" />
<link type="text/css" rel="stylesheet" href="themes/hosted/fullpage/css/grids.css" />
<link type="text/css" rel="stylesheet" href="themes/hosted/fullpage/css/override.css" />
<link type="text/css" rel="stylesheet" href="themes/hosted/fullpage/css/<?php echo $layout ?>.layout.css" />

<script type="text/javascript" src="themes/hosted/fullpage/js/jquery.js"></script>
<script type="text/javascript" src="themes/hosted/fullpage/js/masonry.js"></script>
<script type="text/javascript" src="themes/hosted/fullpage/js/modernizr.js"></script>
<script type="text/javascript" src="themes/hosted/fullpage/js/jquery-ui-1.8.24.custom.min.js"></script>
<link type="text/css" rel="stylesheet" href="themes/hosted/fullpage/js/<?php echo $layout ?>.layout.js" />


<!--new ajax file upload plugin -->
<script type="text/javascript" src="js/jquery.iframe-transport.js"></script>
<script type="text/javascript" src="js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="js/jquery.fileupload.js"></script>
<!--new ajax file upload plugin -->

<script src="https://platform.twitter.com/widgets.js" type="text/javascript"></script>
<script src="https://connect.facebook.net/en_US/all.js"></script>
<?= HTML::script('/js/master.js'); ?>
</head>
<body>
<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function() {
            // init the FB JS SDK
        FB.init({
            appId      : '<?=Config::get('application.fb_id');?>', // App ID from the App Dashboard
            status     : true, // check the login status upon init?
            cookie     : true, // set sessions cookies to allow your server to access the session?
            xfbml      : true  // parse XFBML tags on this page?
        });
    };

    (function(d, debug){
        var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement('script'); js.id = id; js.async = true;
        js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";
        ref.parentNode.insertBefore(js, ref);
    }(document, /*debug*/ false))
</script>

<script type="text/javascript">
		
	$(document).ready(function(){

        reload_masonry();

	    var counter = 0;	
        function update() {
		   if($(window).scrollTop() + $(window).height() == $(document).height()) {
                counter += 1;
                var page_counter = counter + 1;
		        var container = $('#feedback-infinitescroll-landing'); 
                $.ajax({ 
                    url: '/hosted/fullpage_partial/' + page_counter
                  , success: function(msg) { 
                      var boxes = $(msg);
                      container.append(boxes);
                      reload_masonry();
                      twttr.widgets.load();
                      FB.XFBML.parse();
                    }
                });
		   }
		}
        //rate limit this bitch
        var throttled = _.throttle(update, 800);
		$(window).scroll(throttled);

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
	});


    //exclusive for timeline layout 
    function reload_masonry() {
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
            add_branches();
        })
    }

    function add_branches(){ 
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
</script>
