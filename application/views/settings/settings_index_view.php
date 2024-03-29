 <!-- contents -->
<style>
    #replymsg-list {
       margin-top:10px;    
    }
    .replymsg-text {
      margin:3px;padding:4px;font-weight:bold;
    }
</style>
<?=Form::open('settings/savesettings')?>
<?=Form::hidden('companyid', $user->companyid)?>
<?=Form::hidden('forward_to', Input::get('forward_to'))?>
<div class="block graybg">
    <h3>FEEDBACK SETTINGS</h3>
</div>
<div class="block">
    <p class="small"><strong></strong></p>
    <div class="grids border-bottom">
        <div class="grids">
            <strong style="margin-left:6px;">Auto Posting Options</strong>
            <br/>
            <span style="margin-left:6px;">Auto Posting allows you to automatically publish submitted feedback for a given rating value.</span>
        </div>
        <div class="grids" style="padding-top:6px">
                <input id="autopost_enable" name="autopost_enable" type="checkbox" <?=($hosted_settings->autopost_enable==1) ? 'checked="checked"' : '' ?>>                
                <strong style="margin-left:6px;">Enable</strong>
        </div>
        <div id="autopost_div" class="grids" style="padding-top:6px;display:<?=($hosted_settings->autopost_enable==1) ? 'block"' : 'none' ?>">
            <span style="margin-left:29px;">I want to publicly post feedback with ratings from
            <select id="autopost_rating" name="autopost_rating">
                <?php for($rating=1;$rating<6;$rating++){?>
                    <option value="<?=$rating?>" <?=($rating==$hosted_settings->autopost_rating) ? 'selected' : '' ?> ><?=$rating?></option>
                <?php } ?>
            </select>
            stars onwards.
            </span>
        </div>
    </div>
</div>
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


<div class="block graybg" style="margin-top:10px;border-top:1px solid #dedede;">
    <hello-settings></hello-settings>
</div>
<div class="block">    
    <p class="small"><strong></strong></p>
    <div class="grids border-bottom">
        <div class="grids">
            <strong style="margin-left:6px;">Fast Forwarding Options</strong>
            <br/>
            <span style="margin-left:6px;">Fast forward allows you to forward feedback to a specific person with a single click.</span>
        </div>
        <div class="grids" style="padding-top:6px">
            <div class="g1of2"><strong style="margin-left:6px;">Email Address</strong></div>
            <div class="g1of2"><strong style="margin-left:6px;">Alias</strong></div>
        </div>
        <div class="grids">
            <div class="g1of2"><input type="text" class="regular-text" name="ffEmail1" value="<?=$user->ffemail1?>"/></div>
            <div class="g1of2"><input type="text" class="regular-text" name="alias1" value="<?=$user->alias1?>"/></div>
        </div>
        <div class="grids">
            <div class="g1of2"><input type="text" class="regular-text" name="ffEmail2" value="<?=$user->ffemail2?>"/></div>
            <div class="g1of2"><input type="text" class="regular-text" name="alias2" value="<?=$user->alias2?>"/></div>
        </div>
        <div class="grids">
            <div class="g1of2"><input type="text" class="regular-text" name="ffEmail3" value="<?=$user->ffemail3?>"/></div>
            <div class="g1of2"><input type="text" class="regular-text" name="alias3" value="<?=$user->alias3?>"/></div>
        </div>                    
    </div>
    <div class="grids border-bottom">
        <div style="padding:8px 0px 0px;">
            <strong style="margin-left:6px;">Reply–To Email Address</strong>
            <br/>
            <span style="margin-left:6px;">Configure the email address that you would like to reply to your customers with.</span>
        </div> 
        <input type="text" class="regular-text" name="replyTo" style="width:240px" value="<?=$user->replyto?>"/>
    </div>
    <!--
    <div class="grids">
        <label>Send me a <select class="regular-select"><option>Daily</option></select> breakdown of all the incoming items, testimonials and feedback. </label>
    </div>
    -->
</div>
<div class="block graybg">
    <h3>TEMPLATE REPLY</h3>
</div>
<div class="block">
    <p class="small"><strong></strong></p>
    <div class="grids border-bottom">
        <div class="grids">
            <strong style="margin-left:6px;">Feedback Reply Messages</strong>
            <br/>
            <span style="margin-left:6px;">Write custom messages to reply to a person with a single click.</span>
        </div>
        
        <div ng-controller="SettingReplyCtrl" id="replymsg-list">      
            <div ng-repeat="msg in get_msgs()">
                <div class="grids" id="{{msg.id}}" style="padding-top: 10px">
                    <div class="g1of3">
                        <span class="replymsg-text" id="{{msg.id}}"> {{msg.short_text}} </span>
                        <input type="text" style="display:none" class="regular-text" name="reply_message" id="{{msg.id}}" value="{{msg.text}}"/> 
                    </div>
                     <div class="g1of3">
                         <a href="#" class="gray-btn"  ng-click="edit_msg(msg.id, $event)">+ Edit Message</a>
                         <a href="#" class="gray-btn" style="display:none" ng-click="update_msg(msg.id, $event)">+ Update Message</a>
                         <a href="#" class="gray-btn" ng-click="delete_msg(msg.id, $event)">- Delete Message</a>
                    </div>
                </div>
            </div>
            <div class="grids" style="background:#fffde5; margin-top:10px">                
                <div class="g1of3">
                    <input type="text" ng-model="form_msg_text" class="regular-text" name="reply_message" ng-model-instant/>
                </div>
                <div class="g1of3 align-center" style="padding-top:8px;">
                    <a href="#" class="gray-btn add-new-message" ng-click="add_msg($event)">+ Add Reply Message</a>
                </div>
                <div class="g1of3"></div>
            </div>
        </div>
    </div>
    <div class="grids border-bottom">
        <div style="padding:8px 0px 0px;">
            <strong style="margin-left:6px;">Feedback Request Messages</strong> 
            <br/>
            <span style="margin-left:6px;">Write a custom request message you can send to a person with a single click.</span>
        </div> 
        <div ng-controller="SettingRequestCtrl" id="replymsg-list">      
            <div ng-repeat="msg in get_msgs()">
                <div class="grids" id="{{msg.id}}" style="padding-top: 10px">
                    <div class="g1of3">
                        <span class="replymsg-text" id="{{msg.id}}"> {{msg.short_text}} </span>
                        <input type="text" style="display:none" class="regular-text" name="reply_message" id="{{msg.id}}" value="{{msg.text}}"/> 
                    </div>
                     <div class="g1of3">
                         <a href="#" class="gray-btn"  ng-click="edit_msg(msg.id, $event)">+ Edit Message</a>
                         <a href="#" class="gray-btn" style="display:none" ng-click="update_msg(msg.id, $event)">+ Update Message</a>
                         <a href="#" class="gray-btn" ng-click="delete_msg(msg.id, $event)">- Delete Message</a>
                    </div>
                </div>
            </div>
            <div class="grids" style="background:#fffde5; margin-top:10px">                
                <div class="g1of3">
                    <input type="text" ng-model="form_msg_text" class="regular-text" name="reply_message" ng-model-instant/>
                </div>
                <div class="g1of3 align-center" style="padding-top:8px;">
                    <a href="#" class="gray-btn add-new-message" ng-click="add_msg($event)">+ Add Request Message</a>
                </div>
                <div class="g1of3"></div>
            </div>
        </div>
    </div>
</div>
<!--
<div class="block graybg">
    <h3>FLAGGED ITEMS MANAGEMENT</h3>
</div>
<div class="block">
    <p class="border-bottom"><input type="checkbox" /> Tag incomming items not acted on after <select class="regular-select"><option>10 days</option></select> as inactive. </p>
    <p><input type="checkbox" /> Delete ignored posts permanently after 30 days.  </p>
</div>
-->
<div class="block graybg">
    <h3>CATEGORIES</h3>
</div>
<div class="block">
    <div id="ctgy-list" hrefaction="<?=URL::to('settings/write_ctgy')?>">
        <?foreach($category as $rows):?>
            <div class="grids padded" style="padding-bottom:10px;">
                <div class="g1of3">
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
    <div class="grids" style="background:#fffde5">
        <div class="g1of3"><input type="text" class="regular-text" name="category_nm"/></div>
        <div class="g1of3 align-center" style="padding-top:8px;">
            <a href="#" class="gray-btn add-new-ctgy">+ Add New Category</a>
        </div>
        <div class="g1of3"></div>
    </div>
</div>
<div class="block graybg">
    <h3>PRIVACY POLICY</h3>
</div>
<div class="block">
    <p><strong>Privacy Policy Link Text</strong><br />
    <span class="light-blue">Include a link to your website's privacy policy</span></p>
    <input type="text" class="regular-text" value="http://www.company.com/privacy_policy" />
    <br />
    <p><strong>Privacy Policy Link Text</strong><br />
    <span class="light-blue">Or.. include your privacy policy in this text field below.</span></p>
    <textarea class="regular-text" rows="20">
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut quis turpis rutrum dolor pulvinar tempus sit amet sit amet tortor. Fusce laoreet suscipit magna ut sodales. Etiam sed mauris vitae turpis pulvinar aliquam sit amet ut lectus. Cras volutpat ultricies mauris, vitae porttitor lacus facilisis eu. 

Curabitur ante justo, commodo in viverra vitae, convallis ut est. Mauris laoreet erat ornare massa tincidunt iaculis. Phasellus non felis nisl, ut convallis nisl. Aenean sit amet velit nisl, sed mattis neque. Donec velit augue, luctus quis elementum eget, adipiscing a justo. 
    
In eget elit ac nisi rutrum tempus eu ac nulla. Nulla pellentesque sodales lectus, at consectetur est tempor suscipit. Nam vitae sem vitae urna accumsan consectetur. Aliquam at lectus tortor. Duis dictum gravida leo, vel feugiat lacus porta vel. Nulla eu turpis magna, eget tincidunt nulla
    </textarea>
    
    <div style="padding-top:20px; padding-bottom:30px; padding-left:5px">
        <input type="submit" class="large-btn" value="Save Settings" />
    </div>

</div>
</div>

<!-- end of the main panel -->
<!-- div need to clear floated divs -->
<div class="c"></div>
</div>
<?=Form::close()?>
