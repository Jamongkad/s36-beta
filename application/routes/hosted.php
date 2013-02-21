<?php 

$feedback = new Feedback\Repositories\DBFeedback;

return array(
    'GET /hosted/single/(:num)' => function($id) use ($feedback) { 
        $feedback = $feedback->pull_feedback_by_id($id);
        $fb_id = Config::get('application.fb_id');
        return View::make('hosted/hosted_feedback_single_view', Array('feedback' => $feedback, 'fb_id' => $fb_id));
    },

    'GET /hosted/fullpage_partial/(:num?)' => function($page=False) use ($feedback) { 
        $user = S36Auth::user();
        $coompany_name = Config::get('application.subdomain');
        $fb = $feedback->televised_feedback_alt($company_name);
        $hosted = new Feedback\Services\HostedService($company_name, $fb->result); 
        $hosted->page_number = $page;
        $hosted->build_data();         
        $feeds = $hosted->fetch_data_by_set(); 

        return View::make('hosted/partials/hosted_feedback_partial_view', Array(
            'collection' => $feeds, 'fb_id' => Config::get('application.fb_id'), 'user' => $user
        ))->get();
    },

    'GET /hosted/quick_inbox' => function() use ($feedback) {
        $feeds = $feedback->newfeedback_by_company(false, $filter='positive');  
        echo json_encode($feeds->nodes);
    },

    'POST /hosted/change_feedback_state' => function() use ($feedback) {
        $company_name = Config::get('application.subdomain');
        $data = Input::get();
        $mode = $data['status'];
        $feeds = $data['feeds'];

        $fb = $feedback->cherry_pick_feedback($feeds, $company_name);
        $hosted = new Feedback\Services\HostedService($company_name, $fb);
        $sets = $hosted->group_and_build();
        $user = S36Auth::user();
        Helpers::dump($sets);
        /*
        return View::make('hosted/partials/hosted_feedback_partial_view', Array(
            'collection' => $sets, 'fb_id' => Config::get('application.fb_id'), 'user' => $user
        ))->get();
        */
        /*
        $hosted = new Feedback\Services\HostedService($mycompany, $feeds);
        $sets = $hosted->group_and_build();
        Helpers::dump($sets);
        */

        /*
        $feed_ids = Array($data['feedid']);
        $mode = $data['state'];
        $auth = S36Auth::user();
        */

        /*
        $feedbackstate = new Feedback\Services\FeedbackState($mode, $feed_ids, $auth->companyid);
        $feedbackstate->change_state();
        */
    }
);
