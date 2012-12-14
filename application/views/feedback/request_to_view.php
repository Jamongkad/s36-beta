<?=Form::open('feedback/requestfeedback', 'POST', array('id' => 'request-form'))?>
<!-- start of lightbox request feedback -->
<div id="request-feedback" class="lightbox">
    <div class="lightbox-close"></div>
    <div class="lightbox-styles">
        <h2>Request Feedback</h2>
        <div class="lightbox-content">
        <span class="gray">
        Drop a request to someone you want to get feedback from. You can write your own custom message, or use one of our template messages. The recipient will receive a custom email with a link to send in their feedback with. 
        </span>
        
        <br />
        <div class="lightbox-form">
                <br />
                <h3>Recepient Details</h3>
                <br />
                <div class="widget-form">
                    <table width="80%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="110">
                            <label>First Name : </label>
                            </td>
                            <td>
                            <input type="text" name="first_name" class="regular-text" id="first_name" value=""/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                            <label>Last Name : </label>
                            </td>
                            <td>
                            <input type="text" name="last_name" class="regular-text" id="last_name" value=""/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                            <label>Email : </label>
                            </td>
                            <td>
                                <input type="text" name="email" class="regular-text" id="recipient-email" value=""/>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top"><br /><br />
                            <label>Message : </label> <br />
                            </td>
                            <td>
                                <textarea class="regular-text" name="message" style="width: 266px" rows="7" id="recipient-message" ></textarea>
                            </td>
                            <td> 
                                <span ng-controller="RequestCtrl" >
                                    <ul class="custom-message" style="margin-left:-10px">   
                                        <li ng-repeat="msg in get_request_msgs()">
                                            <a href='#' add-request req-text="{{msg.text}}" id="{{msg.id}}">{{msg.short_text}}</a> 
                                            <span style="float:right">
                                                <a href='#' edit-request req-text="{{msg.text}}" id="{{msg.id}}">edit</a> 
                                                <a href='#' delete-request ng-click="del_request(msg.id, $event)">delete</a>
                                            </span>
                                        </li>
                                    </ul>
                                </span>

                                <div class="conf-repl" style="margin-left:-10px">
                                    <?=HTML::link('settings', '(add request message)', array('class' => 'add-request-msg'))?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="lightbox-padding"></div>
        
        <div class="lightbox-footer">
            <div class="lightbox-buttons">
                <input type="button" class="large-btn" value="Cancel" my-request-close/>
                <input type="submit" class="large-btn" value="Send" my-request-send/>
            </div>
        </div>
    </div>
    <!-- end of lightbox styles -->
</div>

<!--
    <div  id="reply-box" >
        <div class="reply-box-styles">
            <h2>Request Feedback</h2>
            <div class="reply-box-content">
            <span>
            Drop a request to someone you want to get feedback from. You can write your own custom message, or use one of our template messages. The recipient will receive a custom email with a link to send in their feedback with. 
            </span>
            
            <br />
            <br />
            <div class="reply-box-form">
                <h3>Recipient Details</h3>
                    <div>
                        <table width="100%" cellpadding="5" cellspacing="0">
                            <tr>
                                <td width="130">
                                <label>First Name: </label>
                                </td>
                                <td>
                                <input type="text" name="first_name" class="regular-text" id="first_name" value=""/>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>
                                <label>Last Name: </label>
                                </td>
                                <td>
                                <input type="text" name="last_name" class="regular-text" id="last_name" value=""/>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Email: </label>
                                </td>
                                <td>
                                    <input type="text" name="email" class="regular-text" id="recipient-email" value=""/>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td valign="top">
                                <label>Message: </label>
                                </td>
                                <td>
                                <textarea class="regular-text" name="message" style="width: 266px" rows="7" id="recipient-message" ></textarea>
                                </td>
                                <td> 
                                    <span ng-controller="RequestCtrl" >
                                        <ul class="custom-message" style="margin-left:-10px">   
                                            <li ng-repeat="msg in get_request_msgs()">
                                                <a href='#' add-request req-text="{{msg.text}}" id="{{msg.id}}">{{msg.short_text}}</a> 
                                                <span style="float:right">
                                                    <a href='#' edit-request req-text="{{msg.text}}" id="{{msg.id}}">edit</a> 
                                                    <a href='#' delete-request ng-click="del_request(msg.id, $event)">delete</a>
                                                </span>
                                            </li>
                                        </ul>
                                    </span>

                                    <div class="conf-repl" style="margin-left:-10px">
                                        <?=HTML::link('settings', '(add request message)', array('class' => 'add-request-msg'))?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="reply-box-padding"></div>
            <div class="reply-box-error"></div>

            <div class="reply-box-footer">
                <div class="reply-box-buttons">
                    <input type="button" class="large-btn" value="Cancel" my-request-close/>
                    <input type="submit" class="large-btn" value="Send" my-request-send/>
                </div>
            </div>
        </div>
    </div>
-->
<?=Form::close()?>
