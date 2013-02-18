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

    'GET /hosted/quick_inbox' => function() use ($feedback) {
        /*
        $data = Array(
            Array(  'id' => 1
                  , 'name' => 'Mathew Wong'
                  , 'text' => 'Your service is awesome!'
                  , 'subcontent' => true
                  , 'media' => Array(
                        Array('mid' => 10, 'type' => 'video', 'src' => 'youtube')     
                      , Array('mid' => 12, 'type' => 'pic', 'src' => 'picpic')     
                  ) 
                  , 'metadata' => Array(
                        Array('mtid' => 10, 'key' => 'Had sex recently', 'value' => 'yes')     
                      , Array('mtid' => 12, 'key' => 'Spa?', 'value' => 'Aww Yeahh')     
                      , Array('mtid' => 13, 'key' => 'Massage?', 'value' => 'Could have been worse')     
                  )) 
         ,  Array(  'id' => 2
                  , 'subcontent' => false
                  , 'name' => 'Irene Paredes'
                  , 'text' => 'Mystical Creatures') 
         ,  Array(  'id' => 3
                  , 'subcontent' => false
                  , 'name' => 'Meagan Wong'
                  , 'text' => 'HEY I LOVE ICECREAM :))') 
         ,  Array(  'id' => 4
                  , 'subcontent' => false
                  , 'name' => 'Robert Mordido'
                  , 'text' => 'DOTA 2 Rocks.') 
         ,  Array(  'id' => 5
                  , 'subcontent' => false
                  , 'name' => 'Leica Chang'
                  , 'text' => 'I am a cute futtie.') 
         ,  Array(  'id' => 6
                  , 'subcontent' => false
                  , 'name' => 'Derps Matusoc'
                  , 'text' => 'Hi am a derp!') 
         ,  Array(  'id' => 7
                  , 'subcontent' => false
                  , 'name' => 'Kennwel Labarda'
                  , 'text' => 'I love raping people...with my mind.') 
         ,  Array(  'id' => 8
                  , 'subcontent' => false
                  , 'name' => 'Ryan Chua'
                  , 'text' => 'Ohhhh lah lah.') 
        );
    
        echo json_encode($data);
        */

        $feedback = $feedback->newfeedback_by_company();  
        echo json_encode($feedback->nodes);
    },

    'POST /hosted/change_feedback_state' => function() {
        print_r(Input::get());
    }
);
