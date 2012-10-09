<?=Form::open('feedback/requestfeedback', 'POST', array('id' => 'request-form'))?>
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
                <h3>Recepient Details</h3>
                    <div>
                        <table width="80%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="130">
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
                                <td>
                                <label>Message : </label> <br />
                                </td>
                                <td>
                                <textarea class="regular-text" name="message" style="float:left" rows="7" id="recipient-message" ></textarea>
                                    <ul ng-controller="RequestCtrl" class="custom-message">   
                                        <li ng-repeat="msg in get_request_msgs()">
                                            <a href='#' add-request req-text="{{msg.text}}" id="{{msg.id}}">{{msg.short_text}}</a> 
                                            <span style="margin-left:10px">
                                                <a href='#' edit-request req-text="{{msg.text}}" id="{{msg.id}}">edit</a> 
                                                <a href='#' delete-request ng-click="del_request(msg.id, $event)" req-text="{{msg.text}}" id="{{msg.id}}">delete</a> 
                                            </span>
                                        </li>
                                    </ul>
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
        <!-- end of reply-box styles -->
    </div>
<!-- end of reply-box -->
<?=Form::close()?>

<div class="request-configure" style="display:none">  
    <h4>{{name}}</h4>
    <input type="text" class="regular-text" name="msg" value="" /><br/>
    <input type="hidden" name="msgid" value="" />
    <div class="add-msg-box-buttons">
        <input type="button" class="small-btn" value="Cancel" cancel-request-add/>
        <input type="submit" class="small-btn" value="Add Item" add-request-item/>
    </div>
</div>
