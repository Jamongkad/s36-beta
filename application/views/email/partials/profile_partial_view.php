<tr>
<?if($feedback_data->rating != "POOR"):?>
    <span style="font-size:12px;">Feedback rating :</span> 
    <span style="background:#109CA5;font-size:10px;color:white;padding: 2px 8px;-webkit-border-radius: 6px;-moz-border-radius: 6px;border-radius:6px;">
        EXCELLENT
    </span>
    <br/>
    <?if($feedback_data->avatar):?>
        <td><?=HTML::image('uploaded_cropped/150x150/'.$feedback_data->avatar, 'Avatar')?></td>
        <td width="10"></td>
    <?endif?>
<?endif?>
    <td style="font-size:12px;">
        <h2 style="color:#0078aa;margin:0px;"><?=$feedback_data->firstname?> <?=$feedback_data->lastname?></h2> 
        <?if($feedback_data->rating != "POOR"):?>
            <strong><?=$feedback_data->position?></strong><br />
            <?=$feedback_data->companyname?><br />
            <?if($feedback_data->url):?>
                <a href="<?=$feedback_data->url?>" target="_blank"><?=$feedback_data->url?></a><br />
            <?endif?>
            <?if($feedback_data->city && $feedback_data->countryname):?>
                <?=$feedback_data->city?>, <?=$feedback_data->countryname?>
            <?endif?>

            <?if($feedback_data->city == true && $feedback_data->countryname == false):?>
                <?=$feedback_data->city?>
            <?endif?>

            <?if($feedback_data->city == false && $feedback_data->countryname == true):?>
                <?=$feedback_data->countryname?>
            <?endif?>
        <?endif?>
    </td>
</tr>
