<script type="text/javascript">
$(function() { 
    $('.feedback-textarea').tinymce({
        script_url : '<?=URL::to('/')?>js/tiny_mce.js',
        mode : "textareas",
        theme_advanced_font_sizes : "12px,14px,16px,18px,24px"
    });

    $("#date").datepicker({
        dateFormat: "dd-mm-yy"
      , defaultDate: '<?=date("d-m-y", $feedback->unix_timestamp)?>'
      , onSelect: function(dateText, inst) {

            var datetext = dateText;
            
            $.ajax({ 
                type: "POST"     
              , url: '/feedback/change_feedback_date'
              , data: {change_date: datetext, feedback_id: <?=$feedback->id?>}
              , success: function(msg) {
                    var myStatus = new Status();
                    myStatus.notify("Changing Submission Date...", 850);
                }
            })
        }
    });
})
</script>
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
                    <?=Form::textarea('text', $feedback->text, Array('class' => 'feedback-textarea', 'rows' => 10, 'cols' => 83))?>
                </div>
                
                <div class="feedback-status">
                    <div class="grids">
                        <div class="g3of4">
                            <span class="status-change status"> Status: <span class="status-target"><?=$feedback->status?></span>
                                <select style="display:none" name="status" feedid="<?=$id?>" feedurl="<?=URL::to('feedback/changestatus')?>">
                                    <?foreach($status as $option):?>
                                        <?$option_match = str_replace(" ", "", strtolower($option->name));?>  
                                        <option <?=($feedback->status == $option->name) ? 'selected' : null?> value="<?=$option_match?>"><?=$option->name?></option>
                                    <?endforeach?>
                                </select> 
                            </span>

                            <span class="priority-change priority">
                                Priority: <span class="priority-target"><?=$feedback->priority?></span>
                                <select style="display:none" name="priority" feedid="<?=$id?>" feedurl="<?=URL::to('feedback/changepriority')?>">
                                    <?foreach($priority_obj as $key => $val):?>
                                        <option <?=($feedback->priority == $val) ? 'selected' : null?> value="<?=$val?>"><?=$val?></option>
                                    <?endforeach?>
                                </select>
                            </span> 
                        </div>
                        <div class="g1of4" style="text-align:right;">
                             <?=HTML::link('/', 'Save feedback', Array('class' => 'save-feedback-text'))?>
                        </div>
                    </div>
                </div>
                <div class="feedback-data">
                    <span id="indlock_url" hrefaction="<?=URL::to('/feedback/lock_feedback_display')?>"></span>
                    <table cellpadding="0">
                        <!--<tr><td width="90">Feedback Form:	</td><td>Testimonial Form</td>-->
                        <tr><td>SITE URL:</td><td><?=$feedback->sitedomain?></td></tr>
                        <tr><td>DEFAULT DISPLAY RULES:</td><td><?=Form::checkbox('resetIndLock', 1, 
                                                                      ($feedback->indlock ? True : Null))?></td></tr>
                        <!--<tr><td>License:		</td><td>Full license</td>-->
                        <tr><td style="width: 200px">Submission Date:</td><td>
                            <input type="text" name="date_change" 
                                   value="<?=date("d-m-Y", $feedback->unix_timestamp)?>" 
                                   class="regular-text datepicker" id="date" /> (dd-mm-yyyy)
                        </td>
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
                    <?=HTML::link('settings', 'Manage categories →') ?>
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
                <div class="base-popup fast-forward-holder modify-page" style="display:none" id="<?=$id?>">
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
                    <?if($feedback->rating != "POOR" and $feedback->permission_css != 'private-permission'):?>
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
                 <tr><td colspan="2" class="header">Display Information
                 </td><td>Display?</td></tr>
                 <tr>
                     <td class="title">Name:</td>
                     <td><?=$feedback->firstname?> <?=$feedback->lastname?></td>
                     <td align="center"><?=Form::checkbox(
                                               'displayName'
                                             , $feedback->displayname
                                             , ($feedback->displayname ? True : Null)
                                             , Array('disabled' => 'disabled')
                                        )?></td>
                 </tr>
                 <tr>
                     <td class="title">Image:</td>
                     <td><?=($feedback->displayimg) ? "Image displayed" : "Image not displayed"?></td>
                     <?$null_avatar = ($feedback->avatar == false) ? Array('disabled' => 'disabled') : Array();?>
                     <td align="center"><?=Form::checkbox(
                                               'displayImg'
                                             , $feedback->displayimg
                                             , ($feedback->displayimg ? True : Null)
                                             , $null_avatar
                                        )?></td>
                 </tr>
                 <tr>
                     <td class="title">Company:</td>
                     <td><?=$feedback->companyname ?></td>
                     <?$null_company = ($feedback->companyname == false) ? Array('disabled' => 'disabled') : Array();?>
                     <td align="center"><?=Form::checkbox(
                                               'displayCompany'
                                             , $feedback->displaycompany
                                             , ($feedback->displaycompany ? True : Null)
                                             , $null_company
                                        )?></td>
                 </tr>
                 <tr>
                     <td class="title">Position:</td>
                     <td><?=$feedback->position?></td>
                     <?$null_position = ($feedback->position == false) ? Array('disabled' => 'disabled') : Array();?>
                     <td align="center"><?=Form::checkbox(
                                               'displayPosition'
                                             , $feedback->displayposition
                                             , ($feedback->displayposition ? True : Null)
                                             , $null_position
                                        )?></td>
                 </tr>
                 <tr>
                     <td class="title">Website:</td>
                     <td><?=$feedback->url?></td> 
                     <?$null_url = ($feedback->url == false) ? Array('disabled' => 'disabled') : Array();?>
                     <td align="center"><?=Form::checkbox(
                                               'displayURL'
                                             , $feedback->displayurl
                                             , ($feedback->displayurl ? True : Null)
                                             , $null_url
                                        )?></td>
                 </tr>
                 <tr>
                     <td class="title">Country:</td>
                     <td> 
                         <?if($feedback->countryname != "Nil"):?>
                              <?=$feedback->countryname?>
                         <?endif?>
                     </td> 
                     <?$null_country = ($feedback->countryname == "Nil" && $feedback->countrycode == 0) ? Array('disabled' => 'disabled') : Array();?>
                     <td align="center"><?=Form::checkbox(
                                               'displayCountry'
                                             , $feedback->displaycountry
                                             , ($feedback->displaycountry ? True : Null)
                                             , $null_country
                                        )?></td>
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
<!--
<div class="block" style="background:#babfc2;border-top:1px solid #868f94;">
    <input type="submit" href="#" value="Save Changes" class="newbtn">
    <input type="submit" href="#" value="Cancel" class="newbtn">
</div>
-->
<!-- spacer -->
<!--
<div class="block noborder" style="height:10px;">
</div>
-->
<!-- spacer -->
</div>

<!-- end of the main panel -->

<!-- div need to clear floated divs -->
<div class="c"></div>
</div>
