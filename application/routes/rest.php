<?php
header('Access-Control-Allow-Origin: *');
$feedback = new Feedback\Repositories\DBFeedback;
$category = new DBCategory;
$dbwidget = new Widget\Repositories\DBWidget;
$badwords = new DBBadWords;

return array(

/****************
*	ACCOUNT
*****************/

	'POST /rest/account/login'=>array('name'=>'login','do'=>function(){
        $input = Input::all();
        $auth = new S36Auth;
        $company_name = Config::get('application.subdomain');
        $auth->login($input['username'],$input['password'], Array('company' => $company_name)); 
        if($auth->check()) {
            $token  = $auth->user()->encryptstring;
            $result = array('user' => $auth->user(),'token' =>$token);
            echo return_json(array('data'=>$result));
        } else {
            echo return_json(array('success'=>false,'message'=>'Invalid login credentials'));
        } 
	}),

	'GET /rest/account/logout' => array('name'=>'logout','do'=>function(){
        $auth = new S36Auth;
        $auth->logout();
        echo return_json(array('success'=>true));
    }),

/**************
*	FEEDBACK
***************/
    'GET /rest/feedback'=>array('name'=>'feedback','before' => 's36_auth','do'=>function(){
       echo return_json(array('data'=>getFeedback()));
    }),

	'GET /rest/feedback/inbox'=>array('name'=>'inbox','before' => 's36_auth','do'=>function(){
        echo return_json(array('data'=>getFeedback()));
	}),

    'GET /rest/feedback/published'=>array('name'=>'published_feedback','before' => 's36_auth','do'=>function(){
        echo return_json(array('data'=>getFeedback(array(
                                            'filter'   =>   'published'
        ))));
    }),

    'GET /rest/feedback/filed'=>array('name'=>'filed_feedback','before' => 's36_auth','do'=>function(){
        echo return_json(array('data'=>getFeedback(array(
                                            'filter'   =>   'filed'
        ))));
    }),

    'GET /rest/feedback/featured'=>array('name'=>'featured_feedback','before' => 's36_auth','do'=>function(){
       echo return_json(array('data'=>getFeedback(array(
                                            'is_featured'    =>   1
        ))));
    }),

    'POST /rest/feedback'=>array('name'=>'add_feedback','before' => 's36_auth','do'=>function(){
        $data   = Input::all();
        $data['company_id'] = S36Auth::user()->companyid;
        $rules  = Array(
            'first_name'    => 'required'
          , 'email'         => 'required|email'
          , 'feedback'      => 'required'
          , 'city'          => 'required'
          , 'country'       => 'required'
          , 'rating'        => 'required'
          , 'website'       => 'required'
          , 'profile_link'  => 'required'
        );
        $validator = Validator::make($data,$rules);
        if(!$validator->valid()) {
            echo return_json(array('success'=>false,'message'=>$validator->errors->messages));
        } else {
            $addfeedback = new Feedback\Services\SubmissionService($data);
            echo return_json(array('data'=>$addfeedback->perform()));
        }
    }),

    'GET /rest/feedback/(:num)'=>array('name'=>'feedback','before' => 's36_auth','do'=>function($id){
        $feedback = new Feedback\Repositories\DBFeedback;
        echo return_json(array('data'=>$feedback->pull_feedback_by_id($id)));
    }),


    'POST /rest/feedback/(:num)'=>array('name'=>'modify_feedback','before' => 's36_auth','do'=>function($id)use ($feedback, $badwords){
        $feedbackService = new Feedback\Services\FeedbackService($feedback,$badwords);
        echo return_json(array('data'=>$feedbackService->update_feedback($id,Input::all()))); 
    }),
    
    'POST /rest/feedback/fastforward'=>array('name'=>'fastforward_feedback','before' => 's36_auth','do'=>function()use ($feedback, $badwords){
        $data = Input::all();
        $rules = Array(
            'site_id'    => 'required'
          , 'first_name' => 'required'
          , 'last_name'  => 'required'
          , 'email'      => 'required|email'
          , 'message'    => 'required'
          , 'widgetkey'  => 'required'
        );
         $validator = Validator::make($data, $rules);
        if(! $validator->valid() ) {
            echo return_json(array('success'=>false,'data'=>$validator->errors->messages));
        }
        else {      
            $request_data = new Email\Entities\RequestFeedbackData;
            $request_data->sendto = (object) Array(
                'first_name'    => $data['first_name']
              , 'last_name'     => $data['last_name']
              , 'email'         => $data['email']
            );
            $request_data->message      = $data['message'];
            $request_data->from         = S36Auth::user(); 
            $request_data->sites        = $data['site_id'];
            $request_data->widgetkey    = $data['widgetkey'];

            $emailservice = new Email\Services\EmailService($request_data);
            $emailservice->send_email();
            echo return_json(array('success'=>false,'data'=>$request_data));
        }
    }),


);

/*************
*	HELPERS
**************/

function return_json(array $result){
	return json_encode(array(
		'success'	=>	isset($result['success']) ? $result['success'] : true,
		'message'	=>	isset($result['message']) ? $result['message'] : null,
		'data'		=>	isset($result['data'])    ? $result['data']    : null
	));
}




function set_filters(array $input=null){
    $filters['site_id']     = (isset($input['site_id']))    ? $input['site_id']     : null;
    $filters['limit']       = (isset($input['limit']))      ? $input['limit']       : 10;
    $filters['filter']      = (isset($input['filter']))     ? $input['filter']      : 'all';
    $filters['choice']      = (isset($input['choice']))     ? $input['choice']      : 'all';
    $filters['date']        = (isset($input['date']))       ? $input['date']        : false;
    $filters['rating']      = (isset($input['rating']))     ? $input['rating']      : false;
    $filters['category']    = (isset($input['category']))   ? $input['category']    : false;
    $filters['priority']    = (isset($input['priority']))   ? $input['priority']    : false;
    $filters['status']      = (isset($input['status']))     ? $input['status']      : false;
    $filters['is_published']= (isset($input['is_published']))? 1 : 0;
    $filters['is_featured'] = (isset($input['is_featured'])) ? 1 : 0;
    $filters['company_id']  = S36Auth::user()->companyid;
    return $filters;
}

function getFeedback(array $filters=null){
    //set default filters
    $filters    = set_filters($filters);
    //$dbfeedback = new Feedback\Repositories\dbfeedback;
    //return $dbfeedback->pull_feedback_by_company($filters);
    
    $inbox    = new Feedback\Services\InboxService; 
    $redis    = new redisent\Redis;
    $category = new DBCategory;

    $inbox->set_filters($filters);
    $inbox->ignore_cache = True;
    $feedback = $inbox->present_feedback();

    $admin_check    = S36Auth::user();
    $user_id        = S36Auth::user()->userid;
    $company_id     = S36Auth::user()->companyid;
    $redis->hset("user:$user_id:$company_id", "feedid_checked", 1);
    return $feedback;    
}
