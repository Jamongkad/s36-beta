<?php 

namespace Account\Services;

use S36DataObject\S36DataObject, PDO, StdClass, Helpers, DB, S36Auth;
\Package::load('braintree');

class AccountService{

var $user;
var $DBCompany;
var $DBPlan;
var $S36Braintree;

function __construct(){
		// initialize associate models
		$this->user 			= S36Auth::user();		
		$this->DBCompany 		= new \Company\Repositories\DBCompany;
		$this->DBPlan 			= new \Plan\Repositories\DBPlan;
		$this->S36Braintree 	= new \S36Braintree($this->user->bt_customer_id);
		$this->DBCompany->set_companyId($this->user->companyid);
}


function get_accountInfo(){

		$company_info 						= $this->DBCompany->get_company_info();
		$company_info->account_user 	= $this->DBCompany->get_account_user();
		$company_plan_info 				= $this->DBPlan->get_planInfo($company_info->planid);
		$result = array(
			'companyInfo'			=> $company_info,
			'companyPlanInfo'		=>	$company_plan_info,
			'companyBillingInfo'	=>	array(
											'nextBill'			=>	$this->S36Braintree->get_next_billing_info(),
											'billingHistory'	=>	$this->S36Braintree->get_billing_history()
											)
		);
		return \Helpers::arrayToObject($result);
}

function update_plan($planId){
		$newPlan = $this->DBPlan->get_PlanInfo($planId);
		if( ($this->DBCompany->update_plan($planId)) && $this->S36Braintree->update_subscription($newPlan->name) )
		{
				return true;
		}

	}


}


