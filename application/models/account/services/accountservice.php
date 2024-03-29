<?php 

namespace Account\Services;

use S36DataObject\S36DataObject, PDO, StdClass, Helpers, DB, S36Auth;
use \Company\Repositories\DBCompany, \Plan\Repositories\DBPlan;
\Package::load('braintree');

class AccountService{

private	$user;
private	$DBCompany;
private	$DBPlan;
private	$S36Braintree;

public function __construct(){
		// initialize associate models
		$this->user 			= S36Auth::user();		
		$this->DBCompany 		= new DBCompany;
		$this->DBPlan 			= new DBPlan;
		$this->S36Braintree 	= new \S36Braintree($this->user->bt_customer_id);
}

public function braintree_exist(){
		return ($this->S36Braintree->exists()==1) ? true : false;
}

public function get_accountInfo(){
		$obj = new stdclass;
		$obj->companyInfo 					=	$this->DBCompany->get_company_info();
		$obj->companyInfo->account_owner	=	$this->DBCompany->get_account_owner();
		$obj->companyPlanInfo				= 	$this->DBPlan->get_planInfo($obj->companyInfo->planid);
		if($this->braintree_exist()){
			$obj->companyCreditCardInfo					=	Helpers::arrayToObject($this->S36Braintree->get_credit_card_info());

			$obj->companyBillingInfo = new StdClass; 
			$obj->companyBillingInfo					=	Helpers::ArrayToObject($this->S36Braintree->get_billing_info());
			$obj->companyBillingInfo->nextBill			=	Helpers::arrayToObject($this->S36Braintree->get_next_billing_info());	
			$obj->companyBillingInfo->billingHistory	=	Helpers::arrayToObject($this->S36Braintree->get_billing_history());	
		} 
		return $obj;
}

public function create_braintree_account($input){
	$result = $this->S36Braintree->create_account2($input);
	if(isset($result['success']) && $result['success']==true){
			$this->DBCompany->update_bt_customer_id($result['customer_id']);
			$newPlan = $this->DBPlan->get_PlanInfo($input->billing_info->plan_selected);
			$this->DBCompany->update_plan($newPlan->planid);
	}
	return $result;
}

public function update_plan($planId){
		$newPlan = $this->DBPlan->get_PlanInfo($planId);
		if($this->DBCompany->update_plan($newPlan->planid) && $this->S36Braintree->update_subscription('premium'));
		{ 
			return true; 
		}
	}

public function update_billing_info($input){
	return $this->S36Braintree->update_billing_info($input);
}

public function update_credit_card($data){
	$card_number 	= 	$data['billing_card_number'];
	$card_cvv 		= 	$data['billing_card_cvv'];
	$expire_month	=	$data['billing_expire_month'];
	$expire_year	=	$data['billing_expire_year'];
	return $this->S36Braintree->update_credit_card($card_number,$card_cvv,$expire_month,$expire_year);
}

public function update_billing_address($data){
	return $this->S36Braintree->update_billing_address($data);
}
}
