<div class="feedback <?=$type?>">
    <div class="feedbackContents">
        <div class="feedbackBlock">
            <div class="feedbackAuthor">
                <div class="feedbackAuthorAvatar">
                    <?if($type == 'featured'):?>
                        <?if($feed->avatar):?>
                            <img src="/uploaded_cropped/150x150/<?=$feed->avatar?>" width="150" height="150" />
                        <?else:?>
                            <img src="/img/blank-avatar.png" width="150" height="150" />
                        <?endif?>
                    <?else:?>
                        <?if($feed->avatar):?>
                            <img src="/uploaded_cropped/48x48/<?=$feed->avatar?>" width="48" height="48" class="small-avatar"/>
                            <?=HTML::image('uploaded_cropped/150x150/'.$feed->avatar, false, array('class' => 'large-avatar'))?>
                        <?else:?>
                            <img src="/img/48x48-blank-avatar.jpg" width="48" height="48" />
                        <?endif?>
                    <?endif?>
                </div>
                <div class="feedbackAuthorDetails">
                    <h2><?=$feed->firstname?> <?=$feed->lastname?></h2>
                    <h4><?=$feed->position?>, <span><?=$feed->companyname?></span></h4>
                    <p><span style="float:left"><?=$feed->countryname?>, <?=$feed->city?></span>
                       <span class="flag flag-<?=strtolower($feed->countrycode)?>"></span></p> 
                </div>
            </div>
            <div class="feedbackText">
                <div class="feedbackTextTail"></div>
                <div class="feedbackTextBubble">
                    <p><?=$feed->text?></p>
                </div>
            </div>
            <div class="feedbackDate"> 
                <?
                $date = $feed->date;
                $unix = strtotime($date);
                echo date('M j, Y', $unix)?>
            </div>
        </div>
        <div class="feedbackBlock">
            <div class="feedbackMeta"> 
                <div class="feedbackSocial">
                    <div class="feedbackSocialTwitter">
                        <a href="<?=URL::to('single/'.$feed->id)?>" 
                           data-url="<?=URL::to('single/'.$feed->id)?>" 
                           data-text="<?=strip_tags($feed->text)?>"
                           class="twitter-share-button">Tweet</a>
                    </div>
                   <div class="feedbackSocialFacebook">
                   <fb:like href="<?=URL::to('single/'.$feed->id)?>" send="false" layout="button_count" width="100" show_faces="false"></fb:like> 
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
