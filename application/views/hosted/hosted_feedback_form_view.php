<?=HTML::style('css/widget_master/hosted-form.css');?>

<?if($hosted):?>
    <?=HTML::style('themes/hosted/form/form-'.$hosted->theme_type.'.css');?>
<?endif?>

<?=$company_header?>
<?=$widget?>
<div class="block" style="height:20px;"></div>
<div class="block" style="text-align:center;font-size:11px;color:#c2c3c4;">Powered by 36Stories</div>
