<?php
$companyInfo		=	$accountInfo->companyInfo;
$currentPlanInfo  = 	$accountInfo->companyPlanInfo;
$newPlanInfo		=	$newPlanInfo;
?>
<div class="block noborder">
            	<h3>Please confirm the upgrade from <?=$currentPlanInfo->name?> to <?=$newPlanInfo->name?></h3>
                <p>You're upgrading your "<?=$companyInfo->company_name?>" account located at <?=$companyInfo->domain?>.</p>
                <p>Once you click the button below you'll be upgraded to the <?=$newPlanInfo->name?> plan. You'll be charged the new rate of $<?=$newPlanInfo->price?>/month starting on your next bill.</p>
                <p>
                	<strong>
                		<?=HTML::link("settings/upgrade/?planId=$newPlanInfo->planid&action=success",'Upgrade my Account',array('id' => 'upgrade-account','class'=>'gray-btn'))?>
                		or 
                		<?=HTML::link('settings/upgrade','Cancel')?>
                	</strong>
                </p>
                <!--
                <h4>Any questions? Just <a href="#">contact us</a>, we'll help. <a href="#">36Stories support</a></h4>
                -->
</div>
<div style="height:300px;" class="block noborder"></div>