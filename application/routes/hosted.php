<?php 

$feedback = new Feedback\Repositories\DBFeedback;

return array(
    /* DEPRECATED
    'GET /hosted/form/(:any)' => function($widget_id) { 

        $wl = new Widget\Services\WidgetLoader($widget_id); 
        $company = new Company\Repositories\DBCompany;
        $widget = $wl->load();
        $company_info = $company->get_company_info($widget->company_id);
        
        $hostname = Config::get('application.hostname');

        return View::of_company_layout()->partial('contents', 'hosted/hosted_feedback_form_view', Array(
            'widget' => $widget->render_hosted(), 'company' => $company_info, 'hostname' => $hostname
        ));

    },
    */

    'GET /hosted/single/(:num)' => function($id) use ($feedback) { 
        $feedback = $feedback->pull_feedback_by_id($id);
        $fb_id = Config::get('application.fb_id');
        return View::make('hosted/hosted_feedback_single_view', Array('feedback' => $feedback, 'fb_id' => $fb_id));
    },

    'GET /hosted/fullpage_partial/(:any)/(:num?)' => function($company_name, $page=False) {
        $hosted = new Feedback\Services\HostedService($company_name);
        $hosted->page_number = $page;

        $hosted->fetch_hosted_feedback(); 
        $hosted->build_data();         
        echo $hosted->view_fragment();
    }
);
