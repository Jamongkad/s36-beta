<div class="feedback <?=$type?>">
    <div class="feedbackContents">
        <div class="feedbackBlock">
            <div class="feedbackAuthor">
                <div class="feedbackAuthorAvatar">
                    <?if($type == 'featured'):?>
                        <?if($feed->displayimg):?>
                            <?if($feed->avatar):?>
                                <img src="/uploaded_cropped/150x150/<?=$feed->avatar?>"  />
                            <?else:?>
                                <img src="/img/blank-avatar.png" />
                            <?endif?>
                        <?else:?>
                            <img src="/img/blank-avatar.png" />
                        <?endif?>
                    <?else:?>
                        <?if($feed->avatar):?>
                            <img src="/uploaded_cropped/48x48/<?=$feed->avatar?>"  class="small-avatar"/>
                            <?=HTML::image('uploaded_cropped/150x150/'.$feed->avatar, false, array('class' => 'large-avatar'))?>
                        <?else:?>
                            <img src="/img/48x48-blank-avatar.jpg" />
                        <?endif?>
                    <?endif?>
                </div>
                <?php
                    $comp = null;        
                    if($feed->displaycompany) {
                        if($feed->companyname && $feed->position) {
                            $comp = ucwords($feed->companyname).', '."<span>".ucwords($feed->position)."</span>";
                        }

                        if($feed->companyname && $feed->position == false) {
                            $comp = ucwords($feed->companyname); 
                        }

                        if($feed->companyname == false && $feed->position) {
                            $comp = "<span>".ucwords($feed->position)."</span>";
                        } 
                    } 
                ?>
                <?php 
                    $location = null;
                    if($feed->displaycountry) { 
                        if($feed->countryname && $feed->city) {
                            $location = $feed->countryname.', '.$feed->city;
                        }

                        if($feed->countryname && $feed->city == false) {
                            $location = $feed->countryname; 
                        }

                        if($feed->countryname == false && $feed->city) {
                            $location = $feed->city;
                        }
                    }
                ?>
                <div class="feedbackAuthorDetails">
                    <h2><?=$feed->firstname?> <?=$feed->lastname?></h2>
 
                    <?if($comp):?>
                        <h4><?=$comp?></h4>
                    <?endif?>

                    <p>
                        <?if($location):?>
                            <span style="float:left">
                                <?=$location?>
                            </span>
                        <?endif?>

                        <?if($feed->displaycountry):?>
                           <?if($feed->countrycode):?>
                               <span class="flag flag-<?=strtolower($feed->countrycode)?>"></span>
                           <?endif?>
                        <?endif?>

                    </p> 
                </div>
            </div>
            <div class="feedbackText">
                <div class="feedbackTextTail"></div>
                <div class="feedbackTextBubble">
                    <p><?=$feed->text?></p>
                </div>
            </div>
            <div class="feedbackDate"> 
                <?if($type == 'featured'):?>
                    <div class="feedbackSocialView" style="float:left;padding-right:10px">
                        <?=HTML::link('single/'.$feed->id, 'view feedback')?>
                    </div>
                <?endif?>
                <?if($feed->displaysbmtdate):?>
                    <?=date('M j, Y', strtotime($feed->date))?>
                <?endif?>
            </div>
        </div>
        <?php
            $maxchars = 74;							
            $text = strip_tags($feed->text);
            if(strlen(trim($text)) <= $maxchars){
                $text = $text;
            }else{
                $text = substr($text, 0, $maxchars)."...";
            }							
        ?>
        <div class="feedbackBlock">
            <div class="feedbackMeta"> 
                <div class="feedbackSocial">
                    <div class="feedbackSocialTwitter">
                        <a href="<?=URL::to('single/'.$feed->id)?>" 
                           data-url="<?=URL::to('single/'.$feed->id)?>" 
                           data-text="<?=$text?>"
                           class="twitter-share-button">Tweet</a>
                    </div>
                   <div class="feedbackSocialFacebook">
                   <fb:like href="<?=URL::to('single/'.$feed->id)?>" send="false" layout="button_count" width="100" show_faces="false"></fb:like> 
                   </div>
                </div>
                <?if($type != 'featured'):?>
                    <div class="feedbackSocialView" style="float:right;top:3px;">
                        <?=HTML::link('single/'.$feed->id, 'view feedback')?>
                    </div>
                <?endif?>
            </div>
        </div>
    </div>
</div>
