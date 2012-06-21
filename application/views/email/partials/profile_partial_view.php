<tr>
<?if($feedback_data->rating != "POOR"):?>
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
            <a href="<?=$feedback_data->url?>" target="_blank"><?=$feedback_data->url?></a><br />
            <?=$feedback_data->city?>, <?=$feedback_data->countryname?>
        <?endif?>
    </td>
</tr>
