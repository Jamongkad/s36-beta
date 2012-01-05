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

            <? $id = $feedback->id ?>
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
                <ul class="category-box">
                  
                  <?foreach($categories as $cat):?>  
                     <li><a href="#" <?=($feedback->category === $cat->name) ? 'class="Matched"' : Null?>><?=$cat->name?></a></li>
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
                <div class="feedback-info-menu">
                    <?=HTML::link('feedback/reply_to/'.$id, 'REPLY TO USER', Array('class' => 'menubtn replyto'))?>  
                    <?=HTML::link('feedback/reply_to/'.$id, 'FORWARD', Array('class' => 'menubtn forward'))?> 
                    <?if($feedback->str_rating != "POOR"):?>
                        <?=HTML::link('feedback/change_state/publish/'.$id, 'PUBLISH', Array('class' => 'menubtn publish'))?> 
                        <?=HTML::link('feedback/change_state/feature/'.$id, 'FEATURE', Array('class' => 'menubtn feature'))?> 
                    <?endif?> 
                    <?=HTML::link('feedback/change_state/flag/'.$id, 'FLAG', Array('class' => 'menubtn flag'))?>
                </div>
            </div>
            <div class="g1of5">
                <div class="feedback-info-menu">
                    <?=HTML::link('/feedback/deletefeedback/'.$id, 'DELETE', Array('class' => 'menubtn delete'))?> 
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
                    <tr><td class="title">IP Address:</td><td><?=($feedback->ipaddress == 0) ? "N/A" : $feedback->ipaddress?></td></tr> 
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

<!--
<? $id = $feedback->id ?>
<?=Form::hidden('feed_id', $id, array('id' => 'feed-id'))?>
<h3>Feedback Information</h3>
<div class="grids">
    <div class="grids">
        <div class="g1of2">
             <div style="float:left; padding-top:5px; padding-right:5px">
                 <?if($feedback->avatar):?> 
                     <?=HTML::image('uploaded_cropped/48x48/'.$feedback->avatar)?>
                 <?else:?>
                     <?=HTML::image('img/48x48-blank-avatar.jpg')?>
                 <?endif?>
             </div>
             <div class="head" style="margin-top:6px;">Entry by <?=$feedback->firstname?> <?=$feedback->lastname?></div>
             <br/>
             <?=Form::textarea('text', $feedback->text, Array('class' => 'feedback-textarea', 'rows' => 10, 'cols' => 83, 
                                                              'disabled', 'hrefaction' => URL::to('feedback/edit_feedback_text'))
             )?><br/>
             <?=HTML::link('/', 'edit', Array('class' => 'edit'))?>
             <?=HTML::link('/', 'save', Array('class' => 'save'))?>
        </div> 

        <div class="g1of2">

             <div>
                 <div class="save-head">
                 Select a Category for this feedback. 
                 <select name="category">
                     <option>--</option>
                     <?foreach($categories as $cat):?>  
                         <option <?=($feedback->category === $cat->name) ? 'selected' : Null?>><?=$cat->name?></option> 
                     <?endforeach?>
                 </select>
                 </div>
             </div>

        </div>

    </div>

    <div>
        <div>Status: <?=$feedback->status?> Priority: <?=$feedback->priority?></div>
        <?=HTML::link('feedback/reply_to/'.$feedback->id, 'Reply to User')?> | 
        <?=HTML::link('/', 'Forward')?> | 
        <?if($feedback->str_rating != "POOR"):?>
            <?=HTML::link('feedback/change_state/publish/'.$id, 'Publish')?> |
            <?=HTML::link('feedback/change_state/feature/'.$id, 'Feature')?> |
        <?endif?>
        <?=HTML::link('feedback/change_state/flag/'.$id, 'Flag') ?> |
        <?=HTML::link('/feedback/deletefeedback/'.$id, 'Delete')?> 
    </div>

    <div class="grids">
        <div class="g1of3">
             <div class="head">User Information</div>
             <table class="user-info">
                 <tr><td>First Name:</td><td><?=$feedback->firstname?></td></tr>
                 <tr><td>Last Name:</td><td><?=$feedback->lastname?></td></tr>
                 <tr><td>Email Address:</td><td><?=$feedback->email?></td></tr>
                 <tr><td>Time Sent:</td><td><?=$feedback->date?></td></tr>
                 <tr><td>Phone:</td><td>-</td></tr>
                 <tr><td>Address:</td><td>-</td></tr>
             </table>
        </div> 
        <div class="g2of3">
             <div class="head">Display Information</div>
             <table class="user-info">
                 <span id="toggle_url" hrefaction="<?=URL::to('/feedback/toggle_feedback_display')?>"></span>
                 <tr><th></th><th style="text-align:left; font-size: 9px">edit</th><th style="font-size: 9px">display?</th></tr>
                 <tr>
                     <td>Display Name:</td>
                     <td><?=$feedback->firstname?> <?=$feedback->lastname?></td>
                     <td align="center"><?=Form::checkbox('displayName', $feedback->displayname, ($feedback->displayname ? True : Null))?></td>
                 </tr>
                 <tr>
                     <td>Display Image:</td>
                     <td><?=$feedback->displayimg?></td>
                     <td align="center"><?=Form::checkbox('displayImg', $feedback->displayimg, ($feedback->displayimg ? True : Null))?></td>
                 </tr>
                 <tr>
                     <td>Company Name:</td>
                     <td><?=$feedback->companyname?></td>
                     <td align="center"><?=Form::checkbox('displayCompany', $feedback->displaycompany, ($feedback->displaycompany ? True : Null))?></td>
                 </tr>
                 <tr>
                     <td>Designation / Position:</td>
                     <td><?=$feedback->position?></td>
                     <td align="center"><?=Form::checkbox('displayPosition', $feedback->displayposition, ($feedback->displayposition ? True : Null))?></td>
                 </tr>
                 <tr>
                     <td>Website Url:</td>
                     <td><?=$feedback->url?></td> 
                     <td align="center"><?=Form::checkbox('displayURL', $feedback->displayurl, ($feedback->displayurl ? True : Null))?></td>
                 </tr>
                 <tr>
                     <td>Country & Flag:</td>
                     <td><?=$feedback->countryname?> <?=$feedback->countrycode?></td> 
                     <td align="center"><?=Form::checkbox('displayCountry', $feedback->displaycountry, ($feedback->displaycountry ? True : Null))?></td>
                 </tr>
                 <tr>
                     <td>Submitted Date:</td>
                     <td><?=$feedback->date?></td> 
                     <td align="center"><?=Form::checkbox('displaySbmtDate', $feedback->displaysbmtdate, ($feedback->displaysbmtdate ? True : Null))?></td>
                 </tr>
             </table>
        </div>

        <div class="g1of3">
             <div class="head">System Information</div>
             <table class="user-info">
                 <tr><td>First Name:</td><td><?=$feedback->firstname?></td></tr>
                 <tr><td>Last Name:</td><td><?=$feedback->lastname?></td></tr>
                 <tr><td>Email Address:</td><td><?=$feedback->email?></td></tr>
                 <tr><td>Time Sent:</td><td><?=$feedback->date?></td></tr>
                 <tr><td>Phone:</td><td>-</td></tr>
                 <tr><td>Address:</td><td>-</td></tr>
             </table>
        </div>

    </div>
    </div>
-->
