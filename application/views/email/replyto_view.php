<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<style type="text/css">

</style>
<body bgcolor="#dde0e3" style="padding:0;margin:0;font-size:14px;font-family:Arial, Helvetica, sans-serif;color:#464646">
<table bgcolor="#dde0e3" width="716" cellpadding="0" cellspacing="0">

	<tr>
    	<td style="padding:30px 30px 10px;">
        	<table bgcolor="white" style="background:#FFF" cellpadding="0" cellspacing="0">
            	<tr><td style="padding:20px;" cellpadding="0" cellspacing="0">
                	<table width="616" cellpadding="0" cellspacing="0">
                    	<!-- header -->
                        <tr>
                        	<td width="33.33%"><?=HTML::image('img/36storieslogo.jpg')?>
                            </td><td width="33.33%"></td><td width="33.33%" align="right"></td>
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
							<td colspan="3" style="padding-right:100px;line-height:20px;color:#464646;">
                            	<h4 style="line-height:normal"><?=ucfirst($sender)?> has read your feedback and wants to get into contact with you.</h4>  
                                <div style="padding:10px;background:#f4f4f4;">
                                    <?=ucfirst($sender)?> says,<br/>
                                    "<?=ucfirst($message)?>"
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <br/><br/>
                                <h5 style="line-height:normal">Your feedback submitted on <?=date('F j, Y', strtotime($submission_date));?>.</h5> 
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="3">
                            	<table>
                                    <?=$profile_partial_view?>
                                </table>
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
                        <!--
                        <tr>
                        	<td colspan="3"><a href="#" style="color:#6e8cca;">No - I am not interested, do not ever mail me again.</a></td>
                        </tr>
                        -->
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
            This message was intended for <?=$emailto?>.  <br />

            <p style="">
                <b>36Stories Inc</b> 340 Lemon Ave #6168 Walnut CA, 91789 United States
            </p>
            <!--
            If you do not wish to receive this type of email from 36Stories in the future, please click here to unsubscribe.<br />
            36Stories, Inc. P.O. Box 10005, Palo Alto, CA 94303
            -->
       </td>
    </tr>
    <!-- end footer -->    
</table>
</body>
</html>
