<?=Form::open('/feedback/reply_to')?>
<?=Form::hidden('replyto', $user->replyto)?>
<?=Form::hidden('emailto', $feedback->email)?>
<div class="block">
    <table cellpadding="5" width="100%">
        <!--
        <tr>
            <td width="15%"><strong>From :</strong></td>
            <td width="50%"><input type="text" class="regular-text"/></td>
            <td class="small">Configure your brand/company name here that your user will recognize (e.g. Razer)</td>
        </tr>
        -->
        <tr>
            <td width="15%"><strong>Reply To :</strong></td>
            <td width="50%" class="small"><span>&nbsp;&nbsp;</span><?=$user->replyto?></td>
            <td class="small">Your user replies will go to this email address (<?=HTML::link('/settings', 'configure')?>)</td>
        </tr>
        <tr>
            <td><strong>To :</strong> </td>
            <td class="small"><span>&nbsp;&nbsp;</span><?=$feedback->email?></td>
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
            <td><input type="text" class="regular-text" name="subject"/></td>
            <td></td>
        </tr>
        <tr>
            <td><strong>Message : </strong> </td>
            <td><textarea class="regular-text" rows="6" name="message"></textarea></td>
            <td>
            <!--
                <ul class="no-list-style">
                    <li>Thank you for your suggestion</li>
                    <li>Technical Support Issue</li>
                    <li>Refund and RMA</li>
                    <li>Configure Template Reply</li>
                </ul>
            -->
            </td>
        </tr>
        <tr><td colspan="3"></td></tr>                                         
        <tr>
            <td></td>
            <td><input type="submit" href="#" value="Send" class="gray-btn rounder form-button" />
            <input type="submit" href="#" value="Cancel" class="gray-btn rounder form-button" />
            </td>
            <td></td>
        </tr>
    </table>
</div>
<?=Form::close()?>
<div class="block noborder">

</div>
<!-- spacer -->
<div class="block noborder" style="height:100px;">
</div>
<!-- spacer -->
