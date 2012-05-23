<?php 

$feedback = new Feedback\Repositories\DBFeedback;

return array(

    'GET /hosted/form/(:any)' => function($widget_id) { 
        echo "calling form<br/>";
        Helpers::dump($_SERVER['HTTP_HOST']);
        return $widget_id;
        /*
        $wl = new Widget\Services\WidgetLoader($widget_id); 
        $company = new Company\Repositories\DBCompany;
        $widget = $wl->load();
        $company_info = $company->get_company_info($widget->company_id);

        return View::of_company_layout()->partial('contents', 'hosted/hosted_feedback_form_view', Array(
            'widget' => $widget->render_hosted(), 'company' => $company_info
        ));
        */
    },

    'GET /hosted/single/(:num)' => function($id) use ($feedback) { 

        echo "calling single<br/>";
        Helpers::dump($_SERVER['HTTP_HOST']);
        return $id;
        /*
        $feedback = $feedback->pull_feedback_by_id($id);
        $fb_id = Config::get('application.fb_id');
        /*
        return View::of_company_layout()->partial('contents', 'hosted/hosted_feedback_single_view'
                                                  , Array('feedback' => $feedback, 'fb_id' => $fb_id));
        return View::make('hosted/hosted_feedback_single_view', Array('feedback' => $feedback, 'fb_id' => $fb_id));
        */
    },

    'GET /hosted/fullpage/(:any)' => function($company_id) use ($feedback) {
        echo "calling fullpage<br/>";
        Helpers::dump($_SERVER['HTTP_HOST']);
        return $company_id;
        /*
        $company = new Company\Repositories\DBCompany;
        $company_info = $company->get_company_info($company_id); 

        $hosted = new Feedback\Services\HostedService($company_id);
        $hosted->limit = 10;
        $hosted->ignore_cache = True;
        $feeds = $hosted->fetch_hosted_feedback(); 

        $dbw = new Widget\Repositories\DBWidget;
        $widget = $dbw->fetch_canonical_widget($company_id);

        return View::of_company_layout()->partial( 'contents', 'hosted/hosted_feedback_fullpage_view'
                                                  , Array(  'company' => $company_info, 'feeds' => $feeds->html
                                                          , 'widget' => $widget ));        
        */
    },

    'GET /hosted/fullpage_partial/(:num)/(:num?)' => function($company_id, $page=False) {
        $hosted = new Feedback\Services\HostedService($company_id);
        $hosted->page_number = $page;
        $hosted->limit = 10;
        $hosted->ignore_cache = True;
        $feeds = $hosted->fetch_hosted_feedback(); 
        echo $feeds->html; 
    }
);
