<?php
$admin = (!empty($user))? 1 : 0;
<<<<<<< HEAD
/*pull theme information for customed css and js*/
echo (isset($hosted->theme_css)) ? '<link type="text/css" rel="stylesheet" href="themes/hosted/fullpage/'.$hosted->theme_css.'" />' : null;
echo (isset($hosted->theme_js)) ? '<script type="text/javascript" src="themes/hosted/fullpage/'.$hosted->theme_js.'"></script>' : null;
=======
/*

/ pull theme information for customed css and js

*/

echo $theme->theme_css;

echo $theme->theme_js;

?>

<?=HTML::script('/js/jquery.raty.min.js')?>




<?php 

/*start document load*/ 

>>>>>>> kennwel
?>

<script type="text/javascript">


$(document).ready(function(){
    <?php 
    /* Change fullpage background if set from admin */
    if(isset($hosted->background_image) && !empty($hosted->background_image)):?>
        $('body').css('background-image','url(uploaded_images/hosted_background/<?=$hosted->background_image?>)')
<<<<<<< HEAD
    <?php endif ?>
=======

    <?php } ?>
    
    
    // start of jquery raty.
        
    $('#star_rating').raty({
        path: '/img/',
        hints: ['BAD', 'POOR', 'AVERAGE', 'GOOD', 'EXCELLENT'],
        score: <?php echo round($company->avg_rating); ?>,
        starOn: 'star-on.png',
        starOff: 'star-off.png',
        readOnly: true,
        width: '200px'
    });
    
    // end of jquery raty.
    
    
    // start of description inline editing.
    $('.g3of4, #pageTitle').hover(
        function(){
            if( $(this).find('.textbox_container').css('display') != 'block' ){
                $(this).find('.edit').css('display', 'inline-block');
            }
        },
        function(){
            $(this).find('.edit').css('display', 'none');
        }
    );
    
    $('.edit').click(function(){
        var parent = $( $(this).attr('for') );
        parent.find('.edit').css('display', 'none');
        parent.find('.text_container').css('display', 'none');
        parent.find('.save, .cancel').css('display', 'inline-block');
        parent.find('.textbox_container').css('display', 'block');
    });
    
    $('.cancel').click(function(){
        var parent = $( $(this).attr('for') );
        var text_container = parent.find('.text_container');
        var textarea = parent.find('.textbox_container textarea');
        
        parent.find('.save, .cancel').css('display', 'none');
        parent.find('.textbox_container').css('display', 'none');
        parent.find('.edit').css('display', 'none');
        text_container.css('display', 'block');
        textarea.val( text_container.html() );
    });
    
    $('.save').click(function(){
        
        var parent = $( $(this).attr('for') );
        var text_container = parent.find('.text_container');
        var textarea = parent.find('.textbox_container textarea');
        var textarea_value = textarea.val();
        var data = {};
        
        if( textarea.is('#description') ) data['description'] = textarea_value;
        if( textarea.is('#header_text') ) data['header_text'] = textarea_value;
        
        $.ajax({
            url: '/update_desc_header',
            type: 'post',
            data: data,
            success: function(result){
                // if not result returned 1, it means he's not logged in.
                if( result == 1 ){
                    alert('ei, no way, you should be logged in');
                }else{
                    parent.find('.save, .cancel').css('display', 'none');
                    parent.find('.textbox_container').css('display', 'none');
                    parent.find('.edit').css('display', 'none');
                    text_container.css('display', 'block');
                    
                    if( textarea.is('#header_text') ) textarea_value = textarea_value.substr(0, 125);
                    text_container.html( textarea_value );
                }
            }
        });
        
    });
    
    // end of description inline editing.
    
>>>>>>> kennwel
});
</script>

<div id="bodyWrapper">
    <div id="bodyContent">
        <div id="pageCover" <?=(!$admin and !$company->coverphoto_src) ? "style='height: 40px;'" : null?>>

            <?php if($admin == 1): ?>
                <div id="changeCoverButton">
                    <div id="changeButtonText">            
                        Change Cover
                    </div>
                    <input id="logoUpload" 
                           type="file" 
                           name="clientLogoImg" 
                           data-url="imageprocessing/upload_coverphoto" 
                           style="width:88px;height:18px;position:fixed;z-index:1000;cursor:pointer;opacity:0;" multiple my-fileupload />
                </div>

                <div id="saveCoverButton" save-myupload>
                    Save Cover
                </div>

                <div id="dragPhoto">
                    Drag Image to Reposition Cover
                </div>
            <?php endif; ?>
 
            <div id="theCover" class="draggable">
                <?if($company->coverphoto_src):?>
                     <img src="<?=$company->coverphoto_src?>" id="coverPhoto" style="top:<?=$company->coverphoto_top?>px;" />
                <?else:?>
                     <?if($admin):?>
                         <img src="" id="coverPhoto" />
                         <img src="/img/cover-photo-placeholder.jpg" id="defaultCoverPhoto" width="100%" />
                     <?endif?>
                <?endif;?>
            </div>

            <div class="social-buttons">
                <ul>
                <?
                    
                    if($twitter = $company_social->fetch_social_account('twitter')) {
                        $tw = Helpers::unwrap($twitter->socialaccountvalue);
                        echo '<li><a href="https://www.twitter.com/'.$tw['accountName'].'"><img src="img/twitter.png" title="Follow us on Twitter!" /></a></li>';
                    }

                    if($facebook = $company_social->fetch_social_account('facebook')) {
                        $fb = Helpers::unwrap($facebook->socialaccountvalue);
                        echo '<li><a href="https://www.facebook.com/'.$fb['accountName'].'"><img src="img/facebook.png" title="Visit us on Facebook!" /></a></li>';
                    }
                ?>
                </ul>
            </div>
        </div>
        <!-- end of page cover -->
        <div id="pageDesc">
            <div class="grids">
                <div class="g3of4"> 
                    <div class="the-description text_container"><?=$company->description?></div> 
                    <?php if( ! is_null( $user ) ): ?>
                        
                        <div class="action_buttons">
                            <div class="edit" for=".g3of4" title="Edit"></div>
                            <div class="save" for=".g3of4" title="Save"></div>
                            <div class="cancel" for=".g3of4" title="Cancel"></div>
                        </div>
                        <div class="textbox_container">
                            <textarea id="description"><?=$company->description?></textarea>
                        </div>
                        
                    <?php endif ?> 
                </div>
            
                <div class="g1of4">
                    <div class="send-feedback">
                        <a href="<?=$company->company_name?>/submit"><input type="button" class="funky-button" value="Send in Feedback" /></a>
                    </div>
                </div>
                
                <div id="star_rating_container">
                    <div id="star_rating"></div>
                </div> 
            </div>
        </div>

       <div id="pageTitle">
            
            <? // intended to be a one-liner. ?>
            <h1 class="text_container"><?=$hosted->header_text?></h1>
            
            <? // show the inline editing stuff only if the user is logged in. ?>
            <?php if( ! is_null( $user ) ): ?>
                
                <div class="action_buttons">
                    <div class="edit" for="#pageTitle" title="Edit"></div>
                    <div class="save" for="#pageTitle" title="Save"></div>
                    <div class="cancel" for="#pageTitle" title="Cancel"></div>
                </div>
                <div class="textbox_container">
                    <textarea maxlength="125" id="header_text"><?=$hosted->header_text?></textarea>
                </div>
                
            <?php endif ?>
            
            <div class="meta">
                <?=$feed_count->published_feed_count?> testimonials in total 
                <?if($feed_count->todays_count > 0):?>
                    - <?=$feed_count->todays_count?> were just sent in today.
                <?endif?>
            </div>
        </div>
        <!-- feedbacks are seperated by date which are held inside feedback-date-block container -->
        <?=View::make('hosted/partials/hosted_feedback_partial_view', Array('collection' => $feeds))?>
        <div id="feedback-landing"></div>
        <div class="block" style="background:#ececec;text-align:center;font-size:11px;color:#a8a8a8;padding:10px 0px;">Powered by 36Stories</div>
