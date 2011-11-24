<?=$metrics?>
<?//Helpers::show_data($contact_person)?>
<!-- top blue bar with filter options -->
<div class="admin-sorter-bar">
<table cellpadding="2" width="100%">
    <tr>
        <td width="10"></td>
        <td width="10">
            <?if($contact_person->avatar):?> 
                <?=HTML::image('uploaded_cropped/48x48/'.$contact_person->avatar)?>
            <?else:?>
                <?=HTML::image('img/48x48-blank-avatar.jpg')?>
            <?endif?> 
        </td>
        <td valign="middle"><strong><?=$contact_person->firstname?> <?=$contact_person->lastname?></strong></td>
        <td align="right"><?=HTML::link('contacts'.$page, 'Back to Contacts')?></td>
        <td width="10"></td>
    </tr>
</table>
</div>
<!-- end of top blue bar with filter options -->

<?=Form::open('contacts/edit_contact')?>
<input type="hidden" name="email" value="<?=$contact_person->email?>" />
<input type="hidden" name="page" value="<?=Input::get('page')?>" />
<div class="block">
    <table cellpadding="" width="60%">
        <tr>
            <td><small>First Name :</small> </td>
            <td>
                <input type="text" class="regular-text" name="firstname" value="<?=$contact_person->firstname?>" />
                <?=($errors) ? "<p style='color:red; padding-left:10px'>".$errors->first('firstname')."</p>" : null?>
            </td>
        </tr>
        <tr>
            <td><small>Last Name :</small> </td>
            <td><input type="text" class="regular-text" name="lastname" value="<?=$contact_person->lastname?>" /></td>
        </tr>
        <tr>
            <td><small>Company :</small> </td>
            <td><input type="text" class="regular-text" name="companyname" value="<?=$contact_person->companyname?>"/></td>
        </tr>
        <tr>
            <td><small>Position :</small> </td>
            <td><input type="text" class="regular-text "name="position" value="<?=$contact_person->position?>"/></td>
        </tr>
        <tr>
            <td><small>Country :</small> </td>
            <td>
                <select class="regular-select" name="countryId">
                    <option>Philippines</option>
                    <?foreach($countries as $country):?>
                        <option value="<?=$country->countryid?>" <?=($country->countryid == $contact_person->countryid) ? "selected" : null?>><?=$country->name?></option>
                    <?endforeach?>
                </select>
            </td>
        </tr>
        <tr><td colspan="2"></td></tr>                                         
        <tr>
            <td></td>
            <td>
                <input type="submit" href="#" value="Save Contact" class="gray-btn rounder" 
                       style="border:none;cursor:pointer;font-size:14px;font-weight:bold;color:#565656;padding:6px 8px;margin-right:5px;text-shadow:#d5d8da 0px 1px;">
            </td>
        </tr>
    </table>

<!-- spacer -->
<div class="block noborder" style="height:39px;">
</div>
<!-- spacer -->
</div>
<?=Form::close()?>
<!-- end of feedback list -->
<div class="admin-sorter-bar">

</div>
</div>
