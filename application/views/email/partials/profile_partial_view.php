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
