<?php

return array(
    'GET /api' => function() { 
        $feedback = new Feedback;
        print_r($feedback);
    }
);
