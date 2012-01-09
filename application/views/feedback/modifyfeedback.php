<? $id = $feedback->id ?>
<div class="block noborder">
    <div class="grids">
        <div class="g3of4">
            <div class="permissions <?=$feedback->permission_css?>">
                <h3><?=$feedback->permission?></h3>
                <p>
                    <?=$feedback->firstname?> <?=$feedback->lastname?> has granted you <?=strtolower($feedback->permission)?> to post his/her feedback
                    on your website.
                </p>
            </div>
            <div class="feedback-info">
                <div class="feedback-text">

                    <?=Form::hidden('feed_id', $id, array('id' => 'feed-id'))?>
                    <?=Form::textarea('text', $feedback->text, Array('class' => 'feedback-textarea', 'rows' => 10, 'cols' => 83, 
                                                                      'disabled', 'hrefaction' => URL::to('feedback/edit_feedback_text'))
                     )?>
                </div>
                
                <div class="feedback-status">
                    <div class="grids">
                        <div class="g3of4">
                             <span>Status: </span> <?=$feedback->status?> <span>Priority:</span> <?=$feedback->priority?>
                        </div>
                        <div class="g1of4" style="text-align:right;">
                             <?=HTML::link('/', 'edit feedback', Array('class' => 'edit'))?>
                             <?=HTML::link('/', 'save feedback', Array('class' => 'save'))?>
                        </div>
                    </div>
                </div>
                <div class="feedback-data">
                    <table cellpadding="0">
                        <!--<tr><td width="90">Feedback Form:	</td><td>Testimonial Form</td>-->
                        <tr><td>SITE URL:</td><td><?=$feedback->sitedomain?></td>
                        <!--<tr><td>License:		</td><td>Full license</td>-->
                    </table>
                </div>
            </div>                            
        </div>
        <div class="g1of4">
            <h3>Save this item as feedback</h3>
            <p style="font-size:11px;border-bottom:1px solid #efefef;padding-bottom:12px;">
                Selecting other categories will move this item into the 'Filed Feedback' tab. 
            </p>
            <div class="category-box">
                <ul class="category-box category-picker" id="<?=$feedback->categoryid?>"> 
                  <?foreach($categories as $cat):?>  
                         <li>
                              <?=HTML::link('feedback/changecat/', $cat->name, Array(
                                   'hrefaction' => URL::to('/feedback/change_feedback_state')
                                 , 'class'      => 'cat-picks'.(($feedback->category === $cat->name) ? ' Matched' : Null)
                                 , 'feedid'     => $id
                                 , 'catid'      => $cat->id
                                 , 'cat-state'  => $cat->intname
                                 , 'state'      => 0
                              ))?>
                          </li>
                  <?endforeach?>
                </ul>
                <div>
                    <?=HTML::link('settings', 'manage categories →') ?>
                </div>
            </div>
        </div>
    </div>
</div>
<br />
<!-- end of feedback list -->
<div class="admin-sorter-bar">
        <div class="grids">
            <div class="g4of5">
                <!-- email picker block-->            
                <div class="base-popup fast-forward-holder modify-page" id="<?=$id?>">
                    <div class="popup-arrow"></div>
                    <div class="email-list">
                        <?if($admin_check->ffemail1 || $admin_check->ffemail2 || $admin_check->ffemail3):?>
                        <ul class="email-picker">
                            <?if($admin_check->ffemail1):?>
                                <li id="email1"> 
                                    <?=($admin_check->alias1) ? $admin_check->alias1 : "Name 1"?> : 
                                    <a href="javascript:;"><?=$admin_check->ffemail1?></a> 
                                </li>
                            <?endif?>
                            <?if($admin_check->ffemail2):?>
                                <li id="email2"> 
                                    <?=($admin_check->alias2) ? $admin_check->alias2 : "Name 2"?> : 
                                    <a href="javascript:;"><?=$admin_check->ffemail2?></a> 
                                </li>
                            <?endif?>
                            <?if($admin_check->ffemail3):?>
                                <li id="email3"> 
                                    <?=($admin_check->alias3) ? $admin_check->alias3 : "Name 3"?> : 
                                    <a href="javascript:;"><?=$admin_check->ffemail3?></a> 
                                </li>
                            <?endif?>
                        </ul>
                        <?else:?>
                            <?=HTML::link('settings', 'Configure your fast forward settings')?> 
                        <?endif?>

                        <?=Form::open('feedback/fastforward', 'POST', array('class' => 'ff-form'))?>
                            <?=Form::hidden('email')?>
                            <?=form::hidden('feed_id', $id)?>
                            <div class="ff-forward-to"></div>
                            <div class="popup-border"></div>
                            <?=Form::textarea('email_comment', "(Optional message)", array('class' => 'small popup-textarea'))?>
                            <div class="popup-border"></div>
                            <div class="popup-button">
                                <input type="submit" class="button" value="SEND" />
                            </div>
                        <?=Form::close()?>
                    </div>
                </div> 
                <!-- email picker block-->            

                <div class="feedback-info-menu">
                    <?=HTML::link('feedback/reply_to/'.$id, 'REPLY TO USER', Array('class' => 'replyto'))?>  
                    <?=HTML::link('feedback/fastforward/', 'FORWARD', Array('class' => 'forward', 'id' => $id))?> 
                    <?if($feedback->str_rating != "POOR"):?>
                        <?=HTML::link('feedback/change_state/publish/'.$id, 'PUBLISH', 
                           Array('class' => 'menubtn publish'.(($feedback->ispublished) ? " matched" : null)))?> 
                        <?=HTML::link('feedback/change_state/feature/'.$id, 'FEATURE', 
                           Array('class' => 'menubtn featured'.(($feedback->isfeatured) ? " matched" : null)))?> 
                    <?endif?> 
                    <?=HTML::link('feedback/change_state/flag/'.$id, 'FLAG', 
                       Array('class' => 'flagged'.(($feedback->isflagged) ? " matched" : null), 'state' => $feedback->isflagged))?>
                </div>
            </div>
            <div class="g1of5">
                <div class="feedback-info-menu">
                    <?=HTML::link('/feedback/deletefeedback/'.$id, 'DELETE', Array('class' => 'delete'))?> 
                </div>
            </div>
        </div>
</div>
<div class="block">
    <div class="grids">
        <div class="g1of3">
            <div class="grids">
                <div class="g1of5" style="margin-top:-4px">
                     <?if($feedback->avatar):?> 
                         <?=HTML::image('uploaded_cropped/48x48/'.$feedback->avatar)?>
                     <?else:?>
                         <?=HTML::image('img/48x48-blank-avatar.jpg')?>
                     <?endif?>
                </div>
                <div class="g4of5">
                    <table cellpadding="2" class="feedback-data-table">
                        <tr><td colspan="2" class="header">User Information</td><td></td></tr>
                        <tr><td class="title">Name: </td><td><?=$feedback->firstname?> <?=$feedback->lastname?></td></tr>
                        <tr><td class="title">Email:</td><td><?=$feedback->email?></td></tr>
                        <tr><td class="title">City:</td><td><?=$feedback->city?></td></tr>
                        <tr><td class="title">Country:</td><td><?=$feedback->countryname?></td></tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="g1of3">
                <table cellpadding="2" class="feedback-data-table user-info">
                 <span id="toggle_url" hrefaction="<?=URL::to('/feedback/toggle_feedback_display')?>"></span>
                 <tr><td colspan="2" class="header">Display Information</td><td>display?</td></tr>
                 <tr>
                     <td class="title">Name:</td>
                     <td><?=$feedback->firstname?> <?=$feedback->lastname?></td>
                     <td align="center"><?=Form::checkbox('displayName', $feedback->displayname, ($feedback->displayname ? True : Null))?></td>
                 </tr>
                 <tr>
                     <td class="title">Image:</td>
                     <td><?=($feedback->displayimg) ? "Image displayed" : "Image not displayed"?></td>
                     <td align="center"><?=Form::checkbox('displayImg', $feedback->displayimg, ($feedback->displayimg ? True : Null))?></td>
                 </tr>
                 <tr>
                     <td class="title">Company:</td>
                     <td><?=$feedback->companyname?></td>
                     <td align="center"><?=Form::checkbox('displayCompany', $feedback->displaycompany, ($feedback->displaycompany ? True : Null))?></td>
                 </tr>
                 <tr>
                     <td class="title">Position:</td>
                     <td><?=$feedback->position?></td>
                     <td align="center"><?=Form::checkbox('displayPosition', $feedback->displayposition, ($feedback->displayposition ? True : Null))?></td>
                 </tr>
                 <tr>
                     <td class="title">Website:</td>
                     <td><?=$feedback->url?></td> 
                     <td align="center"><?=Form::checkbox('displayURL', $feedback->displayurl, ($feedback->displayurl ? True : Null))?></td>
                 </tr>
                 <tr>
                     <td class="title">Country:</td>
                     <td><?=$feedback->countryname?> <?=$feedback->countrycode?></td> 
                     <td align="center"><?=Form::checkbox('displayCountry', $feedback->displaycountry, ($feedback->displaycountry ? True : Null))?></td>
                 </tr>
                 <tr>
                     <td class="title">Date:</td>
                     <td><?=$feedback->date?></td> 
                     <td align="center"><?=Form::checkbox('displaySbmtDate', $feedback->displaysbmtdate, ($feedback->displaysbmtdate ? True : Null))?></td>
                 </tr>
                </table>
        </div>
        <div class="g1of3">
                <table cellpadding="2" class="feedback-data-table">
                    <tr><td colspan="2" class="header">User System Information </td></tr>
                    <tr><td class="title">IP Address:</td><td><?=($feedback->ipaddress == 0) ? "N/A" : long2ip($feedback->ipaddress)?></td></tr> 
                    <tr><td class="title">Browser:</td><td><?=($feedback->browser != True) ? "N/A" : $feedback->browser?></td></tr>
                </table>
        </div>
    </div>
</div>
<div class="block" style="background:#babfc2;border-top:1px solid #868f94;">
    <input type="submit" href="#" value="Save Changes" class="newbtn">
    <input type="submit" href="#" value="Cancel" class="newbtn">
</div>
<!-- spacer -->
<div class="block noborder" style="height:100px;">
</div>
<!-- spacer -->
</div>

<!-- end of the main panel -->

<!-- div need to clear floated divs -->
<div class="c"></div>
</div>
