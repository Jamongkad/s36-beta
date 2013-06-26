<?if($user->replyto):?>
<?=Form::open('feedback/reply_to', 'POST', array('class' => 'reply-form'))?>
<div id="reply-to-user" class="lightbox">
    <div class="lightbox-styles" ng-controller="MainReplyCtrl">
    <div class="lightbox-close" reply-cancel value="Cancel" ng-click="cancel_reply()"></div>
        <h2>Reply To User</h2>
        <div class="lightbox-content" >
            <div ng-include src="template.url"></div>
        </div>
        <div class="lightbox-footer">
            <div class="lightbox-buttons">
                <input type="button" id="" class="large-btn reply_cancel_button" value="Cancel" reply-cancel/>
                <input type="submit" id="" class="large-btn reply_send_button" value="Send" reply-send/>
            </div>
        </div>
    </div>
    <!-- end of lightbox styles -->
</div>
<?=Form::close()?>
<?else:?>
    <div class="block">
        <div class="woops">
            <h2>Woops. In order to reply to your users, you have to configure your reply to address.</h2>
            <br/><br/>
            <p>
             Fortunately it's super easy! to add your reply to address <?=HTML::link('/settings?forward_to=/feedback/reply_to/'.$feedback->id, 'click here', Array('class' => 'woops-a'))?> 
            </p>
        </div> 
    </div>
<?endif?>
<div class="c"></div>
