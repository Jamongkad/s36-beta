<?=Form::open('settings/savecompanysettings')?>
<?=Form::hidden('companyid', $user->companyid)?>
<?=Form::hidden('forward_to', Input::get('forward_to'))?>
<div class="block graybg" style="margin-top:10px;border-top:1px solid #dedede;">
    <h3>COMPANY SETTINGS</h3>
</div>
<?=Form::close()?>
