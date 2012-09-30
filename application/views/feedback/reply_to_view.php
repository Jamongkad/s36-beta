<?if($user->replyto):?>
<?=Form::hidden('replyto', $user->replyto)?>
<?=Form::hidden('emailto', $feedback->email)?>
<?=Form::hidden('feedbackid', $feedback->id)?>
<?=Form::hidden('username', $user->username)?>
<div id="reply-box" style="display:block">
    <div class="reply-box-styles">
        <h2>Reply To User</h2>
        <div class="reply-box-content">
        <div class="reply-box-form">
            <table cellpadding="5" width="100%">
            <!--
            <tr>
                <td width="15%"><strong>From :</strong></td>
                <td width="50%"><input type="text" class="regular-text"/></td>
                <td class="small">Configure your brand/company name here that your user will recognize (e.g. Razer)</td>
            </tr>
            -->
            <tr>
                <td><strong>Reply To :</strong></td>
                <td class="small"><span>&nbsp;&nbsp;</span><?=$user->replyto?></td>
                <td class="small">Your user replies will go to this email address (<?=HTML::link('/settings', 'configure', array('class' => 'linky'))?>)</td>
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
                <td class="bcc-target" feedid="<?=$feedback->id?>">
                    <textarea class="regular-text" name="bcc" rows="2" style='width: 338px'></textarea>
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
                    <ul class="add-bcc" reply-bcc>
                        <?if($user->ffemail1):?>
                            <li>
                                <?=HTML::link('', $user->alias1."<".$user->ffemail1.">"
                                             , array('class' => 'linky', 'feedid' => $feedback->id, 'email' => $user->ffemail1))?>
                            </li>
                        <?endif?>
                        <?if($user->ffemail2):?>
                            <li>
                                <?=HTML::link('', $user->alias2."<".$user->ffemail2.">"
                                             , array('class' => 'linky', 'feedid' => $feedback->id, 'email' => $user->ffemail2))?>
                            </li>
                        <?endif?>
                        <?if($user->ffemail3):?>
                            <li>
                                <?=HTML::link('', $user->alias3."<".$user->ffemail3.">"
                                             , array('class' => 'linky', 'feedid' => $feedback->id, 'email' => $user->ffemail3))?>
                            </li>
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

                <td>   
                    <ul class="msgsel">
                    </ul> 

                    <div class="conf-repl" configure-reply id="<?=$feedback->id?>">
                        <?=HTML::link('settings', '(configure template reply)')?>
                    </div>
                </td>
                <td> 
                    <div class="reply-configure" id="<?=$feedback->id?>"> 
                        <h3>{{name}}</h3>
                        <?if($reply_message):?>
                            <?foreach($reply_message as $val):?>
                                <li id="<?=$val->id?>" text="<?=$val->text?>">
                                    <a href="#"><?=$val->short_text?></a>
                                </li>
                            <?endforeach?>
                        <?endif?>
                    </div>
                </td>
            </tr>
            
            <tr><td width="%15">&nbsp;</td><td><input type="checkbox" name="email_me" value="1" /> 
                                               <span class="reply-text">send me a copy (<?=$user->replyto?>)</span></td></tr>
        </table>
                
            </div>
        </div>
        <div class="reply-box-padding"></div>
        <div class="reply-box-error"></div>
        <div class="reply-box-footer">
            <div class="reply-box-buttons">
                <input type="button" class="large-btn" value="Cancel" reply-cancel/>
                <input type="submit" class="large-btn" value="Send" reply-send/>
            </div>
        </div>
    </div>
    <!-- end of reply-box styles -->
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
