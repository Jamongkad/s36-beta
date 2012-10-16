<?php 

$feedback = new Feedback\Repositories\DBFeedback;

return array(
    'GET /hosted/single/(:num)' => function($id) use ($feedback) { 
        $feedback = $feedback->pull_feedback_by_id($id);
        $fb_id = Config::get('application.fb_id');
        return View::make('hosted/hosted_feedback_single_view', Array('feedback' => $feedback, 'fb_id' => $fb_id));
    },

    'GET /hosted/fullpage_partial/(:any)/(:num?)' => function($company_name, $page=False) {
        $hosted = new Feedback\Services\HostedService($company_name);
        $hosted->page_number = $page;

        $hosted->fetch_hosted_feedback(); 
        $hosted->build_data();         
        echo $hosted->view_fragment();
    }
);
