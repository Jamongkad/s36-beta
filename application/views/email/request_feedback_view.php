<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<style type="text/css">

</style>
<body bgcolor="#dde0e3" style="padding:0;margin:0;font-size:14px;font-family:Arial, Helvetica, sans-serif;">
<table bgcolor="#dde0e3" width="716" cellpadding="0" cellspacing="0">
	<tr>
    	<td style="padding:30px 30px 10px;">
        	<table bgcolor="white" style="background-color:white" cellpadding="0" cellspacing="0">
            	<tr><td style="padding:20px;" cellpadding="0" cellspacing="0">
                	<table width="616" cellpadding="0" cellspacing="0">
                    	<!-- header -->
                        <tr>
                        	<td width="33.33%"><?=HTML::image('img/36storieslogo.jpg')?></td>
                            <td width="33.33%"></td><td width="33.33%" align="right"></td>
                        </tr>
                        <tr height="20">
                        	<td colspan="3"></td>
                        </tr>
                        <tr height="1" bgcolor="#e7e9eb">
                        	<td colspan="3"></td>
                        </tr>
                        <tr height="20">
                        	<td colspan="3"></td>
                        </tr>
                        
                        <!-- end of header -->
                        <!-- contents -->
                        <tr>
                        	<td colspan="3" style="padding-right:140px;line-height:20px;color:#464646;">
                            	<h1 style="line-height:normal">Hi there. We'd really like to hear from you.</h1>
								<br />                           		
                                Hi <?=$email_data->first_name?>,
								<br /><br />
								<?=$message->user->fullname?> from <?=$message->company->name?> has requested to have your feedback.
								<br /><br />
								To leave feedback all you need to do is to follow the URL below. It won't take long!
                        		<br /><br /><br />
                            	<a href="<?=URL::to("widget/form?siteId={$message->sites}&companyId={$message->user->companyid}&themeId=1")?>" target="new" style="padding:15px 20px;color:#0d8eae;background:#c2dcc9;-webkit-border-radius:8px;-moz-border-radius:8px;border-radius:8px;">Our Feedback Form
                                </a>
                            	<br /><br /><br />
                            	We greatly appreciate your time.
								<br /><br />
                                <?=ucfirst($message->user->username)?> also has this to add:
								<br /><br />                                
                                <h3>"<?=$message->custom_message?>"</h3>
                            </td>
                        </tr>
                        <tr height="80">
                        	<td colspan="3"></td>
                        </tr>
                        
                        <!-- end of contents -->
                        
                        <!-- sig -->
                        <tr>
                        	<td colspan="3">
                            				Thanks, <br />
											The 36Stories Team
                            </td>
                        </tr>
                        <tr height="20">
                        	<td colspan="3"></td>
                        </tr>
                        <tr>
                        	<td colspan="3"><a href="#" style="color:#6e8cca;">No - I am not interested, do not ever mail me again.</a></td>
                        </tr>
                        <tr height="20">
                        	<td colspan="3"></td>
                        </tr>
                        
                        <!-- end sig -->
                    </table>
                </td></tr>
            </table>
        </td>
    </tr>
    <!-- footer -->
    <tr>
        <td style="font-size:10px;padding:0px 30px;line-height:16px;">
            This message was intended for <?=$address->email?>.  <br />
            If you do not wish to receive this type of email from 36Stories in the future, please click here to unsubscribe.<br />
            36Stories, Inc. P.O. Box 10005, Palo Alto, CA 94303
       </td>
    </tr>
    <!-- end footer -->    
</table>
</body>
</html>
