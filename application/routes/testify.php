<?php

return array(
    'GET /testify' => function() { 
        $tf = new Testify("Mathew Test");
        $tf->beforeEach(function($tf) {
            $tf->data->calc = 3;  
        });
        
        $tf->test("Testing the add method", function($tf) {
            $num = $tf->data->calc;     
            $tf->assert($num);
            $tf->assert(True);
            $tf->assert(True);
        });

        $tf->test("Testing enequality", function($tf) {
            $num = $tf->data->calc;     
            $tf->assertEqual($num, 1);
            $tf->assertEqual($num, 3);
        });

        $tf->run();
    }, 

    'GET /testify/contact' => function() { 
        $tf = new Testify("Contact Bug Fix");
        //requirements for contact aggregation is first:lastname:email:city:country

        $tf->run();
    }
);
