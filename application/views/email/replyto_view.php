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
                                    "<?=ucfirst(strtolower($message))?>"
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <br/><br/>
                                <h5 style="line-height:normal">Your feedback was submitted on <?=date('F j, Y', strtotime($submission_date));?>.</h5> 
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="3">
                            	<table>
                                    <?=$profile_partial_view?>
                                    <?
                                        $metadata = (!empty($feedback->metadata)) ? json_decode($feedback->metadata) : false; 
                                        $attachments = (!empty($feedback->attachments)) ? json_decode($feedback->attachments) : false; 
                                    ?>
                                    <tr>
                                    <?if($metadata || $attachments):?>
                                        <div style="float:left;background:#f7f7f7;border:1px solid #dde7ef;padding:15px;margin-top:10px;
                                        ">
                                            <div style="margin-bottom: 10px;float:left">
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
                                        <div style="float:left;">
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
                                                            <a class="inbox-fancybox-image" href="<?=Config::get('application.url')?><?=Config::get('application.attachments_large').'/'.$uploaded_image->name?>">

                                                            <?if(count($attachments->uploaded_images) == 1):?>
                                                                <img src="<?=Config::get('application.url')?><?=Config::get('application.attachments_large').'/'.$uploaded_image->name?>" />
                                                            <?else:?>
                                                                <img src="<?=Config::get('application.url')?><?=Config::get('application.attachments_medium').'/'.$uploaded_image->name?>"  />
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
                                    </tr>
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
                        <!-- end sig -->
                    </table>
                </td></tr>
            </table>
        </td>
    </tr>
    <!-- footer -->
</table>
</body>
</html>
