<body bgcolor="#dde0e3" style="padding:0;margin:0;font-size:14px;font-family:Arial, Helvetica, sans-serif;">
<table bgcolor="#dde0e3" width="716" cellpadding="0" cellspacing="0">
	<tr>
    	<td style="padding:30px 30px 10px;">
        	<table bgcolor="white" style="background: #fff" cellpadding="0" cellspacing="0">
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
                        	<td colspan="3">
                            	<table>
                                	<tr>
                                        <?if($feedback_data->avatar):?>
                                            <td><?=HTML::image('uploaded_cropped/150x150/'.$feedback_data->avatar, 'Avatar', array('width' => '91', 'height' => '91'))?></td>
                                            <td width="10"></td>
                                        <?endif?>
                                        <td style="font-size:12px;">
                                        	<h2 style="color:#0078aa;margin:0px;"><?=$feedback_data->firstname?> <?=$feedback_data->lastname?></h2>
                                            <strong><?=$feedback_data->position?></strong><br />
                                            <?=$feedback_data->companyname?><br />
                                            <a href="#" target="_blank"><?=$feedback_data->url?></a><br />
                                            <?=$feedback_data->city?> 
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr height="20">
                        	<td colspan="3"></td>
                        </tr>
                        <tr>
                        	<td colspan="3" style="line-height:20px;">
                                "<?=$feedback_data->text?>"
                                <br /><br /> 
                                <?if($feedback_data->permission == "FULL PERMISSION"):?>
                                 <div style="padding:15px 20px 15px 0px;font-size:12px;background:#d9ebd6;-webkit-border-radius:8px;-moz-border-radius:8px;border-radius:8px;">
                                 <?=HTML::image('img/ico-large-check.png', 'Icon Large', array('vertical-align' => 'middle', 'margin-right' => '5px', 'align' => 'left'))?>
                                    <span style="vertical-align: middle; " >
                                	<?=$feedback_data->firstname?> has granted you FULL permission to quote his/her feedback and profile as a quote in your website and marketing collaterals.

                                    </span>
                                </div>
                                <?endif?>

                                <?if($feedback_data->permission == "LIMITED PERMISSION"):?>
                                 <div style="padding:15px 20px 15px 0px;font-size:12px;background:#d9ebd6;-webkit-border-radius:8px;-moz-border-radius:8px;border-radius:8px;">
                                 <?=HTML::image('img/ico-large-check.png', 'Icon Large', array('vertical-align' => 'middle', 'margin-right' => '5px', 'align' => 'left'))?>
                                    <span style="vertical-align: middle; " >
                                	<?=$feedback_data->firstname?> has granted you LIMITED permission to quote his/her feedback and profile as a quote in your website and marketing collaterals.

                                    </span>
                                </div>


                                <?endif?>

                                <?if($feedback_data->permission == "PRIVATE"):?>

                                 <div style="padding:15px 20px 15px 0px;font-size:12px;background:#d9ebd6;-webkit-border-radius:8px;-moz-border-radius:8px;border-radius:8px;">
                                 <?=HTML::image('img/ico-large-check.png', 'Icon Large', array('vertical-align' => 'middle', 'margin-right' => '5px', 'align' => 'left'))?>
                                    <span style="vertical-align: middle; ">
                                	<?=$feedback_data->firstname?> has asked you keep his/her feedback and profile PRIVATE.
                                    </span>
                                    <br style="clear:both" />
                                </div>

                                <?endif?>
                                
                                <br />
                                <?if($feedback_data->rating == "POOR"):?>
                                    <?=$feedback_data->rating?>
                                <?else:?>
                                <a href="<?=URL::to("api/publish?params=".rawurlencode($user->encryptstring)."&feedback_id={$feedback_data->id}&company_id={$user->companyid}")?>" style="text-decoration:none;margin-right:10px;font-size:11px;background:#ccf2cd;padding:7px 20px 7px 2px;color:#464646;-webkit-border-radius:5px;-moz-border-radius:5px;border-radius:5px;">
                                <?=HTML::image('img/ico-check.png', 'Icon Check', array('style' => 'vertical-align:middle'))?>
                                <span style="vertical-align: middle">Publish this feedback now</span>
                                </a> 
                                <?endif?>
                                <a href="<?=URL::to("/?feedback_id={$feedback_data->id}")?>" style="text-decoration:none;margin-right:10px;font-size:11px;background:#d2dbe1;padding:7px 20px 7px 2px;color:#464646;-webkit-border-radius:5px;-moz-border-radius:5px;border-radius:5px;">
                                <?=HTML::image('img/ico-manage.png', 'Icon Manage', array('style' => 'vertical-align:middle'))?>
                                <span style="vertical-align: middle">Manage Feedback</span>
                                </a>
                                
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
            This message was intended for <?=$address->email?>
            <br/> 
            If you do not wish to receive this type of email from 36Stories in the future, please click here to unsubscribe.<br />
            36Stories, Inc. P.O. Box 10005, Palo Alto, CA 94303
       </td>
    </tr>
    <!-- end footer -->    
</table>
</body>
