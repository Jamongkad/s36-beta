<?php 

$feedback = new Feedback\Repositories\DBFeedback;

return array(
    'GET /hosted/single/(:num)' => function($id) use ($feedback) { 
        $feedback = $feedback->pull_feedback_by_id($id);
        $fb_id = Config::get('application.fb_id');
        return View::make('hosted/hosted_feedback_single_view', Array('feedback' => $feedback, 'fb_id' => $fb_id));
    },

    'GET /hosted/fullpage_partial/(:any)/(:num?)' => function($page=False) {
        $hosted = new Feedback\Services\HostedService(Config::get('application.subdomain'));
        $hosted->page_number = $page;
        $hosted->build_data();         
        echo $hosted->view_fragment();
    }
);
