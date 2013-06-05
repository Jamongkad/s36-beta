<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body style="background:#e8e9ec;padding:0;margin:0;">
<br />
<table align="center" bgcolor="#FFFFFF" width="710" bordercolor="#d2d2d2" cellpadding="0" cellspacing="0" style="border-radius:5px;border:1px solid #CCC;font-family:Arial, Helvetica, sans-serif">
	<tr height="10"><td></td></tr>
    <tr>
    	<td style="padding:20px 50px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                   <?
                      $padding = null;
                      if($email_data->company_logo) {
                          $padding = "padding-left:10px";
                      }
                   ?>
                    <?if($email_data->company_logo):?>
                        <td align="left" width="170">
                            <img src="/company_logos/<?=$email_data->company_logo?>" /> 
                        </td>
                    <?endif?>
                    <td>
                    	<span style="font-size:20px;color:#06C;<?=$padding?>"><?=ucfirst($email_data->company_name)?></span>
                    </td>
                    <td align="right"> 
                        <?=HTML::image('img/36storieslogo.jpg')?>
                    </td>
                </tr>
            </table>    
    	</td>
    </tr>
    <tr>
    	
    </tr>
    <tr height="30">
    </tr>
    <tr>
    	<td style="padding:10px 50px 10px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr><td colspan="3"><span style="color:#444;font-size:20px;"><?=$message?></span></td><td align="right"></td></tr>
                <tr height="45"></tr>
                <tr style="border-bottom:2px solid #005000"><td colspan="3"><span style="font-weight:bold;font-style:italic;font-size:12px;">In response to your feedback that you sent on <?=date('l, jS M Y', strtotime($submission_date));?></span></td></tr>
                <tr height="5"></tr>
                <tr><td colspan="2" style="border-top:1px solid #999;"></td></tr>
                <tr height="45"></tr>
                <tr><td valign="top" width="78" style="padding-top:5px;"><img src="images/lola.jpg" width="48" /></td><td colspan="2"><p style="line-height:1.6em;font-size:14px;color:#484747;">The technology was great, I have never seen one like this in the market yet. 
I like how you became so innovative with what you offer to your customers. 
I will definitely buy more of your stuff!</p></td></tr>
				<tr height="40"></tr>
            </table>    
    	</td>
    </tr>
    <tr height="10">
    </tr>
    <!-- if there are custom fields then include this part -->
    
    <!-- end of custom fields -->
    
    <tr>
    	<td style="padding:10px 50px 20px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr><td>
                	<p style="font-size:13px;">
                    Thanks,<br />
                    The FDBack Team.
                    </p>
                </td></tr>
            </table>    
    	</td>
    </tr>
    
</table>
</body>
</html>
