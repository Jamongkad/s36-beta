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
        $tf = new Testify("Contact Module Refactor");
        //requirements for contact key first:lastname:email:city:country
        //use redis hash to pull out records of a company's contacts
        //increment by 1 if contact key exists, create new one if not
        //create single contact identity for CRUD operations
        //aggregate feedback under contact identity
        //TODO: 09-13-2012 this feature will be temporarily closed off until further notice.
        $tf->run();
    },

    'GET /testify/api' => function() { 
        $tf = new Testify("API Bug Fix");
        $user = new DBUser;
        $encrypt = new Encryption\Encryption;

        $obj = new StdClass;
        $obj->username = 'Aryann';
        $obj->company_id = 14;
        $me = $user->pull_user($obj);

        $d = '0dfKD8nNuh4ah4IElUDoprSkSuCBNwi8XUDeBooCqc4';

        $decrypt_string = $encrypt->decrypt( $d );


        $tf->assertEqual($me->username, 'Aryann');
        Helpers::dump($decrypt_string);
        $tf->run();
    }
);
