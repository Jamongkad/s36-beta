<?php 

return array(
    'GET /company' => function() { 
        return View::of_company_layout()->partial('contents', 'company/hosted_feedback_form_view');
    },
);
