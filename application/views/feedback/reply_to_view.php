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
        padding-left: 5px; 
        line-height: 18px;
   }

   .large-btn{background:#6a7881;-webkit-border-radius:6px;-moz-border-radius:6px;border-radius:6px;color:#FFF;font-size:12px;border:none;padding:8px 26px;font-weight:bold;text-shadow:#3c4349 0px -1px;cursor:pointer;}
   .large-btn:hover{background:#8194a0;}

    #lightbox{
        width:700px;
        margin-left:-350px;
    }
    .lightbox-styles{
        display:block;
        overflow:hidden;
        text-align:left;
    }
    .lightbox-styles h2{
        padding:15px 30px;
        background:#efefef;
        border-bottom:1px solid #e0e0e0;
        text-align:left;
        font-size:14px;
    }
    .lightbox-content{
        padding:30px;
    }
    .lightbox-form{
    }
    .lightbox-form h3{
        font-size:12px;
    }
    .lightbox-footer{
        background:#babfc2;
        padding:15px 30px;
    }
    .lightbox-buttons{text-align:right;}
    #lightbox .custom-message{position:absolute;left:530px;list-style:none;font-size:11px;color:#9ba4ab;top:290px;}
    
    .lightbox-error{
        padding:20px 30px;
        background:#ffa801;
        color:#000;font-weight:bold;
        font-size:13px;
        display:block;
    }
    .lightbox-padding{
        /* change display to block when error is not shown to preserve the height */
        padding:20px 30px;display:none;
    }

</style>
<?if($user->replyto):?>
<?=Form::hidden('replyto', $user->replyto)?>
<?=Form::hidden('emailto', $feedback->email)?>
<?=Form::hidden('feedbackid', $feedback->id)?>
<?=Form::hidden('username', $user->username)?>
<div id="lightbox" style="display:block">
    <div class="lightbox-styles">
        <h2>Reply To User</h2>
        <div class="lightbox-content">
        <div class="lightbox-form">
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
                    <ul class="add-bcc" >
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
                        <?if($reply_message):?>
                            <?foreach($reply_message as $val):?>
                                <li id="<?=$val->id?>"><a href="#"><?=$val->text?></a></li>
                            <?endforeach?>
                        <?endif?>
                        <li><?=HTML::link('settings', '(configure template reply)')?></li>
                    </ul> 
                </td>
            </tr>
            
            <tr><td width="%15">&nbsp;</td><td><input type="checkbox" name="email_me" value="1" /> 
                                               <span class="reply-text">send me a copy (<?=$user->replyto?>)</span></td></tr>
        </table>
                
            </div>
        </div>
        <div class="lightbox-padding"></div>
        <div class="lightbox-footer">
            <div class="lightbox-buttons">
                <input type="button" class="large-btn" value="Cancel" />
                <input type="button" class="large-btn" value="Send" />
            </div>
        </div>
    </div>
    <!-- end of lightbox styles -->
</div>
<!--
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
            <td class="bcc-target" feedid="<?=$feedback->id?>">
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
                <ul class="add-bcc" >
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
                    <?if($reply_message):?>
                        <?foreach($reply_message as $val):?>
                            <li id="<?=$val->id?>"><a href="#"><?=$val->text?></a></li>
                        <?endforeach?>
                    <?endif?>
                    <li><?=HTML::link('settings', '(configure template reply)')?></li>
                </ul> 
            </td>

        </tr>
        <tr><td width="%15">&nbsp;</td><td><input type="checkbox" name="email_me" value="1" /> 
                                           <span class="reply-text">send me a copy (<?=$user->replyto?>)</span></td></tr>
    </table>

    
    <div class="block noborder" style="margin-left:-10px;">
        <input type="submit" class="large-btn" value="Send" /> 
    </div>
   
</div>
-->
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
