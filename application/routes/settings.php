<?php

$category = new DBCategory;
$social_account = new Company\Repositories\DBCompanySocialAccount;
$redis = new redisent\Redis;
$redis_oauth_key = Config::get('application.subdomain').':twitter:oauth';
$redis_twitter_key = Config::get('application.subdomain').':twitter:feedback';

$category 			= new DBCategory;
$company 			= new Company\Repositories\DBCompany;
$hosted_settings 	= new Hosted\Repositories\DBHostedSettings;
$fullpage           = new Hosted\Services\Fullpage;

return array (

    'GET /settings' => Array('name' => 'settings', 'before' => 's36_auth', 'do' => function() use ($category, $company, $hosted_settings) {
        $user 				= S36Auth::user();
        $company_name 		= Config::get('application.subdomain');
        $company_info 		= $company->get_company_info($company_name);

        //get hosted settings
        $hosted_settings->set_hosted_settings(Array('company_id' => $company_info->companyid));

        return View::of_layout()->partial('contents', 'settings/settings_index_view', Array(
            'user'              => $user
          , 'category'          => $category->pull_site_categories()
          , 'hosted_settings'   => $hosted_settings->hosted_settings()
        ));
    }),

    'GET /settings/feedback' => Array('name' => 'settings', 'before' => 's36_auth', 'do' => function() use ($category, $company, $hosted_settings, $fullpage) {
        $user               = S36Auth::user();
        $company_name       = Config::get('application.subdomain');
        $company_info       = $company->get_company_info($company_name);

        //get hosted settings
        $hosted_settings->set_hosted_settings(Array('company_id' => $company_info->companyid));

        return View::of_layout()->partial('contents', 'settings/settings_feedback_view', Array(
            'user'              => $user
          , 'category'          => $category->pull_site_categories()
          , 'hosted_settings'   => $hosted_settings->hosted_settings()
          , 'fullpage_css'     => $fullpage->get_fullpage_css($company_info->companyid)
        ));
    }),

    'GET /settings/background' => Array('name' => 'background_settings', 'before' => 's36_auth', 'do' => function() use($company, $hosted_settings, $fullpage){
        
        $company_name	= Config::get('application.subdomain');
        $company_info 	= $company->get_company_info($company_name); 

        return View::of_layout()->partial('contents', 'settings/settings_background_view', Array(
            'display_patterns'  => $fullpage->get_fullpage_pattern()
            ,'panel'            =>$hosted_settings->get_panel_settings($company_info->companyid)
            ,'fullpage_css'     => $fullpage->get_fullpage_css($company_info->companyid)
        ));
        
    }),
    'GET /settings/layout' => Array('name' => 'layout_settings', 'before' => 's36_auth', 'do' =>function() use($company, $hosted_settings, $fullpage){

        $company_name   = Config::get('application.subdomain');
        $company_info   = $company->get_company_info($company_name); 

        return View::of_layout()->partial('contents', 'settings/settings_layout_view', Array(
             'panel'            =>$hosted_settings->get_panel_settings($company_info->companyid)
            ,'fullpage_css'     => $fullpage->get_fullpage_css($company_info->companyid)
        ));
        
    }),
     'GET /settings/others' => Array('name' => 'other_settings', 'before' => 's36_auth', 'do' =>function() use($company, $hosted_settings, $fullpage){

        $user           = S36Auth::user();
        $company_name   = Config::get('application.subdomain');
        $company_info   = $company->get_company_info($company_name); 

        return View::of_layout()->partial('contents', 'settings/settings_other_view', Array(
             'user'             =>$user
            ,'panel'            =>$hosted_settings->get_panel_settings($company_info->companyid)
            ,'company_info'     =>$company_info
            ,'fullpage_css'     => $fullpage->get_fullpage_css($company_info->companyid)
        ));
        
    }),
    
    'GET /settings/display' => Array('before' => 's36_auth', 'do' => function() use($hosted_settings, $fullpage, $company){
        
        $company_name	= Config::get('application.subdomain');
        $company_info 	= $company->get_company_info($company_name); 

        return View::of_layout()->partial('contents', 'settings/settings_display', 
            array(
                'settings'      => $hosted_settings->get_panel_settings( Config::get('application.subdomain') ),
                'fullpage_css'  => $fullpage->get_fullpage_css($company_info->companyid)
            )
        );
        
    }),

    'POST /settings/rename_ctgy' => function() use($category) { 
        $ctgy_nm = Input::get('ctgy_nm');
        $ctgy_id = Input::get('ctgy_id');
        return $category->update_category_name($ctgy_nm, $ctgy_id);

    },

    'POST /settings/delete_ctgy' => function() use($category) { 
        $category->delete_category_name(Input::get('ctgy_id'));
    },

    'POST /settings/write_ctgy' => function() use($category) {  
        $category->write_category_name(Input::get('ctgy_nm'));
    },

    'GET /settings/category_count' => function() use($category) {
        Helpers::dump($category->_category_count());
    },
    'POST /settings/save_company_settings' => function() {
        $company = new Company\Repositories\DBCompany;
        $hosted_settings = new Hosted\Repositories\DBHostedSettings;
        $data = (object)Input::get();
        $result = $company->update_companyinfo($data);
        return json_encode(array('success'=>($result==1) ? true : false));
    },
    'POST /settings/save_feedback_settings' => function() {
        $company = new Company\Repositories\DBCompany;
        $hosted_settings = new Hosted\Repositories\DBHostedSettings;
        $post = (object)Input::get();

        //autoposting start
        if(isset($post->autopost_enable) && $post->autopost_enable){
        	$hosted_settings->update_autoposting(array(
        		 'companyid' 		=> $post->companyid
        		,'autopost_enable' 	=> 1
        		,'autopost_rating' 	=> $post->autopost_rating
        	));
        }else{
        	$hosted_settings->update_autoposting(array(
        		 'companyid' 		=> $post->companyid
        		,'autopost_enable' 	=> 0
        		,'autopost_rating' 	=> 0
        	));
        }
        unset($post->autopost_enable);
        unset($post->autopost_rating);
        //autoposting end

        $company->update_company_emails($post);
 
        //lets help the user along!
        if($forward_to = Input::get('forward_to')) {
            return Redirect::to($forward_to);
        } else { 
            return Redirect::to('settings/feedback');
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
    
    'GET /settings/social'  => Array('name' => 'settings', 'before' => 's36_auth', 'do' => function() use ($social_account) {  

        $user = S36Auth::user();
        $twitter_account = $social_account->fetch_social_account('twitter');
         
        return View::of_layout()->partial('contents', 'settings/settings_social_view', Array( 
            'user' => $user, 'twitter_account' => $twitter_account
        ));
    }),

    'GET /settings/connect/(:any)' => Array('name' => 'settings', 'before' => 's36_auth', 'do' => function($social) use ($redis, $redis_oauth_key, $social_account) {

        $user = S36Auth::user(); 
        //todo: FUCK REFACTOR THIS! 
        if($social == 'twitter') { 
            $twitter_key    = Config::get('application.dev_twitter_key');
            $twitter_secret = Config::get('application.dev_twitter_secret');
            $twitoauth = new TwitterOAuth($twitter_key, $twitter_secret);

            //if denied fly the user back to the social page 
            if(Input::get('denied')) {
                $redis->del($redis_oauth_key);
                return Redirect::to('settings/social');           
            }

            if($redis->hgetall($redis_oauth_key) == false) {   
                //redirects back to /settings/connect/twitter
                $callback_url = Config::get('application.url').'/settings/connect/twitter';
                $token = $twitoauth->getRequestToken($callback_url);

                $redis->hset($redis_oauth_key, 'oauth_token', $token['oauth_token']);
                $redis->hset($redis_oauth_key, 'oauth_token_secret', $token['oauth_token_secret']);

                $login_url = $twitoauth->getAuthorizeURL($token['oauth_token'], $sign_in_with_twitter=False);     
                header('Location:'.$login_url);
                exit;
            } else {

                $twitoauth = new TwitterOAuth($twitter_key, $twitter_secret, 
                                              $redis->hget($redis_oauth_key, 'oauth_token'), $redis->hget($redis_oauth_key, 'oauth_token_secret'));

               
                $token_credentials = $twitoauth->getAccessToken($_REQUEST['oauth_verifier']);
                $account = $social_account->fetch_social_account('twitter');

                //If social account does not exist create one
                if(!$account) { 
                   
                    $twitter_account_data = Array( 
                        'accountName' => $token_credentials['screen_name']
                      , 'oauthToken' => $token_credentials['oauth_token']
                      , 'oauthTokenSecret' => $token_credentials['oauth_token_secret']
                    );

                    $data = Array(
                        'companyId' => $user->companyid
                      , 'socialAccountOrigin' => 'twitter'
                      , 'socialAccountValue' => Helpers::wrap($twitter_account_data)
                    );

                    $social_account->save_social_account($data);
                } 

                $redis->del($redis_oauth_key);
            }                
        }

        return Redirect::to('settings/social');           
    }),

    'GET /settings/disconnect/(:any)' => Array('name' => 'settings', 'before' => 's36_auth', 'do' => function($social) use ($redis, $redis_oauth_key, $redis_twitter_key, $social_account) {
        $user = S36Auth::user(); 
        if($social == 'twitter') { 
            $redis->del($redis_oauth_key);
            $redis->del($redis_twitter_key);

            $dbsocial = new Feedback\Repositories\DBSocialFeedback;
            $dbsocial->delete_all('tw');
            $social_account->delete_social_account();
        }
        return Redirect::to('settings/social');           
    }),

    'POST /settings/save_companysettings' => function() {
        $company_settings = new Company\Services\CompanySettings( Input::get('companyid') );
        //$company_settings->upload_companylogo($_FILES);  // no longer need this. we used jquery fileupload.
        
        if(!$company_settings->get_errors()) {
            $company_settings->save_companysettings();
            return Redirect::to('settings/company');
        } else {
            return Redirect::to('settings/company?error_msg="'.$company_settings->get_errors().'"');
        } 
    },

    'GET /settings/upgrade' => Array('name' => 'settings', 'before' => 's36_auth', 'do' => function() {

			$plan 				= new Plan\Repositories\DBPlan;
			$DBCountry 			= new DBCountry;
			$accountService 	= new Account\Services\AccountService;
			$planId 				= Input::get('planId');
			$action				= Input::get('action');
		    	  switch($action){
						case 'confirm' :
								if($accountService->braintree_exist()){
										return View::of_layout()->partial('contents', 'settings/settings_upgrade_account_view',
							        			array(
												'newPlanInfo' 		=> $plan->get_planInfo($planId),
												'accountInfo'		=> $accountService->get_accountInfo()
												));
								}else{
										return Redirect::to("/settings/upgrade/?planId=$planId&action=upgrade");
								}
							break;
						case 'upgrade':
										return View::of_layout()->partial('contents', 'settings/settings_add_braintree',
												array(
													'accountInfo' 			=> $accountService->get_accountInfo(),
													'planInfo'				=>	$plan->get_planInfo($planId),
													'countries'				=>	$DBCountry->get_country_list()
												));
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
    /*handle ajax request from upgrade_plan view with braintree account creation*/
    'POST /settings/add_billing_info' => Array('needs' => 'S36ValueObjects', 'do' => function() {
    		$billing_info = Input::all();
			$rules = array(
				'plan_selected'			=>		'required',
				'billing_first_name'	=>		'required',
				'billing_last_name'		=>		'required',
				'billing_address'		=>		'required',
				'billing_city'			=>		'required',
				'billing_country'		=>		'required',
				'billing_zip'			=>		'required|alpha_num|min:3',
				'billing_card_number'	=>		'required|numeric|min:16',
				'billing_card_cvv'		=>		'required|numeric'
			);
			
			$messages = array(
			 'numeric' 		=> 'Must be a number.',
			 'min'			=> 'Must be at least :min digits.'
			);
			
				$accountService 	= 	new Account\Services\AccountService;
				$account_info		=	$accountService->get_accountInfo();
				$obj = new stdclass;
				$obj->company_info	=	$account_info->companyInfo;
				$obj->billing_info	=	\Helpers::arrayToObject($billing_info);
				$result = $accountService->create_braintree_account($obj);			
			
			$validator = Validator::make($billing_info, $rules,$messages);
			/*validation fails*/
			if(!$validator->valid() || $result['success']==false || ($billing_info['billing_expire_month'] < date('m') && $billing_info['billing_expire_year'] <= date('Y')) ) {
			
				/*custom error messages*/
				if(isset($validator->errors->messages['billing_first_name'])){
					$validator->errors->messages['billing_first_name'] = 'The first name field is required.';
				}
				if(isset($validator->errors->messages['billing_first_name'])){
					$validator->errors->messages['billing_last_name'] = 'The last name field is required.';
				}
				if(empty($billing_info['plan_selected'])){ 
						$validator->errors->messages['plan_selected'][0] = 'Please select your subscription plan.';
				}
				if(!empty($billing_info['billing_expire_month']) && !empty($billing_info['billing_expire_year'])){
				if($billing_info['billing_expire_month'] < date('m') && $billing_info['billing_expire_year'] <= date('Y')){
						$validator->errors->messages['billing_expire_date'][]='Expiration date is invalid.';
				}}
				
				if($result['success']==false){
					$error = $result['message'];
					if(isset($error['number']))			{$validator->errors->messages['billing_card']			= $error['number'];}
					if(isset($error['cvv']))			{$validator->errors->messages['billing_card_cvv'] 		= $error['cvv'];}
					if(isset($error['expirationMonth'])){$validator->errors->messages['billing_expire_date'][]	= $error['expirationMonth'];}
					if(isset($error['expirationYear']))	{$validator->errors->messages['billing_expire_date'][]	= $error['expirationYear'];}
					if(isset($error['postalCode']))		{$validator->errors->messages['billing_zip']			= 'Correct postal code is required.';}
				}
				/*return the results*/	
				return json_encode(array(
							'error'=>true,
							'messages'=>$validator->errors->messages
							));
			}
			/*successful account creation*/
			if($result['success']==true){
					return json_encode(array(
							'error'=>false,
							));			
			}
			
			
    }),
    		
    'GET /settings/change_card' => Array('name' => 'settings', 'before' => 's36_auth', 'do' => function() {
    		$accountService = new Account\Services\AccountService;
    		if(!$accountService->braintree_exist()){ Redirect::to('settings/upgrade');}
			if($accountService->braintree_exist()){
			return View::of_layout()->partial('contents', 'settings/settings_change_card_view',
					array(
						'accountInfo'	=> $accountService->get_accountInfo()
					) 			
			);
			}
			else{
					return Redirect::to('settings/upgrade');
			}
    }),
    /*handle ajax request from settings/change_card view*/
	'POST /settings/change_card' => Array('needs' => 'S36ValueObjects', 'do' => function() {
		$card_data = Input::all();
		$accountService = new Account\Services\AccountService;
		$result = $accountService->update_credit_card($card_data);
		 	/*validation fails*/
			if($result['success']==false || ($card_data['billing_expire_month'] < date('m') && $card_data['billing_expire_year'] <= date('Y'))) {
				if($result['success']==false){
					$error = $result['message'];
					if(isset($error['number']))			{$validator->errors->messages['billing_card_number']	= $error['number'];}
					if(isset($error['cvv']))			{$validator->errors->messages['billing_card_cvv'] 		= $error['cvv'];}
					if(isset($error['postalCode']))		{$validator->errors->messages['billing_zip']			= $error['postalCode'];}
					if(isset($error['expirationMonth'])){$validator->errors->messages['billing_expire_date'][]	= $error['expirationMonth'];}
					if(isset($error['expirationYear']))	{$validator->errors->messages['billing_expire_date'][]	= $error['expirationYear'];}
				}
				if(!empty($card_data['billing_expire_month']) && !empty($card_data['billing_expire_year'])){
				if($card_data['billing_expire_month'] < date('m') && $card_data['billing_expire_year'] <= date('Y')) {
						$validator->errors->messages['billing_expire_date'][]='Expiration date is invalid.';
				}}
				return json_encode(array(
									'error'		=>true,
									'messages'	=>$validator->errors->messages
									));
			}
			/*validation are all good*/
			else{
				/*on success*/
				return json_encode(array(
										'error'=>false,
										'messages'=>'Your credit card has been updated.'));
			}		     
    }),
 
    'GET /settings/change_billing_info' => Array('name' => 'settings', 'before' => 's36_auth', 'do' => function() {
			$accountService = new Account\Services\AccountService;		
    		$DBCountry = new DBCountry;
    		if(!$accountService->braintree_exist()){ Redirect::to('settings/upgrade');}
			return View::of_layout()->partial('contents', 'settings/settings_change_billing_info',
						array(
							'accountInfo'			=> $accountService->get_accountInfo(),
							'companyBillingInfo'	=>	$accountService->get_accountInfo()->companyBillingInfo,
							'countries'				=> $DBCountry->get_country_list()
						));
					
    }),
    /*handle ajax request for settings/change_billing_info*/
	'POST /settings/change_billing_info' => Array('name' => 'settings', 'before' => 's36_auth', 'do' => function() {
			$billing_info = Input::all();
			$accountService = new Account\Services\AccountService;
			$result = $accountService->update_billing_info($billing_info);
			$rules = array(
				'billing_first_name'	=>		'required',
				'billing_last_name'		=>		'required',
				'billing_address'		=>		'required',
				'billing_city'			=>		'required',
				'billing_country'		=>		'required',
				'billing_zip'			=>		'required|alpha_num|min:3'
			);
			$validator = Validator::make($billing_info, $rules);

			if($result['success']==false || !$validator->valid() || ($billing_info['billing_expire_month'] < date('m') && $billing_info['billing_expire_year'] <= date('Y'))){
				
				if(!$validator->valid()){
					if(isset($validator->errors->messages['billing_zip']))			{ $validator->errors->messages['billing_zip']='Correct postal code is required.';}
					if(isset($validator->errors->messages['billing_first_name']))	{ $validator->errors->messages['billing_first_name'] = 'The first name field is required.';}
					if(isset($validator->errors->messages['billing_last_name']))	{ $validator->errors->messages['billing_last_name'] = 'The last name field is required.';}
					if(isset($validator->errors->messages['billing_address']))		{ $validator->errors->messages['billing_address'] = 'The address field is required.';}
					if(isset($validator->errors->messages['billing_city']))			{ $validator->errors->messages['billing_city'] = 'The city field is required.';}
					if(isset($validator->errors->messages['billing_country']))		{ $validator->errors->messages['billing_country'] = 'The country field is required.';}

				}
				if($result['success']==false){
					$error = $result['message'];
					if(isset($error['number']))			{$validator->errors->messages['billing_card_number']	= $error['number'];}
					if(isset($error['cvv']))			{$validator->errors->messages['billing_card_cvv'] 		= $error['cvv'];}
					if(isset($error['postalCode']))		{$validator->errors->messages['billing_zip']			= $error['postalCode'];}
					if(isset($error['expirationMonth'])){$validator->errors->messages['billing_expire_date'][]	= $error['expirationMonth'];}
					if(isset($error['expirationYear']))	{$validator->errors->messages['billing_expire_date'][]	= $error['expirationYear'];}
				}

				if(!empty($billing_info['billing_expire_month']) && !empty($billing_info['billing_expire_year'])){
				if($billing_info['billing_expire_month'] < date('m') && $billing_info['billing_expire_year'] <= date('Y')) {
						$validator->errors->messages['billing_expire_date'][]='Expiration date is invalid';
				}}

				return json_encode(array(
										'error'		=>true,
										'messages'	=>$validator->errors->messages
										));
			}else{
				return json_encode(array(
										'error'		=>false,
										'messages'	=>$result
										));
			}
    }),    
    
    'GET /settings/cancel_account' => Array('name' => 'settings', 'before' => 's36_auth', 'do' => function() {
        return View::of_layout()->partial('contents', 'settings/settings_index_view');
    }),
);
