<?=Form::open('/feedback/reply_to')?>
<?=Form::hidden('replyto', $user->replyto)?>
<?=Form::hidden('emailto', $feedback->email)?>
<?=Form::hidden('feedbackid', $feedid)?>
<?=Form::hidden('username', $user->username)?>
<div class="block">
    <table cellpadding="5" width="100%">
        <?if($user->replyto):?>
        <tr>
            <td width="15%"><strong>Reply To :</strong></td>
            <td width="50%" class="small"><span>&nbsp;&nbsp;</span><?=$user->replyto?></td>
            <td class="small">Your user replies will go to this email address (<?=HTML::link('/settings', 'configure')?>)</td>
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
                <input type="text" name="bcc[]" value="" />
            </td>
            <td class="small" valign="top">Click on email addresses below to add to the bcc (<?=HTML::link('/settings', 'configure fastforward')?>)</td>
        </tr>
        <tr>
            <td valign="top">
                <strong>Add to Bcc : </strong>
            </td>
            <td>
                <ul class="no-list-style add-bcc">
                    <?if($user->ffemail1):?>
                        <li><?=$user->ffemail1?></li>
                    <?endif?>
                    <?if($user->ffemail2):?>
                        <li><?=$user->ffemail2?></li>
                    <?endif?>
                    <?if($user->ffemail3):?>
                        <li><?=$user->ffemail3?></li>
                    <?endif?>
                </ul>
            </td>
            <td class="small" valign="top"></td>
        </tr>
        <tr>
            <td><strong>Subject : </strong> </td>
            <td>
                <input type="text" class="regular-text" name="subject" value="<?=$input['subject']?>" /> 
                <?=($errors) ? "<p style='color:red; padding-left:10px'>".$errors->first('subject')."</p>" : null?>
            </td>
            <td></td>
        </tr>
        <tr>
            <td valign="top"><strong>Message : </strong> </td>
            <td>
                <textarea class="regular-text" rows="6" name="message"><?=$input['message']?></textarea>
                <?=($errors) ? "<p style='color:red; padding-left:10px'>".$errors->first('message')."</p>" : null?>
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
        <tr><td colspan="3"></td></tr>                                         
        <tr>
            <td></td>
            <td>
                <input type="submit" value="Send" class="large-btn" />
            </td>
            <td></td>
        </tr>
    </table>
</div>
<?=Form::close()?>

<div class="c"></div>
