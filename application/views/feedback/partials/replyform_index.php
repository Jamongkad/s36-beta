<div class="lightbox-form">
    <table cellpadding="1" width="100%">
        <tr>
            <td width="15%"><strong>Reply To : </strong></td>
            <td width="50%" class="small"><span>&nbsp;&nbsp;</span>{{replybody.user.email}}</td>
            <td class="small">
                Your user replies will go to this email address (<?=HTML::link('/settings', 'configure', array('class' => 'linky'))?>)
            </td>
        </tr>
        <tr>
            <td><strong>To :</strong> </td>
            <td class="small"><span>&nbsp;&nbsp;</span></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <strong>Bcc :</strong>
            </td>

            <td class="bcc-target">
                <textarea class="regular-text" feedid="{{replybody.feedid}}" name="bcc" rows="2" style='width: 95%'></textarea>
            </td>
            <td class="small" valign="top">
                <span class="reply-text">
                    Click on email addresses below to add to the bcc (<?=HTML::link('/settings', 'configure fastforward', array('class' => 'linky'))?>) 
                </span>
            </td>
        </tr>
        <tr> 
            <td valign="top">
                <label style="font-size:11px;font-weight:bold;">+ Bcc: </label>
            </td>
            <td>
                <ul class="add-bcc" >
                    <li>
                         <a bcc href="/goto" class="linky" feedid="{{replybody.feedid}}" email="{{replybody.user.ffemail1}}">
                            {{replybody.user.alias1}} {{replybody.user.ffemail1}}
                        </a>
                    </li> 
                    <li>
                        <a bcc href="/goto" class="linky" feedid="{{replybody.feedid}}" email="{{replybody.user.ffemail2}}">
                            {{replybody.user.alias2}} {{replybody.user.ffemail2}}
                        </a>
                    </li>
                    <li>
                        <a bcc href="/goto" class="linky" feedid="{{replybody.feedid}}" email="{{replybody.user.ffemail3}}">
                            {{replybody.user.alias3}} {{replybody.user.ffemail3}}
                        </a>
                    </li>
                </ul>
            </td>
            <td class="small" valign="top"></td>
        </tr>
        <tr>
            <td><strong>Subject : </strong> </td>
            <td>
                <input type="text" class="regular-text" name="subject" value="Re: Feedback on " style='width: 95%' />
            </td>
            <td></td>
        </tr>
        <tr>
            <td><label style="font-size:11px;font-weight:bold;">Message: </label> </td>
            <td>
                <textarea class="regular-text" rows="6" name="message" style='width: 95%'></textarea>
            </td>

            <td>   
                <ul class="custom-message">
                    <li ng-repeat="msg in get_reply_messages()"> 
                        <a href='#'  add-reply req-text="{{msg.text}}" id="{{msg.id}}">{{msg.short_text}}</a> 
                        <span style="float:right">
                            <a href='#' edit-reply ng-click="edit_reply(msg.id, msg.msgtype, $event)">edit</a> 
                            <a href='#' delete-reply ng-click="del_reply(msg.id)">delete</a>
                        </span>
                    </li>
                </ul> 
                <div class="conf-repl" configure-reply ng-click="add_reply()" style="margin-left:0px !important;">
                    <?=HTML::link('settings', '(add template reply message)')?>
                </div>
            </td>
        </tr> 
        <tr><td width="%15">&nbsp;</td><td><input type="checkbox" name="email_me" value="1" /> 
                                           <span class="reply-text">send me a copy ({{replybody.user.replyto}})</span></td></tr>
    </table>                
</div>
