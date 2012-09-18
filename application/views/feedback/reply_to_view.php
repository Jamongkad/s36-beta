<style>
    .reply-text { font-size: 11px }
    a.linky { 
        color: #707D87;     
        text-decoration:none;
    } 
    ul.add-bcc {
        list-style-type: none;     
        padding: 0px;
        margin: 0px;
    }
    ul.add-bcc li {
        padding-left: 2px; 

    }
</style>
<?if($user->replyto):?>
<?=Form::hidden('replyto', $user->replyto)?>
<?=Form::hidden('emailto', $feedback->email)?>
<?=Form::hidden('feedbackid', $feedback->id)?>
<?=Form::hidden('username', $user->username)?>
<div class="block" style="padding:25px">
    <table cellpadding="5" width="100%">
        <?if($user->replyto):?>
        <tr>
            <td width="15%"><strong>Reply To :</strong></td>
            <td width="50%" class="small"><span>&nbsp;&nbsp;</span><?=$user->replyto?></td>
            <td class="small"> 
                <span class="reply-text">Your user replies will go to this email address (<?=HTML::link('/settings', 'configure', array('class' => 'linky'))?>)</span> 
            </td>
        </tr>
        <?endif?>
        <tr>
            <td width="15%"><strong>To :</strong> </td>
            <td width="50%" class="small"><span>&nbsp;&nbsp;</span><?=$feedback->email?></td>
            <td></td>
        </tr>

        <tr>
            <td>
                <strong>Bcc :</strong>
            </td>
            <td id="bcc-target">
                <!--<input id="first-bcc" class="regular-text" type="text" name="bcc[]" value="" />-->
                <textarea class="regular-text" name="bcc" rows="2"></textarea>
            </td>
            <td class="small" valign="top">
                <span class="reply-text">Click on email addresses below to add to the bcc (<?=HTML::link('/settings', 'configure fastforward', array('class' => 'linky'))?>) </span>
            </td>
        </tr>
        <?if($user->ffemail1):?>
        <tr>
            <td valign="top">
                <strong>Add to Bcc : </strong>
            </td>
            <td>
                <ul class="add-bcc">
                    <?if($user->ffemail1):?>
                        <li><?=HTML::link('', $user->alias1."<".$user->ffemail1.">", array('class' => 'linky'))?></li>
                    <?endif?>
                    <?if($user->ffemail2):?>
                        <li><?=HTML::link('', $user->alias2."<".$user->ffemail2.">", array('class' => 'linky'))?></li>
                    <?endif?>
                    <?if($user->ffemail3):?>
                        <li><?=HTML::link('', $user->alias3."<".$user->ffemail3.">", array('class' => 'linky'))?></li>
                    <?endif?>
                </ul>
            </td>
            <td class="small" valign="top"></td>
        </tr>
        <?endif?>
        <tr>
            <td><strong>Subject : </strong> </td>
            <td>
                <input type="text" class="regular-text" name="subject" value="Re: Feedback on <?=$feedback->sitedomain?>" /> 
            </td>
            <td></td>
        </tr>
        <tr>
            <td valign="top"><strong>Message : </strong> </td>
            <td>
                <textarea class="regular-text" rows="6" name="message"></textarea>
            </td>
            <!--
            <td>
           
                <ul class="no-list-style">
                    <li>Thank you for your suggestion</li>
                    <li>Technical Support Issue</li>
                    <li>Refund and RMA</li>
                    <li>Configure Template Reply</li>
                </ul>
    
            </td>
            -->
        </tr>
        <tr><td width="%15">&nbsp;</td><td><input type="checkbox" /> 
                                           <span class="reply-text">send me a copy (<?=$user->replyto?>)</span></td></tr>
    </table>
</div>
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
