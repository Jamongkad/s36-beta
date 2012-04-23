<?php 

$feedback = new Feedback\Repositories\DBFeedback;
return array(

    'GET /hosted/form/(:any)' => function($widget_id) { 
        $wl = new Widget\Services\WidgetLoader($widget_id); 
        $company = new DBCompany;
        $widget = $wl->load();
        $company_info = $company->get_company_info($widget->company_id);

        return View::of_company_layout()->partial('contents', 'hosted/hosted_feedback_form_view', Array(
            'widget' => $widget->render_hosted(), 'company' => $company_info
        ));
    },

    'GET /hosted/single/(:num)' => function($id) use ($feedback) { 
        $feedback = $feedback->pull_feedback_by_id($id);
        Helpers::dump($feedback);
    }
);
