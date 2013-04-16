<?if($user->replyto):?>
<?=Form::open('feedback/reply_to', 'POST', array('class' => 'reply-form'))?>
<?=Form::hidden('replyto', $user->replyto)?>
<?=Form::hidden('emailto', $feedback->email)?>
<?=Form::hidden('feedbackid', $feedback->id)?>
<?=Form::hidden('username', $user->username)?>

<div id="reply-to-user" class="lightbox">
    <div class="lightbox-close" reply-cancel></div>
    <div class="lightbox-styles">
        <h2>Reply To User</h2>
        <!--
        <div class="lightbox-content">
        <div class="lightbox-form">
            <table cellpadding="1" width="100%">
            <tr>
                <td width="15%"><strong>Reply To :</strong></td>
                <td width="50%" class="small"><span>&nbsp;&nbsp;</span><?=$user->replyto?></td>
                <td class="small">
                    Your user replies will go to this email address (<?=HTML::link('/settings', 'configure', array('class' => 'linky'))?>)
                </td>
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
                    <textarea class="regular-text" name="bcc" rows="2" style='width: 95%'></textarea>
                </td>
                <td class="small" valign="top">
                    <span class="reply-text">
                        Click on email addresses below to add to the bcc (<?=HTML::link('/settings', 'configure fastforward', array('class' => 'linky'))?>) 
                    </span>
                </td>
            </tr>
            <?if($user->ffemail1):?>
            <tr>
                <td valign="top">
                    <label style="font-size:11px;font-weight:bold;">+ Bcc: </label>
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
                    <input type="text" class="regular-text" name="subject" value="Re: Feedback on <?=$feedback->sitedomain?>" style='width: 95%' />
                </td>
                <td></td>
            </tr>
            <tr>
                <td><label style="font-size:11px;font-weight:bold;">Message: </label> </td>
                <td>
                    <textarea class="regular-text" rows="6" name="message" style='width: 95%'></textarea>
                </td>

                <td>   
                    <span ng-controller="ReplyCtrl">
                        <ul class="custom-message">
                            <li ng-repeat="msg in get_reply_messages()"> 
                                <a href='#'  add-reply req-text="{{msg.text}}" id="{{msg.id}}">{{msg.short_text}}</a> 
                                <span style="float:right">
                                    <a href='#' edit-reply>edit</a> 
                                    <a href='#' delete-reply ng-click="del_reply(msg.id, $event)">delete</a>
                                </span>
                            </li>
                        </ul> 
                    </span>
                    <div class="conf-repl" configure-reply style="margin-left:0px !important;">
                        <?=HTML::link('settings', '(add template reply message)')?>
                    </div>
                </td>
            </tr> 
            <tr><td width="%15">&nbsp;</td><td><input type="checkbox" name="email_me" value="1" /> 
                                               <span class="reply-text">send me a copy (<?=$user->replyto?>)</span></td></tr>
        </table>
                
            </div>
        </div>
        <div class="lightbox-footer">
            <div class="lightbox-buttons">
                <input type="button" class="large-btn" value="Cancel" reply-cancel/>
                <input type="submit" class="large-btn" value="Send" reply-send/>
            </div>
        </div>
        -->
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
