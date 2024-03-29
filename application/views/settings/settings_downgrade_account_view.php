<?php
$companyInfo		=	$accountInfo->companyInfo;
$currentPlanInfo  = 	$accountInfo->companyPlanInfo;
$newPlanInfo		=	$newPlanInfo;
?>
<div class="block noborder">
            	<h3>Please confirm the downgrade from <?=$currentPlanInfo->name?> to <?=$newPlanInfo->name?></h3>
                <p>You're downgrading your "<?=$companyInfo->company_name?>" account located at <?=$companyInfo->domain?>.</p>
                <p>Once you click the button below you'll be downgraded to the <?=$newPlanInfo->name?> plan. You'll be charged the new rate of $<?=$newPlanInfo->price?>/month starting on your next bill.</p>
                <p>
                	<strong>
                		<?=HTML::link("settings/upgrade/?planId=$newPlanInfo->planid&action=success",'Downgrade my Account',array('id' => 'downgrade-account','class'=>'gray-btn'))?>
                		or 
                		<?=HTML::link('settings/upgrade','Cancel')?>
                	</strong>
                </p>
</div>
<div style="height:300px;" class="block noborder"></div>
