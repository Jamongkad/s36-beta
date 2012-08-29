<div id="headerWrapper">
	<div id="headerContent">
    	<div id="headerTitle">
            <?$company_name = ucfirst($company_name);?>
        	<strong><?=$company_name?></strong>              
            <span><a href="https://<?=strtolower($company_name).".".$hostname?>.com">View all feedback</a></span>
       		<span><a class="green-cross" href="<?=$deploy_env.'/'.strtolower($company_name).'/submit'?>">Send in feedback</a></span>            
            <?if($domain):?>
                <span class="right padfix">
                    <a href="https://<?=$domain?>" target="_blank"><?="Visit $company_name's Website"?></a>
                </span>
            <?endif?>        
        </div>
    </div>
</div>
