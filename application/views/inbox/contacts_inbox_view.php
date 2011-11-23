<?=$metrics?>
<div class="admin-sorter-bar">

<table cellpadding="2" width="100%">
    <tr>
        <td width="10"></td>
        <td width="10">
            <?if($contact_person[0]->avatar):?> 
                <?=HTML::image('uploaded_cropped/48x48/'.$contact_person[0]->avatar)?>
            <?else:?>
                <?=HTML::image('img/48x48-blank-avatar.jpg')?>
            <?endif?> 
        </td>
        <td valign="middle"><strong><?=$contact_person[0]->firstname?> <?=$contact_person[0]->lastname?></strong></td>
        <td align="right"><a href="#">Back to Contacts</a></td>
        <td width="10"></td>
    </tr>
</table>
<div class="sorter-bar">
    <div class="left">
        &nbsp;
    </div>
    <div class="right">
        <div class="g4of5">
            &nbsp;
        </div>
        <div class="g1of5">     
            &nbsp;
        </div>
    </div>
    <div class="c"></div>
</div>
</div>
<!-- end of top blue bar with filter options -->
