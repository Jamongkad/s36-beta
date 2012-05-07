<?foreach($collection as $coll):?>
    <?if(property_exists($coll, 'head')):?>
        <?=View::make('hosted/partials/hosted_feedback_unit_view', Array('feed' => $coll->head, 'type' => 'featured'))?>
    <?endif?>

    <?foreach($coll->children as $child):?> 
        <div class="feedback normal">
            <div class="feedbackContents">
                <div class="feedbackBlock">
                    <div class="feedbackAuthor">
                        <div class="feedbackAuthorAvatar">
                            <?if($child->avatar):?>
                                <img src="/uploaded_cropped/48x48/<?=$child->avatar?>" width="48" height="48" />
                            <?else:?>
                                <img src="/img/48x48-blank-avatar.jpg" width="48" height="48" />
                            <?endif?>
                        </div>
                        <div class="feedbackAuthorDetails">
                            <h2><?=$child->firstname?> <?=$child->lastname?></h2>
                            <h4><?=$child->position?>, <span><?=$child->companyname?></span></h4>
                            <p><span style="float:left"><?=$child->countryname?>, <?=$child->city?></span>
                               <span class="flag flag-<?=strtolower($child->countrycode)?>"></span></p>
                            <p> <span class="feedbackDate"><?=$child->date?></span></p>
                        </div>
                    </div>
                    <div class="feedbackText">
                        <div class="feedbackTextTail"></div>
                        <div class="feedbackTextBubble">
                            <p><?=$child->text?></p>
                        </div>
                    </div>
                </div>
                <div class="feedbackBlock">
                    <div class="feedbackMeta">
                        <div class="feedbackTimestamp">21 minutes ago via <span><a href="#">36Stories</a></span></div> 
                        <div class="feedbackSocial">
                            <div class="feedbackSocialTwitter"><a href="<?=URL::to('hosted/single/'.$child->id)?>" class="twitter-share-button">Tweet</a></div>
                            <div class="feedbackSocialFacebook">

                            <fb:like href="<?=URL::to('hosted/single/'.$child->id)?>" send="false" layout="button_count" width="100" show_faces="false"></fb:like>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?endforeach?>
<?endforeach?>
