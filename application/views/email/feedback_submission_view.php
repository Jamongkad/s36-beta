<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<?
    $color = null;
    if($feedback_data->rating == "POOR") {
        $color = "#C1431C";
    }

    if($feedback_data->rating == "AVERAGE") {
        $color = "#8BA510";
    }

    if($feedback_data->rating == "EXCELLENT" || $feedback_data->rating == "GOOD") {
        $color = "#109CA5";
    }
?>
<body style="background:#e8e9ec;padding:0;margin:0;">
<br />
<table align="center" bgcolor="#FFFFFF" width="710" bordercolor="#d2d2d2" cellpadding="0" cellspacing="0" style="border-radius:5px;border:1px solid #CCC;font-family:Arial, Helvetica, sans-serif">
	<tr>
    	<td style="padding:20px 30px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                	<td align="left"><?=HTML::image('img/36storieslogo.jpg')?></td>
                    <td align="right">
                    	<a href="<?=$login_url?>" style="font-family:Arial, Helvetica, sans-serif;text-decoration:none;background:#e0f4ff;border:1px solid #76bfe8;border-radius:5px;padding:10px;color:#005983;font-size:14px;"><?=HTML::image('img/manage-icon.jpg')?> Manage Feedback</a>
                    </td>
                </tr>
            </table>    
    	</td>
    </tr>
    <tr>
    	<td>
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr bgcolor="#f3f3f3" height="15"><td colspan="5"></td></tr>
               	<tr bgcolor="#f3f3f3" ><td width="50"></td>
                <td rowspan="8" width="150" style="background:#e6e6e6">                
                    <?if($feedback_data->avatar):?>
                        <?=HTML::image('uploaded_images/avatar/medium/'.$feedback_data->avatar, 'Avatar')?>
                    <?endif?>
                </td>
                <td width="20"></td>
                <td>
                <span style="color:#0077ac;font-weight:bold;font-size:18px;margin:0;padding:0;">
                    <?=$feedback_data->firstname?> <?=$feedback_data->lastname?>
                </span> &nbsp; 
                <span style="font-size:12px;"> 
                    <?if($feedback_data->city && $feedback_data->countryname):?>
                        <?=$feedback_data->city?>, <?=$feedback_data->countryname?>
                    <?endif?>

                    <?if($feedback_data->city == true && $feedback_data->countryname == false):?>
                        <?=$feedback_data->city?>
                    <?endif?>

                    <?if($feedback_data->city == false && $feedback_data->countryname == true):?>
                        <?=$feedback_data->countryname?>
                    <?endif?>
                </span>
                </td><td></td></tr>
                <tr bgcolor="#f3f3f3" height="13"><td colspan="5"></td></tr>
                <tr bgcolor="#f3f3f3" ><td width="50"></td><td width="20"></td>
                <td>
                <?if($feedback_data->int_rating == 5):?>
                    <?=HTML::image('img/star-fill.png')?>
                    <?=HTML::image('img/star-fill.png')?>
                    <?=HTML::image('img/star-fill.png')?>
                    <?=HTML::image('img/star-fill.png')?>
                    <?=HTML::image('img/star-fill.png')?>
                <?endif?>                

                <?if($feedback_data->int_rating == 4):?>
                    <?=HTML::image('img/star-fill.png')?>
                    <?=HTML::image('img/star-fill.png')?>
                    <?=HTML::image('img/star-fill.png')?>
                    <?=HTML::image('img/star-fill.png')?>
                    <?=HTML::image('img/star-empty.png')?>
                <?endif?>

                <?if($feedback_data->int_rating == 3):?>
                    <?=HTML::image('img/star-fill.png')?>
                    <?=HTML::image('img/star-fill.png')?>
                    <?=HTML::image('img/star-fill.png')?>
                    <?=HTML::image('img/star-empty.png')?>
                    <?=HTML::image('img/star-empty.png')?>
                <?endif?>

                <?if($feedback_data->int_rating == 2):?>
                    <?=HTML::image('img/star-fill.png')?>
                    <?=HTML::image('img/star-fill.png')?>
                    <?=HTML::image('img/star-empty.png')?>
                    <?=HTML::image('img/star-empty.png')?>
                    <?=HTML::image('img/star-empty.png')?>
                <?endif?>

                <?if($feedback_data->int_rating == 2):?>
                    <?=HTML::image('img/star-fill.png')?>
                    <?=HTML::image('img/star-empty.png')?>
                    <?=HTML::image('img/star-empty.png')?>
                    <?=HTML::image('img/star-empty.png')?>
                    <?=HTML::image('img/star-empty.png')?>
                <?endif?>

                </td><td></td></tr>
                <tr bgcolor="#f3f3f3" height="10"><td colspan="5"></td></tr>
                <tr bgcolor="#f3f3f3"><td width="50"></td><td width="20"></td><td>
                <span style="font-size:12px;color:#000;">Feedback rating:</span> 
                <span style="border-radius:4px;font-size:10px;color:#FFF;background:<?=$color?>;padding:2px 6px;"> 
                    <?=$feedback_data->rating?>
                </span>
                </td><td></td></tr>
                <tr bgcolor="#f3f3f3" height="15"><td colspan="5"></td></tr>
                <tr bgcolor="#e6e6e6" height="15"><td colspan="5"></td></tr>
                <tr bgcolor="#e6e6e6"><td width="50"></td><td width="20"></td>
                <td><span style="font-size:12px;color:#005983;">Sample Meta : </span><span style="color:#727272;font-size:12px;">Content #1</span>
                
                </td>
                
                <td></td></tr> 
                <tr bgcolor="#e6e6e6" height="15"><td colspan="5"></td></tr>
            </table>    
    	</td>
    </tr>
    <tr height="30">
    </tr>
    <tr>
    	<td style="padding:10px 50px 10px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr><td><span style="color:#15528c;font-size:20px;"><?=$feedback_data->title?></span></td><td align="right">

                <!--publish feedback section -->
                <?if($feedback_data->rating != "POOR" && $feedback_data->permission != "PRIVATE"):?>
                    <a href="<?=URL::to("api/publish?params=".rawurlencode($encryptstring)."&feedback_id={$feedback_data->id}&company_id={$companyid}")?>">
                        <?=HTML::image('img/email-publish.jpg', 'Icon Check')?>
                    </a> 
                <?endif?> 

                </td></tr>
                <tr height="25"></tr>
                <tr><td colspan="2"><p style="line-height:1.6em;font-size:14px;color:#484747;"><?=$feedback_data->text?></p></td></tr>
            </table>    
    	</td>
    </tr>
    <tr height="10">
    </tr>
    <!-- Attachments section -->
    <tr>
    	<td style="padding:10px 50px 20px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border:1px solid #CCC">
                <tr>
                   <td bgcolor="#f7f7f7" style="padding:20px;">
                	  <table style="">
                        <!-- link -->
                        <tr>
                        	<td colspan="3"><img src="images/sample.jpg" width="100%" /></td>
                        </tr>
                      	<!-- images -->
                      	<tr>
                        	<td width="33%"><img src="images/sample.jpg" width="100%" /></td>
                        	<td width="33%"><img src="images/sample.jpg" width="100%" /></td>
                            <td width="33%"><img src="images/sample.jpg" width="100%" /></td>
                        </tr>
                      </table>
                   </td>
                </tr>
            </table>    
    	</td>
    </tr>
    <!-- end of custom fields -->
    <tr>
    	<td style="padding:10px 50px 10px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr><td>

                    <?if($feedback_data->rating != "POOR"):?> 
                        <?if($feedback_data->permission == "FULL PERMISSION"):?>
                            <div style="padding:15px 20px 15px 0px;font-size:12px;background:#d9ebd6;-webkit-border-radius:8px;-moz-border-radius:8px;border-radius:8px;">
                                <?=HTML::image('img/ico-large-check.png', 'Icon Large', array('vertical-align' => 'middle', 'margin-right' => '5px', 'align' => 'left'))?>
                                <span style="vertical-align: middle; " >
                                    <?=$feedback_data->firstname?> 
                                    has granted you FULL permission to quote his/her feedback and profile as a quote in your website and marketing collaterals.
                                </span>
                                <br style="clear:both" />
                            </div>
                        <?endif?>

                        <?if($feedback_data->permission == "PRIVATE"):?>

                            <div style="float:left;padding:15px 20px 15px 0px;font-size:12px;background:#d9ebd6;-webkit-border-radius:8px;-moz-border-radius:8px;border-radius:8px;margin-bottom:20px;margin-top:20px;">
                                <?=HTML::image('img/ico-large-check.png', 'Icon Large', array('vertical-align' => 'middle', 'margin-right' => '5px', 'align' => 'left'))?>
                                <span style="vertical-align: middle; ">
                                    <?=$feedback_data->firstname?> has asked you keep his/her feedback and profile PRIVATE.
                                </span>
                                <br style="clear:both" />
                            </div>
                        <?endif?>
                    <?endif?>

                </td></tr>
            </table>    
    	</td>
    </tr>
    <tr>
    	<td style="padding:10px 50px 20px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr><td>
                	<p style="font-size:13px;">
                        Thanks,<br />
                        The FDBack Team.
                        <br/>
                       <b>36Stories Inc</b> 340 Lemon Ave #6168 Walnut CA, 91789 United States
                    </p>
                </td></tr>
            </table>    
    	</td>
    </tr>
    
</table>
</body>
</html>
