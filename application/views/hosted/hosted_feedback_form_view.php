<div id="headerWrapper">
	<div id="headerContent">
    	<div id="headerTitle">
            <?$company_name = ucfirst($company->name);?>

        	<strong><?=$company_name?></strong>  
            <span><?=HTML::link('/', 'View all feedback')?></span>
            
            <?if($company->domain):?>
                <span class="right padfix">
                    <?=HTML::link($company->domain, "Visit $company_name's Website")?>
                </span>
            <?endif?>
        </div>
    </div>
</div>
<?=$widget?>
