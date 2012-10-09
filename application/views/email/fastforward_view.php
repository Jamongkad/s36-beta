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
                                This feedback has been forwarded to you by <?=$sender?>.
                                <br/>
                                <br/>
                                <?if($message):?>
                                    <?=$sender?> also added: <br/>
                                    <p style="font-style: italic"><?=$message?></p>
                                <?endif?>
                        <br/><br/>
                            </td>
                        </tr>

                        <tr>
                        	<td colspan="3" style="line-height:20px;border-top:1px solid #dde0e3" >
                            	<table>

                                	<tr>

                                        <?if($feedback_data->avatar):?>
                                            <td><?=HTML::image('uploaded_cropped/150x150/'.$feedback_data->avatar, 'Avatar', array('width' => '91', 'height' => '91'))?></td>
                                            <td width="10"></td>
                                        <?endif?>
                                    	
                                        <td width="10"></td>
                                        <td style="font-size:12px;">
                                        	<h2 style="color:#0078aa;margin:0px;"><?=$feedback_data->firstname?> <?=$feedback_data->lastname?></h2>
                                            <strong><?=$feedback_data->position?></strong><br />
                                            <?=$feedback_data->companyname?><br />
                                            <a href="#" target="_blank"><?=$feedback_data->url?></a><br />
                                            <?=$feedback_data->city?> 
                                        </td>
                                    </tr>
                                    <tr height="30">
                                    	<td colspan="4"></td>
                                    </tr>
                                    <tr>
                                    	<td colspan="4"> 
                                            "<?=$feedback_data->text?>"
                                        </td>
                                    </tr>
                                </table>
                                
                            </td>

                        </tr>

                        <tr>                        	
							<td colspan="3" style="padding-right:100px;line-height:20px;color:#464646;"> 
                            <a href="<?=$login_url?>" style="color:#6e8cca;">To know more please click on the link to login</a>
                            </td>
                        </tr>
                        <tr height="40">
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
            This message was intended for <?=$receiver->email?>.  <br />
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
