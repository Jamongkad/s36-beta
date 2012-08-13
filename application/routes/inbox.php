<?php

return array( 
    'GET /inbox/(:any?)/(:any?)' => Array('name' => 'inbox', 'before' => 's36_auth', 'do' => function(  $filter=False
                                                                                                      , $choice=False ) {  

        $inbox = new Feedback\Services\InboxService; 
        $redis = new redisent\Redis;
        $limit = 10;

        if(Input::get('limit')) $limit = (int)Input::get('limit');

        $filters = array(
              'limit'=> $limit
            , 'site_id'=> Input::get('site_id')
            , 'filter'=> $filter
            , 'choice'=> $choice
            , 'date'  => Input::get('date')
            , 'rating' => Input::get('rating')
            , 'category' => Input::get('category')
            , 'priority' => Input::get('priority') //low medium high
            , 'status' => Input::get('status') //new inprogress closed
            , 'company_id' => S36Auth::user()->companyid
        );

        $inbox->set_filters($filters);
        $inbox->ignore_cache = True;
        $feedback = $inbox->present_feedback();

        $admin_check = S36Auth::user();
        $user_id = S36Auth::user()->userid;
        $company_id = S36Auth::user()->companyid;
        $redis->hset("user:$user_id:$company_id", "feedid_checked", 1);
        
        //Resets UI code for clicky action function
        reset_inbox_ui($company_id, $redis);
        $category = new DBCategory;

        $view_data = Array(
              'feedback' => $feedback->result
            , 'pagination' => $feedback->pagination
            , 'admin_check' => $admin_check
            , 'categories' => $category->pull_site_categories()
            , 'status' => DB::table('Status', 'master')->get()
            , 'inbox_state' => Helpers::inbox_state($filter)
            , 'priority_obj' => (object)Array(0 => 'low', 60 => 'medium', 100 => 'high') 
            , 'filter' => $filter
            , 'company_id' => $company_id
        );
        
        if(!Input::get('_pjax')) { 
            echo View::of_layout()->partial('contents', 'inbox/inbox_index_view', $view_data);
        } else {
            echo View::make('inbox/inbox_index_view', $view_data);
        } 
    }), 
);

function reset_inbox_ui($company_id, $redis) { 
    $company_key = "inbox:check-action:".$company_id;
    if($hkeys = $redis->hkeys($company_key)) {
        foreach($hkeys as $hseek) {  
            $redis->del($hseek);
        }
    } 
    $redis->del($company_key);
}
