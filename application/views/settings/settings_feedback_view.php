<?=Form::open('settings/save_feedback_settings')?>
<?=Form::hidden('companyid', $user->companyid)?>
<?=Form::hidden('forward_to', Input::get('forward_to'))?>
<div id="theFormSetup" class="dashboard-page">
	<h1>Feedback Settings</h1>                        
    <div class="dashboard-box">
    	<div class="dashboard-head">
          <span class="dashboard-title">Auto Posting</span> <span class="dashboard-subtitle">Auto Posting allows you to automatically publish submitted feedback for a given rating value.</span>
        </div>
        <div class="dashboard-body">
        	<div class="dashboard-content">
            	<div class="form-setup-block">
                    <div class="form-setup-fields grids">
                      <div class="form-setup-elem">
                        <input id="autopost_enable" name="autopost_enable" type="checkbox" <?=($hosted_settings->autopost_enable==1) ? 'checked="checked"' : '' ?>>                
                        <strong>Enable</strong>
                        <div id="autopost_div" style="display:<?=($hosted_settings->autopost_enable==1) ? 'block"' : 'none' ?>">
                        <p>I want to publicly post feedback with ratings from
                            <select id="autopost_rating" name="autopost_rating">
                                <?php for($rating=1;$rating<6;$rating++){?>
                                    <option value="<?=$rating?>" <?=($rating==$hosted_settings->autopost_rating) ? 'selected' : '' ?> ><?=$rating?></option>
                                <?php } ?>
                            </select>
                            stars onwards.</p>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="dashboard-foot"></div>
    </div>
    <div class="dashboard-box">
    	<div class="dashboard-head">
          <span class="dashboard-title">Fast Forwarding</span> <span class="dashboard-subtitle">Fast forward allows you to forward feedback to a specific person with a single click.</span>
        </div>
        <div class="dashboard-body">
        	<div class="dashboard-content">
            	<div class="form-setup-block">
                    <div class="form-setup-fields grids">
                      <div class="form-setup-label">Email Address : </div>
                      <div class="form-setup-elem">
                        <input type="text" class="dashboard-text" name="ffEmail1" value="<?=$user->ffemail1?>"/>
                      </div>
                    </div>
                    <div class="form-setup-fields grids">
                      <div class="form-setup-label">Alias : </div>
                      <div class="form-setup-elem">
                        <input type="text" class="dashboard-text" name="alias1" value="<?=$user->alias1?>"/>
                      </div>
                    </div>
                </div>
                <div class="form-setup-block">
                    <div class="form-setup-fields grids">
                      <div class="form-setup-label">Email Address : </div>
                      <div class="form-setup-elem">
                        <input type="text" class="dashboard-text" name="ffEmail2" value="<?=$user->ffemail2?>"/>
                      </div>
                    </div>
                    <div class="form-setup-fields grids">
                      <div class="form-setup-label">Alias : </div>
                      <div class="form-setup-elem">
                        <input type="text" class="dashboard-text" name="alias2" value="<?=$user->alias2?>"/>
                      </div>
                    </div>
                </div>
                <div class="form-setup-block">
                    <div class="form-setup-fields grids">
                      <div class="form-setup-label">Email Address : </div>
                      <div class="form-setup-elem">
                        <input type="text" class="dashboard-text" name="ffEmail3" value="<?=$user->ffemail3?>"/>
                      </div>
                    </div>
                    <div class="form-setup-fields grids">
                      <div class="form-setup-label">Alias : </div>
                      <div class="form-setup-elem">
                        <input type="text" class="dashboard-text" name="alias3" value="<?=$user->alias3?>"/>
                      </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="dashboard-foot"></div>
    </div>
    <div class="dashboard-box">
    	<div class="dashboard-head">
          <span class="dashboard-title">Reply-To Email Address </span> <span class="dashboard-subtitle">Configure the email address that you would like to reply to your customers with.</span>
        </div>
        <div class="dashboard-body">
        	<div class="dashboard-content">
            	<div class="form-setup-block">
                    <div class="form-setup-fields grids">
                      <div class="form-setup-label">Email Address : </div>
                      <div class="form-setup-elem">
                        <input type="text" class="dashboard-text" name="replyTo" value="<?=$user->replyto?>"/>
                      </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="dashboard-foot"></div>
    </div>
    <div class="dashboard-box">
    	<div class="dashboard-head">
          <span class="dashboard-title">Reply Messages Template</span> <span class="dashboard-subtitle">Write custom messages to reply to a person with a single click.</span>
        </div>
        <div class="dashboard-body">
        	<div class="dashboard-content">
            	<div ng-controller="SettingReplyCtrl" id="replymsg-list">      
                <div ng-repeat="msg in get_msgs()">
                    <div class="grids" id="{{msg.id}}" style="padding-top: 10px">
                        <div class="g1of3">
                            <span class="replymsg-text" id="{{msg.id}}"> {{msg.short_text}} </span>
                            <input type="text" style="display:none" class="dashboard-text" name="reply_message" id="{{msg.id}}" value="{{msg.text}}"/> 
                        </div>
                         <div class="g1of3">
                             <a href="#" class="" edit-reply-settings msgid="msg.id" action="edit">Edit Message</a> 
                             <a href="#" class="" style="display:none" edit-reply-settings msgid="msg.id" action="update">Update Message</a> | 
                             <a href="#" class="" ng-click="delete_msg(msg.id, $event)">Delete Message</a>
                        </div>
                    </div>
                </div>
                <div class="grids" style="margin-top:10px">                
                    <div class="g1of3">
                        <input type="text" ng-model="form_msg_text" class="dashboard-text" name="reply_message" ng-model-instant/>
                    </div>
                    <div class="g1of3">
                        <a href="#" class="dashboard-button blue large add-new-message" ng-click="add_msg($event)">Add Reply Message</a>
                    </div>
                    <div class="g1of3"></div>
                </div>
              </div>
            </div>
        </div>
        <div class="dashboard-foot"></div>
    </div>                        
    <div class="dashboard-box">
    	 <div class="dashboard-head">
          <span class="dashboard-title">Categories</span> 
        </div>
        <div class="dashboard-body">
        	<div class="dashboard-content">
            <div class="form-setup-block">
                    <div class="form-setup-fields grids">
                      <div class="form-setup-label">New Category:</div>
                      <div class="form-setup-elem">
                            <input type="text" class="dashboard-text" name="category_nm">
                            <div style="height:5px;"></div>
                            <a href="#" class="dashboard-button blue large add-new-ctgy">Add</a>
                          </br></br>
                          <div id="ctgy-list" hrefaction="<?=URL::to('settings/write_ctgy')?>">
                              <?foreach($category as $rows):?>
                                  <div id="category-<?=$rows->id?>" class="grids padded" style="padding-bottom:10px;">
                                      <div class="g1of3" >
                                          <strong class='ctgy-name'><?=$rows->name?></strong>
                                      </div>
                                      <div class="g1of3 align-center">
                                          <?if($rows->changeable != 0):?>
                                              <?=HTML::link('settings/rename_ctgy/'.$rows->id, 'Rename', Array('class' => 'rename-ctgy'))?> 
                                            | <?=HTML::link('settings/delete_ctgy/'.$rows->id, 'Delete', Array('class' => 'delete-ctgy'))?> 
                                          <?endif?>
                                      </div>
                                  </div>
                              <?endforeach?>
                          </div>
                      </div>
                    </div>
             </div>
            </div>
          </div>
          <div class="dashboard-foot"></div>
    </div>
    <?php
    /* Temporarily comment for privacy settings 
    |*

    /*
    <h1>Privacy Policy</h1>
    <div class="dashboard-box">
    	<div class="dashboard-head">
          <span class="dashboard-title">Privacy Policy Link Text</span> <span class="dashboard-subtitle">Include a link to your website's privacy policy</span>
        </div>
        <div class="dashboard-body">
        	<div class="dashboard-content">
                <div class="form-setup-block">
                    <div class="form-setup-fields grids">
                      <div class="form-setup-label">URL :  </div>
                      <div class="form-setup-elem">
		<input class="dashboard-text" title="" />
                            <div style="height:5px;"></div>
                            <a href="#" class="dashboard-button blue large">Add</a>
                      </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="dashboard-foot"></div>
    </div>
    <div class="dashboard-box">
        <div class="dashboard-head">
          <span class="dashboard-title">Privacy Policy Link Text</span> <span class="dashboard-subtitle">Or.. include your privacy policy in this text field below.</span>
        </div>
        <div class="dashboard-body">
            <div class="dashboard-content">
                <div class="form-setup-block">
                    <div class="form-setup-fields grids">
                            <textarea class="dashboard-textarea" title="What are your thoughts about our product/services?"></textarea>
                            <div style="height:5px;"></div>
                            <input type="submit" class="dashboard-button blue large" value="Save Settings" />
                    </div>
                </div>
            </div>
        </div>
        <div class="dashboard-foot"></div>
    </div>
    */?>
</div>
<?=Form::close()?>
<script type="text/javascript">
$(document).ready(function(){
    $('#autopost_enable').click(function(){
        if(this.checked==false){
            $('#autopost_div').fadeOut('slow');
        }else{
            $('#autopost_div').fadeIn('slow');
        }
    })
});
</script>
