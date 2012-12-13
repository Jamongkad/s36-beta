<?php
$admin = (!empty($user))? 1 : 0;
/*

/ pull theme information for customed css and js

*/

echo $theme->theme_css;

echo $theme->theme_js;

?>

<?=HTML::script('/js/jquery.raty.min.js')?>




<?php 

/*start document load*/ 

?>

<script type="text/javascript">

$(document).ready(function(){

    

    <?php 

    /* Change fullpage background if set from admin */

    

    if(isset($hosted->background_image) && !empty($hosted->background_image)) { ?>

        $('body').css('background-image','url(uploaded_images/hosted_background/<?=$hosted->background_image?>)')

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
    
    $('.edit').click(function(){
        var parent = $( $(this).attr('for') );
        parent.find('.save, .cancel').css('display', 'inline');
        parent.find('.edit').css('display', 'none');
        parent.find('.textbox_container').css('display', 'block');
        parent.find('.text_container').css('display', 'none');
    });
    
    $('.cancel').click(function(){
        var parent = $( $(this).attr('for') );
        var text_container = parent.find('.text_container');
        var textarea = parent.find('.textbox_container textarea');
        
        parent.find('.save, .cancel').css('display', 'none');
        parent.find('.edit').css('display', 'inline');
        parent.find('.textbox_container').css('display', 'none');
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
                    if( textarea.is('#header_text') ) textarea_value = textarea_value.substr(0, 125);
                    text_container.html( textarea_value );
                    parent.find('.save, .cancel').css('display', 'none');
                    parent.find('.edit').css('display', 'inline');
                    parent.find('.textbox_container').css('display', 'none');
                    text_container.css('display', 'block');
                }
            }
        });
        
    });
    
    // end of description inline editing.
    
});

</script>

<?php 

/*end document load*/ 

?>



<div id="bodyWrapper">

    <div id="bodyContent">

        <!-- new header October 4 2012 -->

        <div id="pageCover">

            <?php if($admin == 1): ?>

            <div id="changeCoverButton">

                <div id="changeButtonText">            

                    Change Cover

                </div>

                <form action="" method="post" enctype="multipart/form-data">

                    <input type="file" id="logoUpload" name="clientLogoImg" style="width:88px;height:18px;position:fixed;z-index:1000;cursor:pointer;opacity:0;" onchange="upload_new_logo()" />

                </form>

            </div>

            

            <div id="saveCoverButton">

                Save Cover

            </div>

            <div id="dragPhoto">

                Drag Image to Reposition Cover

            </div>

            <?php endif; ?>

            

            <div id="theCover" class="draggable">

                <img src="<?=$company->coverphoto_src?>" id="coverPhoto" style="top:<?=$company->coverphoto_top?>px;" />

            </div>

            <div class="social-buttons">

                <ul>

                    <li><a href="https://www.facebook.com/<?=$company->facebook_username?>"><img src="img/facebook.png" title="Visit us on Facebook!" /></a></li>

                    <li><a href="https://www.twitter.com/<?=$company->twitter_username?>"><img src="img/twitter.png" title="Follow us on Twitter!" /></a></li>

                </ul>

            </div>



           

        </div>

        

        <!-- end of page cover -->

        

        <div id="pageDesc">

            <div class="grids">

                <div class="g3of4">
                    
                    <? // intended to be a one-liner. ?>
                    <div class="the-description text_container"><?=$company->description?></div>
                    
                    <? // show the inline editing stuff only if the user is logged in. ?>
                    <?php if( ! is_null( $user ) ): ?>
                        
                        <div class="action_buttons">
                            <span class="edit" for=".g3of4">edit</span>
                            <span class="save" for=".g3of4">save</span>
                            <span class="cancel" for=".g3of4">cancel</span>
                        </div>
                        <div class="textbox_container">
                            <textarea id="description" style="width: 85%;"><?=$company->description?></textarea>
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

        

        <!-- end of new header October 4 2012 --> 
       <div id="pageTitle">
            
            <? // intended to be a one-liner. ?>
            <h1 class="text_container"><?=$hosted->header_text?></h1>
            
            <? // show the inline editing stuff only if the user is logged in. ?>
            <?php if( ! is_null( $user ) ): ?>
                
                <div class="action_buttons">
                    <span class="edit" for="#pageTitle">edit</span>
                    <span class="save" for="#pageTitle">save</span>
                    <span class="cancel" for="#pageTitle">cancel</span>
                </div>
                <div class="textbox_container">
                    <textarea maxlength="125" id="header_text" style="width: 90%;"><?=$hosted->header_text?></textarea>
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
        <?php 
        /*
        /   START FEEDBACK LOOP
        */
        foreach ($feeds as $feed_group=>$feed_list) : 
        ?>
        <div class="feedback-date-block">
            <div class="feedback-date">
                <h2><?=date('M d',$feed_group)?></h2>
                <span><?=ucfirst(Helpers::relative_time($feed_group))?></span>
            </div>
            <div class="feedback-spine"></div>
            <div class="spine-spacer"></div>
            <div class="the-feedbacks">
        <?php /*start feedback info*/ 
            foreach ($feed_list[0] as $feed) :
                $twfeedback = '';
                $class      = '';
                switch ($feed->feed_data->origin) {
                    case 's36':
                        if($feed->feed_data->isfeatured==1){
                            $feed->feed_data->avatar = (!empty($feed->feed_data->avatar)) ? '/uploaded_cropped/150x150/'.$feed->feed_data->avatar : '/img/48x48-blank-avatar.jpg';
                            $avatar = '<img src="'.$feed->feed_data->avatar.'"  class="large-avatar"/>';
                            $class  = 'featured';
                        }
                        else{
                            $feed->feed_data->avatar = (!empty($feed->feed_data->avatar)) ? '/uploaded_cropped/48x48/'.$feed->feed_data->avatar : '/img/48x48-blank-avatar.jpg';
                            $avatar = '<img src="'.$feed->feed_data->avatar.'"  class="small-avatar"/>';   
                            $class  = 'normal';
                        }?>

                            <div class="feedback <?=$class?>">
                                <div class="feedback-branch"></div>
                                <div class="feedbackContents">
                                    <div class="feedbackBlock">
                                        <div class="feedbackAuthor">
                                            <div class="feedbackAuthorAvatar"><?=$avatar?></div>
                                            <div class="feedbackAuthorDetails">
                                                <h2><?=$feed->feed_data->firstname.' '.$feed->feed_data->lastname?></h2>
                                                <p><span style="float:left"><?=$feed->feed_data->countryname?></span><span class="flag flag-<?=strtolower($feed->feed_data->countrycode)?>"></span></p>
                                            </div>
                                        </div>
                                        <div class="feedbackText">
                                            <div class="feedbackTextTail"></div>
                                            <div class="feedbackTextBubble">
                                                <p><?=$feed->feed_data->text?></p>
                                            </div>
                                        </div>
                                        <div class="feedbackDate"><?=date('W F Y',$feed->feed_data->unix_timestamp)?></div>
                                    </div>
                                    <div class="feedbackBlock">
                                        <div class="feedbackMeta">
                                            <!-- <div class="feedbackTimestamp">21 minutes ago via <span><a href="#">36Stories</a></span></div>  -->
                                            <div class="feedbackSocial">
                                                <div class="feedbackSocialTwitter"><a href="http://webmumu.com" class="twitter-share-button">Tweet</a></div>
                                                <div class="feedbackSocialFacebook"><fb:like href="http://dev.gearfish.com/hosted/single/230" send="false" layout="button_count" width="100" show_faces="false" style="float:left"></fb:like></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php
                        break;
                    case 'tw':
                        $twfeedback = 'twt-feedback';
                        if($feed->feed_data->isfeatured==1){
                            $feed->feed_data->avatar = (!empty($feed->feed_data->avatar)) ? $feed->feed_data->avatar : '/img/48x48-blank-avatar.jpg';
                            $avatar = '<img src="'.$feed->feed_data->avatar.'"  class="large-avatar"/>';
                            $class = 'twt-featured';
                        }else{
                            $feed->feed_data->avatar = (!empty($feed->feed_data->avatar)) ? $feed->feed_data->avatar : '/img/48x48-blank-avatar.jpg';
                            $avatar = '<img src="'.$feed->feed_data->avatar.'"  class="small-avatar"/>';
                        }?>

                            <div class="feedback twt-feedback <?php echo $class?>">
                                <div class="feedback-branch"></div>
                                <div class="twitter-marker"></div>
                                <div class="feedbackContents">
                                    <div class="feedbackBlock">
                                        <div class="feedbackAuthor">
                                            <div class="feedbackAuthorAvatar"><?=$avatar?></div>
                                        </div>
                                        <div class="feedbackText">
                                            <div class="feedbackTextTail"></div>
                                            <div class="feedbackTextBubble">
                                                <div class="feedbackAuthorDetails">
                                                    <h2><?=$feed->feed_data->firstname?> <a href="#">@<?=$feed->feed_data->firstname?></h2>
                                                </div>
                                                <div class="feedbackTextContent"><p><?=$feed->feed_data->text?></p></div>
                                                <div class="feedbackDate"><?=date('W F Y',$feed->feed_data->unix_timestamp)?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php
                        break;
                    default:
                        break;
                }
        ?>
        
        <?php endforeach; //end feedback box?>
        <div class="spine-spacer"></div>
        </div>
        <?php endforeach; //end feedback list?>
    <div class="block" style="background:#ececec;text-align:center;font-size:11px;color:#a8a8a8;padding:10px 0px;">Powered by 36Stories</div>
</div>
