<?php 

return array(
    'GET /hosted/form/(:any)' => function($widget_id) { 
        $wl = new Widget\Services\WidgetLoader($widget_id); 
        $company = new DBCompany;
        $widget = $wl->load();
        $company_info = $company->get_company_info($widget->company_id);
        /*
        Helpers::dump($widget); 
        Helpers::dump($company_info); 
        */
        return View::of_company_layout()->partial('contents', 'hosted/hosted_feedback_form_view', Array(
            'widget' => $widget->render_hosted(), 'company' => $company_info
        ));
    },
);
