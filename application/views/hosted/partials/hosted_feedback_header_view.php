<div id="headerWrapper">
	<div id="headerContent">
    	<div id="headerTitle">
            <?$company_name = ucfirst($company_name);?>
            <?if(!$sample_name):?>
                <?if($fullpage_company_name):?>
                    <strong>
                        <a href="https://<?=strtolower($company_name).".".$hostname?>.com"><?=$fullpage_company_name?></a>
                    </strong>              
                <?else:?>
                    <strong> 
                        <a href="https://<?=strtolower($company_name).".".$hostname?>.com"><?=$company_name?></a>
                    </strong>              
                <?endif?>
            <?else:?>
                <strong> 
                    <a href="https://<?=strtolower($company_name).".".$hostname?>.com"><?=$sample_name?></a>
                </strong>              
            <?endif?>

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
