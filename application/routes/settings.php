<?php

$category = new DBCategory;

return array (

    'GET /settings' => Array('name' => 'settings', 'before' => 's36_auth', 'do' => function() use ($category) {
        $user = S36Auth::user();
        return View::of_layout()->partial('contents', 'settings/settings_index_view', Array(
            'user' => $user
          , 'category' => $category->pull_site_categories()
        ));
    }),

    'POST /settings/rename_ctgy/([0-9]+)' => function($id) use($category) { 
        $ctgy_nm = Input::get('ctgy_nm');
        return $category->update_category_name($ctgy_nm, $id);
    },

    'GET /settings/delete_ctgy/([0-9]+)' => function($id) use($category) { 
        return $category->delete_category_name($id);
    },

    'POST /settings/write_ctgy' => function() use($category) {  
        $ctgy_nm = Input::get('ctgy_nm');
        $companyId = Input::get('companyId');
        return $category->write_category_name($ctgy_nm, $companyId);
    },

    'POST /settings/savesettings' => function() {
        $company = new Company\Repositories\DBCompany;

        $post = (object)Input::get();
        $company->update_company_emails($post);
 
        //lets help the user along!
        if($forward_to = Input::get('forward_to')) {
            return Redirect::to($forward_to);
        } else { 
            return Redirect::to('settings');
        }         
    },

    'GET /settings/company'  => Array('name' => 'settings', 'before' => 's36_auth', 'do' => function(){  
        $user = S36Auth::user();
        $company = new Company\Repositories\DBCompany;
        $company_info = $company->get_company_info($user->companyid);

        $url = Config::get('application.url');

        return View::of_layout()->partial('contents', 'settings/settings_company_view', Array( 
            'user' => $user, 'company' => $company_info, 'error' => Input::get('error_msg'), 'url' => $url
        ));
    }),

    'POST /settings/save_companysettings' => function() {
        $company_settings = new Company\Services\CompanySettings;
        $company_settings->upload_companylogo($_FILES);

        if(!$company_settings->get_errors()) {
            $company_settings->save_companysettings();
            return Redirect::to('settings/company');           
        } else {
            return Redirect::to('settings/company?error_msg="'.$company_settings->get_errors().'"');
        } 

    },
    
    'GET /settings/upgrade' => Array('name' => 'settings', 'before' => 's36_auth', 'do' => function() {

		  $plan = new Plan\Repositories\DBPlan;
		  $accountService = new Account\Services\AccountService;
		  $planId 		= Input::get('planId');
		  $action		= Input::get('action');
    	  switch($action){
				case 'confirm' :
						return View::of_layout()->partial('contents', 'settings/settings_upgrade_account_view',
			        			array(
								'newPlanInfo' 		=> $plan->get_planInfo($planId),
								'accountInfo'		=> $accountService->get_accountInfo()
								)  
			        );
					break;
				case 'success' :
							$result = $accountService->update_plan($planId);			
							if($result){
								return Redirect::to('/settings/upgrade/?action=completed');			
							}
					break;
				case 'completed' :
						return View::of_layout()->partial('contents', 'settings/settings_upgrade_view',
							array(
									'result' 		=> 'completed',
									'newPlanInfo'	=> $plan->get_planInfo($planId),
									'planList' 		=> $plan->get_planInfo(),
									'accountInfo'	=> $accountService->get_accountInfo()
								)     
				      	);
					 break;		
				case 'downgrade' :
						return View::of_layout()->partial('contents', 'settings/settings_downgrade_account_view',
			        			array(
								'newPlanInfo' 		=> $plan->get_planInfo($planId),
								'accountInfo'		=> $accountService->get_accountInfo()
								)  
			        );
					break;
				default:
						return View::of_layout()->partial('contents', 'settings/settings_upgrade_view',
							array(
								'planList' 		=> $plan->get_planInfo(),
								'accountInfo'	=> $accountService->get_accountInfo()
							)     
			      	);
					break;			
				
			}
    }  
    ),
    
    		
    'GET /settings/change_card' => Array('name' => 'settings', 'before' => 's36_auth', 'do' => function() {
    		$accountService = new Account\Services\AccountService;
			return View::of_layout()->partial('contents', 'settings/settings_change_card_view',
					array(
						'accountInfo'	=> $accountService->get_accountInfo()
					) 			
			);		     
    }),
    
	'POST /settings/change_card' => Array('needs' => 'S36ValueObjects', 'do' => function() {
		$card_data = Input::all();
		$rules = array(
				'card_number'	=>		'required|numeric|min:16',
				'card_cvv'		=>		'required|numeric',
				'expire_month'	=>		'required',
				'expire_year'	=>		'required',
				'billing_zip'	=>		'required|alpha_num|min:3'
		);
		 	$validator = Validator::make($card_data, $rules);
		 	/*validation fails*/
			if((!$validator->valid()) || (($card_data['expire_month'] < date('m')) &&($card_data['expire_year'] == date('Y'))  )) {
				if((!empty($card_data['expire_month']) && !empty($card_data['expire_year'])) &&
					($card_data['expire_month'] < date('m') && $card_data['expire_year'] <= date('Y')))				
				{
					$validator->errors->messages['expire_month'][]='The expiration date must be valid.';
				}
				return json_encode(array(
										'error'=>true,
										'messages'=>$validator->errors->messages
										));
			}
			/*validation are all good*/
			else{
				$accountService = new Account\Services\AccountService;
				$result = $accountService->update_credit_card($card_data);
				/*catch unexpected errors during update*/
				if(!$result['success']){
						return json_encode(array(
										'error'=>true,
										'messages'=>$result['message']
										));
				}
				/*on success*/
				return json_encode(array(
										'error'=>false,
										'messages'=>'Your credit card has been updated.'));
			}		     
    }),

    'GET /settings/cancel_account' => Array('name' => 'settings', 'before' => 's36_auth', 'do' => function() {
        return View::of_layout()->partial('contents', 'settings/settings_cancel_account_view');
    }),
);

