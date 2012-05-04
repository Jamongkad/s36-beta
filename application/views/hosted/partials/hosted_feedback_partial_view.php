<?foreach($collection as $coll):?>
    <?if(property_exists($coll, 'head')):?>
        <div class="feedback featured">
            <div class="feedbackContents">
                <div class="feedbackBlock">
                    <div class="feedbackAuthor">
                        <div class="feedbackAuthorAvatar">
                            <?if($coll->head->avatar):?>
                                <img src="/uploaded_cropped/150x150/<?=$coll->head->avatar?>" width="150" height="150" />
                            <?else:?>
                                <img src="/img/blank-avatar.png" width="150" height="150" />
                            <?endif?>
                        </div>
                        <div class="feedbackAuthorDetails">
                            <h2><?=$coll->head->firstname?> <?=$coll->head->lastname?></h2>
                            <h4><?=$coll->head->position?>, <span><?=$coll->head->companyname?></span></h4>
                            <p><span style="float:left"><?=$coll->head->countryname?>, <?=$coll->head->city?></span>
                               <span class="flag flag-<?=strtolower($coll->head->countrycode)?>"></span></p>
                            <p> <span class="feedbackDate"><?=$coll->head->date?></span></p>
                        </div>
                    </div>
                    <div class="feedbackText">
                        <div class="feedbackTextTail"></div>
                        <div class="feedbackTextBubble">
                            <p><?=$coll->head->text?></p>
                        </div>
                    </div>
                </div>
                <div class="feedbackBlock">
                    <div class="feedbackMeta">
                        <div class="feedbackTimestamp">21 minutes ago via <span><a href="#">36Stories</a></span></div> 
                        <div class="feedbackSocial">
                            <div class="feedbackSocialTwitter"><a href="http://webmumu.com" class="twitter-share-button">Tweet</a></div>
                            <div class="feedbackSocialFacebook"><iframe src="//www.facebook.com/plugins/like.php?href=http://webmumu.com&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=154673521284687" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                            <div class="feedbackSocialTwitter"><a href="http://webmumu.com" class="twitter-share-button">Tweet</a></div>
                            <div class="feedbackSocialFacebook"><iframe src="//www.facebook.com/plugins/like.php?href=http://webmumu.com&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=154673521284687" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?endforeach?>
<?endforeach?>
