<?foreach($collection as $coll):?>
    <?if(property_exists($coll, 'head')):?>
        <div class="feedback featured">
            <div class="feedbackContents">
                <div class="feedbackBlock">
                    <div class="feedbackAuthor">
                        <div class="feedbackAuthorAvatar"><img src="/img/<?=$coll->avatar?>" width="150" height="150" /></div>
                        <div class="feedbackAuthorDetails">
                            <h2><?=$coll->firstname?> <?=$coll->lastname?></h2>
                            <h4><?=$coll->position?>, <span><?=$coll->companyname?></span></h4>
                            <p><span style="float:left"><?=$coll->countryname?>, <?=$coll->city?></span>
                               <span class="flag flag-<?=strtolower($coll->countrycode)?>"></span></p>
                            <p> <span class="feedbackDate"><?=$coll->date?></span></p>
                        </div>
                    </div>
                    <div class="feedbackText">
                        <div class="feedbackTextTail"></div>
                        <div class="feedbackTextBubble">
                            <p><?=$coll->text?></p>
                        </div>
                    </div>
                </div>
                <div class="feedbackBlock">
                    <div class="feedbackMeta">
                        <div class="feedbackTimestamp">21 minutes ago via <span><a href="#">36Stories</a></span></div> 
                        <div class="feedbackSocial">
                            <div class="feedbackSocialTwitter"><a href="http://webmumu.com" class="twitter-share-button">Tweet</a></div>
                            <div class="feedbackSocialFacebook"><iframe src="//www.facebook.com/plugins/like.php?href=http://webmumu.com&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=154673521284687" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?endif?>
    <ul>
    <?//foreach($coll->children as $child):?>
        <li><?//=$child?></li>
    <?//endforeach?>
    </ul>
<?endforeach?>
