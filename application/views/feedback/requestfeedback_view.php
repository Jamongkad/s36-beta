<div class="block">
    <?if($submission_widgets->form_widgets->widget->total_rows > 0):?>
    <div id="request-setup-block">                    
        <?=Form::open('feedback/requestfeedback', 'POST', array('id' => 'requestForm'))?>
        <div class="request-options">
            <h2>Request Feedback</h2>
            <div class="request-types">
                <h3><label for="full_page_type">Recipient Details</label></h3>
                <div class="request-form" id="full_page_request">
                    <table width="100%">
                        <tr>
                            <td width="120">
                            <label>First Name: </label><br />
                            <input type="text" name="first_name" class="regular-text" id="recipient-fname" value="<?=$input['first_name']?>"/>
                            <?=($errors) ? "<p style='color:red; padding-left:10px'>".$errors->first('first_name')."</p>" : null?>
                            </td>
                            <td width="120">
                            <label>Last Name: </label><br />
                            <input type="text" name="last_name" class="regular-text" id="recipient-lname" value="<?=$input['last_name']?>"/>
                            <?=($errors) ? "<p style='color:red; padding-left:10px'>".$errors->first('last_name')."</p>" : null?>
                            </td>
                        </tr>
                        <tr>
                            <td width="120">
                            <label>Email: </label><br />
                            <input type="text" name="email" class="regular-text" id="recipient-email" value="<?=$input['email']?>"/>
                            <?=($errors) ? "<p style='color:red; padding-left:10px'>".$errors->first('email')."</p>" : null?>
                            </td>
                            <td width="120">
                            <label>Website: </label><br />
                            <select name="site_id">
                                <?foreach($sites as $site):?>
                                    <option value="<?=$site->siteid?>"><?=$site->domain?></option>
                                <?endforeach?>
                            </select>
                            </td>
                        </tr>
                        <tr>
                            <td width="120">
                            <div style="padding-left:6px">
                                <label>Submission Forms: </label><br />
                                <select name="widgetkey">
                                    <?foreach($submission_widgets->form_widgets->widget->widgets as $widgets):?>
                                        <option value="<?=$widgets->widgetkey?>">
                                            <?=$widgets->widget_obj->theme_name?>
                                        </option>
                                    <?endforeach?>
                                </select>
                            </div>
                            </td> 
                        </tr>
                        <tr>
                            <td colspan="2">
                            <label>Message : </label> <br />
                            <?=($errors) ? "<p style='color:red; padding-left:10px'>".$errors->first('message')."</p>" : null?>
                            <textarea class="regular-text" name="message" style="width:400px;float:left" rows="7" id="message" ><?=$input['message']?></textarea>

                            <ul class="custom-message">
                                <li>Custom Message #1</li>
                                <li>Custom Message #2</li>
                                <li>Custom Message #3</li>
                            </ul>
                            </td>
                        </tr>
                    </table>
                </div>
                <h3>&nbsp;</h3>
                <div class="request-opts">
                    <span class="gray">Drop a request to someone you want to get feedback from. You can write your own custom message, or use one of our template messages. The recipient will receive a custom email with a link to send in their feedback with. For a sample of the email, click here.</span>
                </div>
            </div> 
        </div>
        <div class="request-setup-border"></div>  
        <div style="padding:10px">
            <br /> 
            <input type="submit" class="large-btn" value="Request Feedback" id="send_request"/>
            <br /><br />
        </div>
        <?=Form::close()?>
    </div>

    <?else:?>
        <div class="woops">
            <h2>Woops. You cannot request feedback without creating a submission form first.</h2><br/><br/>
            <p>
             Fortunately it's super easy to create one! 
             <strong style="font-size:12px"><?=HTML::link('feedsetup/submission_widgets', 'Click here', Array('class' => 'woops-a'))?> </strong>
             to create your submission form. </p>
        </div> 
    <?endif?>
</div>

<style type="text/css">
#request-setup-block{
background:#f4f4f4;	
margin-left:-10px;
}
.request-setup-border{display:block;height:2px;background:url(images/false-border.png);}
.request-options{
padding-bottom:10px;
}
.request-options h2{
background:#6b7984;
color:#dedede;
font-size:14px;
display:block;
padding:4px 8px;
border:1px solid #626f79;
}
.request-types{
padding:10px 20px 0px;
}
.request-types h3{
cursor:pointer !important;
font-size:14px !important;
color:#778086 !important; 
display:block;
padding-bottom:10px;
margin:0px !important;
background:url(images/false-border.png) repeat-x bottom;
}
.request-types h3 label{cursor:pointer;}
.request-opts{
padding:5px 10px;
}
.request-form{
padding:5px 10px;
}
.templates ul{list-style:none}
.templates ul li{width:84px;}
.request-opts a.button{
background:#d1e2f1 url(images/button-highlight.png) top repeat-x;
color:#6b8194;
padding:4px 11px;
-webkit-border-radius:12px;
-moz-border-radius:12px;
border-radius:12px;
border:1px solid #9ebdd8;
font-weight:bold;
}
.request-opts a.button:hover{background:#dce9f5;}

.request-opts a.button-gray{
background:#eceff1 url(images/button-highlight.png) top repeat-x;
color:#6b8194;
padding:4px 11px;

-webkit-border-radius:12px;
-moz-border-radius:12px;
border-radius:12px;
border:1px solid #c1c8d0;
font-weight:bold;
}
.request-opts a.button-gray:hover{background:#dce9f5;}
#request-preview{
width:360px;
margin-left:19px;
float:left;
position:absolute;
top:20px;
left:200px;
}
.request-block{
border:1px solid #c8ced2;
-webkit-border-radius:4px;
-moz-border-radius:4px;
border-radius:4px;
margin-bottom:15px;
overflow:hidden;
}
.request-block h2{
display:block;
border-top:1px solid #ffffff;
border-bottom:1px solid #c8ced2;
color:#8a9196;
text-shadow:#fafafa 0px 1px;
font-size:14px;font-weight:bold;
padding:8px 12px;
background:#eceff1;
}
.request-block .html-code textarea{display:block;width:338px;height:133px;border:none;padding:10px;font-size:11px;}

.request-form{
padding:5px 10px;
}
.request-form label{padding-left:6px;}
.request-form .custom-message{float:left;list-style:none;padding-left:10px;}
.request-form .custom-message li{margin:0px;padding:0px;font-size:11px;}
.request-opts span.gray{color:#707d87;font-size:10px;}
.error-message{background:url(/img/yellow-error.png) repeat;padding:10px 30px;color:#565758;margin:0px -20px;font-weight:bold;}
.float-right{float:right;}
</style>
