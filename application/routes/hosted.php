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
        $feeds = $hosted->fetch_data_by_set(); 
        $user = S36Auth::user();

        return View::make('hosted/partials/hosted_feedback_partial_view', Array(
            'collection' => $feeds, 'fb_id' => Config::get('application.fb_id'), 'user' => $user
        ))->get();
    },

    'GET /hosted/quick_inbox' => function() {
        $data = Array(
            Array('id' => 286, 'name' => 'Mathew Wong', 'text' => 'Ted is a dick.') 
         ,  Array('id' => 287, 'name' => 'Irene Paredes', 'text' => 'Ted is a dick.') 
        );
    
        echo json_encode($data);
    }
);
