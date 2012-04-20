<?php 

return array(
    'GET /hosted/form/(:any)' => function($widget_id) { 
        $wl = new Widget\Services\WidgetLoader($widget_id); 
        $company = new DBCompany;
        $widget = $wl->load();
        Helpers::dump($widget); 
        Helpers::dump($company->get_company_info($widget->company_id)); 

        return View::of_company_layout()->partial('contents', 'hosted/hosted_feedback_form_view', Array(
            'widget' => $widget->render_hosted(), 'company' => $company
        ));
    },
);
