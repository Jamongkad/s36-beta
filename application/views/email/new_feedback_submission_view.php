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
                                    <?=$profile_partial_view?>
                                </table>
                            </td>
                        </tr>

                        <?//quick and dirty css fix to move damn manage feedback button to the right
                        $poor_style = null;
                        if($feedback_data->rating == "POOR") {
                            $poor_style = "20px;";
                        }
                        ?>
                        
                        <tr>
                        	<td colspan="3" style="line-height:20px;">
                            <div style="padding:<?=$poor_style?>;float:left">
                                <?=$feedback_data->text?>  
                                <?
                                    $metadata = (!empty($feedback_data->metadata)) ? json_decode($feedback_data->metadata) : false; 
                                    $attachments = (!empty($feedback_data->attachments)) ? json_decode($feedback_data->attachments) : false; 
                                ?>

                                    <?if($metadata || $attachments):?>
                                        <div style="float:left;background:#f7f7f7;border:1px solid #dde7ef;padding:15px;margin-top:10px;
                                        ">
                                            <div style="margin-bottom: 10px">
                                                <? 
                                                //start metadata 
                                                if($metadata):
                                                    foreach($metadata as $key => $val):?>
                                                        <?foreach($val as $k => $v):?>
                                                            <div style="float:left">
                                                                <div style=" 
                                                                    font-weight:bold;
                                                                    font-size:11px;
                                                                    color:#6499cd;
                                                                    float:left;
                                                                    margin-right:10px;
                                                                ">
                                                                    <?if($key == 'select'):?>
                                                                        <?=ucwords($k)?>: 
                                                                    <?endif?>

                                                                    <?if($key == 'checkbox' || $key == 'radio' || $key == 'text'):?>
                                                                        <?=ucwords(str_replace("_", " ", $k));?>:
                                                                    <?endif?>

                                                                    <?
                                                                        $prefix = "";
                                                                        $value_list = "";
                                                                        foreach($v as $d) {
                                                                            $value_list .= "<span style='color:#a2a2a2;'>" . $prefix . $d->value . "</span>";    
                                                                            $prefix = ", ";
                                                                        }
                                                                        echo $value_list;
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        <?endforeach?> 
                                                    <?endforeach?>
                                                <?endif?>
                                            </div>
                                    <?php if($attachments): ?>
                                        <div class="uploaded-images-and-links grids">
                                            <?php 
                                            /*
                                            | Start Video and Web Link Attachment
                                            */
                                            if(isset($attachments->attached_link)):?>
                                                <div style="float:left;width:100%;margin-bottom:15px">
                                                        <?php 
                                                        //video attachments
                                                        if($attachments->attached_link->video=='yes'):?>
                                                            <a class="inbox-fancybox-video" href="<?=str_replace('http','https',$attachments->attached_link->url)?>" rel="inbox-videos-<?=$id?>" style="display:block">
                                                            <div class="the-thumb">
                                                                <img src="<?=$attachments->attached_link->image?>"  />
                                                            </div>
                                                            </a>
                                                        <?else:?>
                                                            <div class="attached-link-thumb">
                                                                <a href="<?=$attachments->attached_link->url?>" target="_blank">
                                                                    <img src="<?=$attachments->attached_link->image?>" />
                                                                </a>
                                                            </div>
                                                            <div class="attached-link-details">
                                                                <h3><?=$attachments->attached_link->title?></h3>
                                                                <p style="font-size:10px"><?=$attachments->attached_link->description?></p>
                                                            </div>   
                                                        <?endif?>
                                                </div>
                                                <br/>
                                            <?php 
                                            /*
                                            | End Video and Web Link Attachment
                                            */
                                            endif;
                                            /*
                                            | Start Image Attachments
                                            */
                                            if(isset($attachments->uploaded_images)):?>
                                                <?php
                                                if(count($attachments->uploaded_images) == 1) $width='100%';
                                                if(count($attachments->uploaded_images) == 2) $width='50%';
                                                if(count($attachments->uploaded_images) == 3) $width='33%';
                                                ?>
                                                <?php foreach($attachments->uploaded_images as $uploaded_image): ?>
                                                    <div  style="float:left;width:<?=$width;?>">
                                                        <div class="the-thumb">
                                                            <a class="inbox-fancybox-image" href="<?=Config::get('application.attachments_large').'/'.$uploaded_image->name?>">

                                                            <?if(count($attachments->uploaded_images) == 1):?>
                                                                <img src="<?=Config::get('application.attachments_large').'/'.$uploaded_image->name?>" />
                                                            <?else:?>
                                                                <img src="<?=Config::get('application.attachments_medium').'/'.$uploaded_image->name?>"  />
                                                            <?endif?>

                                                            </a>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php
                                            /*
                                            | End Image Attachments
                                            */
                                            endif;
                                            ?>
                                        </div>
                                    <?php endif;?>
                                <?php endif;?>
                            </div>
                                <br />
                                <br /> 
                                <?if($feedback_data->rating != "POOR"):?>

                                    <?if($feedback_data->permission == "FULL PERMISSION"):?>
                                     <div style="float:left;padding:15px 20px 15px 0px;font-size:12px;background:#d9ebd6;-webkit-border-radius:8px;-moz-border-radius:8px;border-radius:8px;margin-bottom:20px;margin-top:20px;">
                                     <?=HTML::image('img/ico-large-check.png', 'Icon Large', array('vertical-align' => 'middle', 'margin-right' => '5px', 'align' => 'left'))?>
                                        <span style="vertical-align: middle; " >
                                        <?=$feedback_data->firstname?> 
                                        has granted you FULL permission to quote his/her feedback and profile as a quote in your website and marketing collaterals.
                                        </span>
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
                                <br />
                                <?endif?>
                                <?if($feedback_data->rating != "POOR" && $feedback_data->permission != "PRIVATE"):?>
                                    <a href="<?=URL::to("api/publish?params=".rawurlencode($encryptstring)."&feedback_id={$feedback_data->id}&company_id={$companyid}")?>" style="text-decoration:none;margin-right:10px;font-size:11px;background:#ccf2cd;padding:7px 20px 7px 2px;color:#464646;-webkit-border-radius:5px;-moz-border-radius:5px;border-radius:5px;">
                                    <?=HTML::image('img/ico-check.png', 'Icon Check', array('style' => 'vertical-align:middle'))?>
                                    <span style="vertical-align: middle">Publish this feedback now</span>
                                    </a> 
                                <?endif?>
                                    
                                <a href="<?=$login_url?>" style="text-decoration:none;margin-left:<?=$poor_style?>;margin-right:10px;font-size:11px;background:#d2dbe1;padding:7px 20px 7px 2px;color:#464646;-webkit-border-radius:5px;-moz-border-radius:5px;border-radius:5px;">
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
                                <div style="padding:<?=$poor_style?>">
                                    Thanks, <br />
                                    The 36Stories Team
                                </div>
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
            This message was intended for <?=$address?>
            <br/> 

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
