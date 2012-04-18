<?php 

return array(
    'GET /company/hosted_form/(:any)' => function($widget_id) { 
        $wl = new Widget\Services\WidgetLoader($widget_id); 
        $widget = $wl->load();

        Helpers::dump($widget->render_hosted());

        return View::of_company_layout()->partial('contents', 'company/hosted_feedback_form_view', Array(
            'subdomain' => Input::get('subdomain')
        ));
    },
);
