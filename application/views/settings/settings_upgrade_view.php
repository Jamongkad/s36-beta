<?php
$companyInfo				=	(isset($accountInfo->companyInfo))        ? $accountInfo->companyInfo : false;
$companyPlanInfo 			= 	(isset($accountInfo->companyPlanInfo))	  ? $accountInfo->companyPlanInfo : false;
$companyBillingInfo		    =	(isset($accountInfo->companyBillingInfo)) ? $accountInfo->companyBillingInfo : false;
?>
<div class="block">
	
	<?php
	if(isset($result) && $result == 'completed'){?>            	
		<div class="alert alert-success">Your subscription plan has been updated.</div>
	<?php } ?>

	<?php
	if($companyBillingInfo && $companyPlanInfo->planid!=1){?>
		   <h3>Your account details</h3>
       <p class="small">
       <strong>
       Next charge: $<?=$companyBillingInfo->nextBill->amount?> 
       on <?php echo date("d M Y",strtotime($companyBillingInfo->nextBill->date->date)); ?> 
       on <?=$companyBillingInfo->nextBill->card_type?> 
       (<a href="/settings/change_billing_info#credit_card">change card</a>)
       </strong>
       </p>
       <br />
    <?php } ?>

    <?php /*List of Plans Start*/ ?>
    <div class="upgrade-box">
    	<?php if(isset($companyPlanInfo)){?>
    	<?php if($companyPlanInfo->planid == 4){ ?>
    		<div class="box3 <?=$companyPlanInfo->upgrade_images->current?>"></div>
    	<?php } else { ?>
    		<div class="upgrade-box-arrow"></div>
        	<div class="box1 <?=$companyPlanInfo->upgrade_images->current?>"></div>
        	<div class="box2 <?=$companyPlanInfo->upgrade_images->upgrade?>"></div>
      <?php }} ?>
    </div>
    <br />
    <table width="100%" class="regular-table" cellpadding="0" cellspacing="0">
    	<thead>
        	<tr>
        		<td class="align-left">Available Plans</td>
        		<td>Featured Feedback</td><td>Admin Accounts</td>
        		<td>Moderation</td>
        		<td>SSL Security </td>
        		<td>Upgrade Today!</td>
        	</tr>
        </thead>
        <tbody>
        	<?php	foreach($planList as $plan):?>
			<tr <?=($plan->planid == $companyPlanInfo->planid) ? "class='current-plan'" : ''?> >
		       <td class="align-left">
		       		<?=$plan->name?>
		       		<?=($plan->price>0) ? "$plan->price$/month" : '' ?>
		       </td>
		       <td class="align-left">
					<?=($plan->monthlyfeedback > 0) ? "$plan->monthlyfeedback per month" : "Unlimited" ?>							       
		       </td>
		       <td>
					<?=($plan->adminnum > 0) ? "$plan->adminnum" : "unlimited" ?>
		       </td>
		       <td>
		       		<?=($plan->hasmoderation > 0) ? "<img src='/img/ico-green-check.png' />": "" ?>						       
		       </td>
		       <td>
					<?=($plan->hasssl > 0) ? "<img src='/img/ico-green-check.png' />": "" ?>							       
		       </td>
		       <td>
		       	<?php
		       	$companyId = $companyInfo->companyid;
					if($plan->planid == $companyPlanInfo->planid){
						echo "<strong>Current plan</strong>";										
					}
					elseif($plan->price > $companyPlanInfo->price){
						echo HTML::link("settings/upgrade/?planId=$plan->planid&action=confirm",'Upgrade',array('class'=>'gray-btn')); 										
					}
					else{
						echo HTML::link("settings/upgrade/?planId=$plan->planid&action=downgrade",'Downgrade',array('class'=>'gray-btn'));
					}
		       	?>
		       </td>
		    </tr>         	
        	<?php endforeach; ?>
        </tbody>
        <tfoot>
        	<tr>
        		<td colspan="6">
        			You can also downgrade to a lower plan if you don't need as many features.
				</td>
			</tr>
        </tfoot>
    </table>
    <p></p>
</div>
<?php /*List of Plans End*/ ?>

<div class="block noborder" style="background:#f4f4f4">
	<div class="grids">
        <div class="g2of3">
        	<div class="white-box">
            	<h3>Invoices</h3>
                <p>Each time you are billed, an invoice is emailed to <strong><?=$companyInfo->replyto?></strong>. The invoice includes a custom 'Bill to' field where you can provide your company's address and any other billing notes. You can change this at any time.</p>
                <?php /*Billing History Start*/ ?>
                <?php if(isset($companyBillingInfo->billingHistory) && sizeof($companyBillingInfo->billingHistory)>0){?>
                    <h3>Invoices & Charges Sent to Date</h3>
                    <ul>
                    <?php foreach($companyBillingInfo->billingHistory as $bill): ?>
                       <li>
                    	  <a href="#">
                    		<?=Str::title($bill->plan_id)?>, $<?=$bill->amount?> on <?=date("M d, Y",strtotime($bill->date->date))?>
                    	  </a>
                       </li>
                    <?php endforeach; ?>
                    </ul>
				<?php }?>                  
                <?php /*Billing History End*/ ?>
                <?php 
                /* not implemented
                <?php if(isset($companyInfo->account_user) && sizeof($companyInfo->account_user) > 1 ): ?>
                <h3>Change Account Owner</h3>
                <p>The account owner is the only person that can access this account page, upgrade, downgrade, change billing information, access invoices, and cancel the account. The account owner also has permanent access to all projects. Once you make this change you'll no longer be the account owner.</p>
                <p>
                	<select name="account_owner" id="account_owner" class="regular-select">
								<?php foreach($companyInfo->account_user as $user): ?>                            		
                		<?php if($user->account_owner!=1){ echo "<option value='$user->userid'>$user->fullname</option>";}?>
                		<?php endforeach; ?>
                		</select>
                	<input type="button" value="Make this person the account owner" class="small-btn" /></p>
						<?php endif; ?>                            
                <h3>Need to Cancel Your Account?</h3>
                <p>We'll be sorry to see you go. Once your account is cancelled, all your feedback information will be immediately and permanently deleted. If you have a paying account you won't be charged again after your official cancellation date. Please familiarize yourself with our refund policy.</p>
                
                <p><a href="cancel_account" class="gray-btn">Please cancel my account</a></p>
                */
                ?>
            </div>
        </div>
        <div class="g1of3">
        	<div class="gray-box">
            	<h3>What happens if we upgrade, downgrade, or cancel in the middle of a billing cycle?</h3>
                <p>If you upgrade or downgrade you'll be charged the new rate for your new plan starting on your next billing cycle. If you cancel, your account will be cancelled immediately and you won't be charged again.</p>
                <h3>We Accept <img src="/img/creditcards.png" style="vertical-align:middle;padding-left:10px;"  width="80"/></h3>
                <p>We accept Visa, Mastercard, and American Express. We don't accept PayPal, checks, or POs, sorry.</p>
                <p></p>
                <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
            </div>
        </div>
    </div>
</div>
	<?php	/*Billing History End*/  ?>