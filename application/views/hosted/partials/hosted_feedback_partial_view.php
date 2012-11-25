<?if($collection):?>
    <?php 
    foreach ($collection as $feed_group => $feed_list) : 
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
        foreach ($feed_list as $feed) :
            $twfeedback = '';
            $class      = '';
            switch ($feed->feed_data->origin) {
                case 's36':
                    if($feed->feed_data->isfeatured == 1){
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
                                        <div class="feedbackSocial">
                                            <div class="">
                                                <a href="/single/<?=$feed->feed_data->id?>" class="twitter-share-button">Tweet</a> 
                                            </div>
                                            <div class="">
                                                <fb:like href="/single/<?=$feed->feed_data->id?>" send="false" 
                                                         layout="button_count" width="100" show_faces="false" style="float:left">
                                                </fb:like>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php
                    break;
                case 'tw':
                    $twfeedback = 'twt-feedback';
                    if($feed->feed_data->isfeatured == 1){
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
<?endif?>
