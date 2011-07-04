<?php

$user = new S36Auth();

return array(

    'GET /' => function() use($user) {
        print_r($user->user());
        print_r($user->check());
        return View::make('home/index');
    },
     
    'GET /test' => function() use($user) {
        print_r($user->login("budi", "password"));
    },

    'GET /forget' => function() use($user) {
        $user->logout();
    },
    
    'GET /feedback' => function() {
        $conn = DB::connection('master');
        $feedback = $conn->query("
        SELECT 
            * 
        FROM 
            Feedback
        INNER JOIN
            Site
                ON Feedback.siteId = Site.siteId
        INNER JOIN
            Contact
                ON Feedback.contactId = Contact.contactId
        INNER JOIN
            Category
                ON Feedback.categoryId = Category.categoryId
        INNER JOIN
            Form
                ON Feedback.formId = Form.formId
        INNER JOIN
            Status
                ON Feedback.statusId = Status.statusId
        ");

        echo "<pre>";
        print_r($feedback->fetchAll(PDO::FETCH_CLASS));
        echo "</pre>";
    },

);
