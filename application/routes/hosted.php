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

    'POST /hosted/preview_feeds' => function() use ($feedback) {
        $company_name = Config::get('application.subdomain');
        $data = Input::get();
        $mode = $data['status'];
        $feeds = $data['feeds'];

        $fb = $feedback->cherry_pick_feedback($feeds, $company_name);
        $hosted = new Feedback\Services\HostedService($company_name, $fb->result);
        $sets = $hosted->group_and_build();
        $user = S36Auth::user();

        $hosted_settings = new Hosted\Repositories\DBHostedSettings;
        $hosted = $hosted_settings->get_panel_settings($user->companyid);

        $view = View::make('hosted/partials/hosted_feedback_partial_view', Array(
            'collection' => $sets, 'fb_id' => Config::get('application.fb_id'), 'user' => $user
        ))->get();

        $result_data = Array(
            'view' => $view
          , 'theme_name' => strtolower($hosted->theme_name)
        );

        echo json_encode($result_data);

        /*
        $feedbackstate = new Feedback\Services\FeedbackState($mode, $feed_ids, $auth->companyid);
        $feedbackstate->change_state();
        */
    }
);
