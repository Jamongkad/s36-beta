<?
    $metadata = (!empty($feedback_data->metadata)) ? json_decode($feedback_data->metadata) : false; 
    $attachments = (!empty($feedback_data->attachments)) ? json_decode($feedback_data->attachments) : false; 
?>
<?if($metadata || $attachments):?>
<p><?=$feedback_data->text?></p>
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
