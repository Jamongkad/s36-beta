<?php

return array(
    'GET /dashboard' => Array('name' => 'dashboard', 'before' => 's36_auth', 'do' => function() {
        //print_r(Config::get('application.deploy_env'));
        $dash = new DBDashboard; 
        $dash->company_id = S36Auth::user()->companyid;
        $dashboard_summary = $dash->pull_summary();

        return View::of_layout()->partial('contents', 'dashboard/dashboard_index_view', Array(
            'dashboard_summary' => $dashboard_summary
        ));

    }),
);
