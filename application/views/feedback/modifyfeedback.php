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

<div class="dialog-form" feedid="<?=$id?>"> 
    <?=View::make('feedback/reply_to_view', array('user' => $admin_check, 'feedback'=> $feedback, 'reply_message' => $reply_message))?>
</div>

<div id="theFormSetup" class="dashboard-page">
  <div class="permission grids modified">
        <div class="permission-icon"><img src="/img/ico-full-permission.png" /></div>
        <div class="permission-text">
            <h3><?=$feedback->permission?></h3>

            <p>
                <?=$feedback->firstname?> <?=$feedback->lastname?> has granted you <?=strtolower($feedback->permission)?> to post his/her feedback
                on your website.
            </p>
        </div>
  </div>
</div>

<div class="dashboard-box modified">
  <div class="dashboard-body">
    <div class="dashboard-content">
      <div class="modify-box">                  
        <div class="grids">
            <div class="modify-box-left">
                <div class="modify-textbox">  
                    <?=Form::hidden('feed_id', $id, array('id' => 'feed-id'))?> 
                    <?=Form::textarea('text', $feedback->text, Array('class' => 'feedback-textarea', 'rows' => 10, 'cols' => 83))?>
                </div>
                <div class="modify-status">
                    <span class="save-feedback"><a href="#">Save Feedback</a></span>
                    <span>Status : </span><span class="blue">New</span>
                    <span>Priority : </span><span class="blue">High</span>
                </div>
                <div class="modify-other-info">
                    <div class="modify-other-info-block grids">
                        <span class="left-label">Site URL : </span><span class="right-label">
                            <?=$feedback->sitedomain?>
                        </span>    
                    </div>
                    <div class="modify-other-info-block grids">
                        <span class="left-label">Default Display Rules : </span>
                        <span class="right-label">
                            <?=Form::checkbox('resetIndLock', 1, 
                                              ($feedback->indlock ? True : Null))?>
                        </span>  
                    </div>
                    <div class="modify-other-info-block grids">
                        <span class="left-label padtext-fix">Submission Date (dd-mm-yyyy) : </span>
                        <span class="right-label">
                            <input type="text" name="date_change" 
                                   value="<?=date("d-m-Y", $feedback->unix_timestamp)?>" 
                                   class="regular-text datepicker" id="date" /> 
                        </span>
                    </div>
                </div>
            </div>
            <div class="modify-box-right">
                <h4>Save this item as feedback</h4>
                <p><small>Selecting other categories will move this item into the 'Filed Feedback' tab.</small></p>

                <ul class="category-box category-picker grids" id="<?=$feedback->categoryid?>"> 
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
                <p>
                    <?=HTML::link('settings', 'Manage categories →') ?>
                </p>
            </div>
        </div>
        <div class="modify-blue-bar">
            <div class="grids">
                <div class="blue-bar-left">
                    <div class="grids">
                        <div class="g1of5 align-center">
                            <a href="#" class="blue-bar-reply-to-user">REPLY TO USER</a>
                        </div>
                        <div class="g1of5 align-center">
                            <a href="#" class="blue-bar-forward">FORWARD</a>
                        </div>
                        <div class="g1of5 align-center">
                            <a href="#" class="blue-bar-publish">PUBLISH</a>
                        </div>
                        <div class="g1of5 align-center">
                            <a href="#" class="blue-bar-feature">FEATURE</a>
                        </div>
                        <div class="g1of5 align-center">
                            <a href="#" class="blue-bar-flag">FLAG</a>
                        </div>
                    </div>
                </div>
                <div class="blue-bar-right align-right">
                    <a href="#" class="blue-bar-delete">DELETE</a>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
            
<div class="dashboard-box modified">
  <div class="dashboard-body">
    <div class="dashboard-content">
        <div class="margin-adjust-fix">
            <div class="grids">
                <div class="g1of3">
                <!--
                    <div class="grids">
                        <div class="g1of5">
                            <br />                         
                            <?if($feedback->origin == 's36'):?>
                                <?if($feedback->avatar):?> 
                                    <?=HTML::image('uploaded_images/avatar/small/'.$feedback->avatar, false, array('class' => 'small-avatar'))?>
                                <?else:?>
                                    <?=HTML::image('/img/48x48-blank-avatar.jpg')?>
                                <?endif?>
                            <?endif?>
                            <?if($feedback->origin == 'tw'):?>
                                <img src="<?=$feedback->avatar?>" />
                            <?endif?> 
                         <br/ >
                        </div>
                    </div>
                -->

                    <div class="g4of3">
                        <table cellpadding="2" class="feedback-data-table">
                            <tr><td colspan="2" class="header">User Information</td><td></td></tr>
                            <tr><td class="title">Name: </td><td><?=$feedback->firstname?> <?=$feedback->lastname?></td></tr>
                            <tr><td class="title">Email:</td><td><?=$feedback->email?></td></tr>
                            <tr><td class="title">City:</td><td><?=$feedback->city?></td></tr>
                            <tr>
                                <td class="title">Country:</td>
                                <td><?=($feedback->countryname != 'Nil') ? $feedback->countryname : null?></td>
                            </tr>
                        </table>
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
                     <?$null_avatar = ($feedback->avatar == false || $feedback->origin == 'tw') ? Array('disabled' => 'disabled') : Array();?>
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
    </div>
  </div>
</div>
