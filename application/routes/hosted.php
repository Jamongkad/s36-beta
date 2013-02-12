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

            Array('id' => 1, 'name' => 'Mathew Wong', 'text' => 'Your service is awesome!') 
        /*
         ,  Array('id' => 2, 'name' => 'Irene Paredes', 'text' => 'Mystical Creatures') 
         ,  Array('id' => 3, 'name' => 'Meagan Wong', 'text' => 'HEY I LOVE ICECREAM :))') 
         ,  Array('id' => 4, 'name' => 'Robert Mordido', 'text' => 'DOTA 2 Rocks.') 
         ,  Array('id' => 5, 'name' => 'Leica Chang', 'text' => 'I am a cute futtie.') 
         */
         ,  Array('id' => 6, 'name' => 'Derps Matusoc', 'text' => 'Hi am a derp!') 
         ,  Array('id' => 7, 'name' => 'Kennwel Labarda', 'text' => 'I love raping people...with my mind.') 
         ,  Array('id' => 8, 'name' => 'Ryan Chua', 'text' => 'Ohhhh lah lah.') 
        );
    
        echo json_encode($data);
    }
);
