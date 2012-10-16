<?php

return array(
    'GET /dashboard' => Array('name' => 'dashboard', 'before' => 's36_auth', 'do' => function() {
        $dash = new DBDashboard; 
        $dash->company_id = S36Auth::user()->companyid;
        $dashboard_summary = $dash->pull_summary();

        //Helpers::dump(Config::get('application.subdomain'));

        return View::of_layout()->partial('contents', 'dashboard/dashboard_index_view', Array(
            'dashboard_summary' => $dashboard_summary
        ));
    }),

    'GET /dashboard/pwet' => function() {
        Helpers::show_data(Input::get('_pjax'));
        echo "<div class='button-gray'><a href='#'>pwet ka</a></div>";
    },

    'GET /dashboard/wewe' => function() { 
        echo "pwet wewe";
    },
);
