<?php 
$hosted_settings = new Hosted\Repositories\DBHostedSettings;
$feedback = new Feedback\Repositories\DBFeedback;
$company = new Company\Repositories\DBCompany;

return array(
    'GET /hosted/single/(:num)' => function($id) use ($feedback) { 
        $feedback = $feedback->pull_feedback_by_id($id);
        $fb_id = Config::get('application.fb_id');
        return View::make('hosted/hosted_feedback_single_view', Array('feedback' => $feedback, 'fb_id' => $fb_id));
    },

    'GET /hosted/fullpage_partial/(:num?)' => function($page=False) use ($company,$hosted_settings,$feedback) { 
        $user           = S36Auth::user();
        $company_name   = Config::get('application.subdomain');
        $company_info   = $company->get_company_info($company_name);
        $panel          = $hosted_settings->get_panel_settings($company_info->companyid);
        $fb             = $feedback->televised_feedback_alt($company_name);

        $hosted = new Feedback\Services\HostedService($company_name, $fb->result); 
        $hosted->page_number = $page;
        $hosted->build_data();         
        $feeds = $hosted->fetch_data_by_set(); 

        return View::make('hosted/partials/fullpage_'.strtolower($panel->theme_name).'_layout_view', Array(
            'collection' => $feeds,'fb_id' => Config::get('application.fb_id'),'user' => $user
        ))->get();
    },

    'GET /hosted/quick_inbox' => function() use ($feedback) {
        $feeds = $feedback->newfeedback_by_company(false, $filter='positive');  
        echo json_encode($feeds->nodes);
    },

    'POST /hosted/change_feedback_status' => function() use ($feedback) { 
        $data = Input::get();
        $mode  = $data['feedstatus'];
        $feedids = $data['feeds'];
        $auth  = S36Auth::user();

        $feedbackstate = new Feedback\Services\FeedbackState($mode, $feedids, $auth->companyid);
        $feedbackstate->change_state();
    },

    'POST /hosted/render_feeds' => function() use ($feedback) {
        $company_name = Config::get('application.subdomain');
        $data = Input::get();
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

        $result_data = Array('view' => $view, 'theme_name' => strtolower($hosted->theme_name));
        echo json_encode($result_data);
    }
);
