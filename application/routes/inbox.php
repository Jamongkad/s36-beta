<?php

$dbfeedback = new Feedback\Repositories\DBFeedback;

return array( 
    'GET /inbox/(:any?)/(:any?)' => Array('name' => 'inbox', 'before' => 's36_auth', 'do' => function($filter=False, $choice=False) use ($dbfeedback) {  

        $inbox = new Feedback\Services\InboxService; 
        $redis = new redisent\Redis;
        $dbcompany_social = new Company\Repositories\DBCompanySocialAccount;

        $limit = 3;

        if(Input::get('limit')) $limit = (int)Input::get('limit');

        $filters = array(
              'limit'      => $limit
            , 'site_id'    => Input::get('site_id')
            , 'filter'     => $filter
            , 'choice'     => $choice
            , 'date'       => Input::get('date')
            , 'rating'     => Input::get('rating')
            , 'category'   => Input::get('category')
            , 'priority'   => Input::get('priority') //low medium high
            , 'status'     => Input::get('status') //new inprogress closed
            , 'company_id' => S36Auth::user()->companyid
        );

        $inbox->set_filters($filters);
        $inbox->ignore_cache = True;
        $feedback = $inbox->present_feedback();
        
        $admin_check = S36Auth::user();  
        $company_id = S36Auth::user()->companyid;        
        //Resets UI code for clicky action function
        reset_inbox_ui($company_id, $redis);
        $category = new DBCategory;

        //Reply messages
        $sm = new Message\Services\SettingMessage(new Message\Repositories\DBMessage('msg'));
        $sm->get_messages();

        if($dbcompany_social->fetch_social_account('twitter')) { 
            $twitter   = new Feedback\Repositories\TWFeedback; 
            $social_services = Array(
                'tw' => $twitter->pull_tweets()
            );

            $social = new Feedback\Services\SocialFeedback($social_services, new Feedback\Repositories\DBSocialFeedback);
            $social->save_social_feeds('tw');
        }

        $view_data = Array(
            'feedback' => $feedback->grouped_feeds
          , 'feedback_present' => $dbfeedback->is_feedback_present()
          , 'pagination' => $feedback->pagination
          , 'admin_check' => $admin_check
          , 'categories' => $category->pull_site_categories()
          , 'status' => DB::table('Status', 'master')->get()
          , 'inbox_state' => Helpers::inbox_state($filter)
          , 'priority_obj' => (object)Array(0 => 'low', 60 => 'medium', 100 => 'high') 
          , 'filter' => $filter
          , 'company_id' => $company_id
          , 'reply_message' => json_encode($sm->jsonify())
        );
        
        if(!Input::get('_pjax')) { 
            echo View::of_layout()->partial('contents', 'inbox/inbox_index_view', $view_data);
        } else {
            echo View::make('inbox/inbox_index_view', $view_data);
        } 
    }), 

    'POST /inbox/update_feedback_attachment' => Array('name' => 'update_feedback_attachment', 'before' => 's36_auth', 'do' => function() use ($dbfeedback) { 
        $input = Input::get(); 

        $attachments = (isset($input['attachments'])) ? json_encode($input['attachments']) : '';
        Helpers::dump($attachments);
        Helpers::dump($input['remove_image']);
        /*
        $attachments = (isset($input['attachments'])) ? json_encode($input['attachments']) : '';
        $dbfeedback->update_feedback($input['feedbackId'], array('attachments'=>$attachments));

        if(isset($input['remove_image'])){
            foreach($input['remove_image'] as $url){ 
                $url = explode('uploaded_images',$url); //separate the application url from the image path
                $url = Config::get('application.upload_dir')."/uploaded_images{$url[1]}"; //get the correct image path for removal
                @unlink($url);
            }
        }
        */
    })
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
