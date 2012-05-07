<div class="feedback <?=$type?>">
    <div class="feedbackContents">
        <div class="feedbackBlock">
            <div class="feedbackAuthor">
                <div class="feedbackAuthorAvatar">
                    <?if($feed->avatar):?>
                        <img src="/uploaded_cropped/150x150/<?=$feed->avatar?>" width="150" height="150" />
                    <?else:?>
                        <img src="/img/blank-avatar.png" width="150" height="150" />
                    <?endif?>
                </div>
                <div class="feedbackAuthorDetails">
                    <h2><?=$feed->firstname?> <?=$feed->lastname?></h2>
                    <h4><?=$feed->position?>, <span><?=$feed->companyname?></span></h4>
                    <p><span style="float:left"><?=$feed->countryname?>, <?=$feed->city?></span>
                       <span class="flag flag-<?=strtolower($feed->countrycode)?>"></span></p>
                    <p><span class="feedbackDate"><?=$feed->date?></span></p>
                </div>
            </div>
            <div class="feedbackText">
                <div class="feedbackTextTail"></div>
                <div class="feedbackTextBubble">
                    <p><?=$feed->text?></p>
                </div>
            </div>
        </div>
        <div class="feedbackBlock">
            <div class="feedbackMeta">
                <div class="feedbackTimestamp">21 minutes ago via <span><a href="#">36Stories</a></span></div> 
                <div class="feedbackSocial">

                    <div class="feedbackSocialTwitter">
                        <a href="<?=URL::to('hosted/single/'.$feed->id)?>" class="twitter-share-button">Tweet</a>
                    </div>
                    <div class="feedbackSocialFacebook">
                    <fb:like href="<?=URL::to('hosted/single/'.$feed->id)?>" send="false" layout="button_count" width="100" show_faces="false"></fb:like>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
