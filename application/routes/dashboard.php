<?php
$company = new Company\Repositories\DBCompany;
$company_name = Config::get('application.subdomain');
return Array(
    'GET /dashboard' => Array('name' => 'dashboard', 'before' => 's36_auth', 'do' => function() use($company,$company_name) {
        $dash = new DBDashboard(S36Auth::user()->companyid); 
        $dashboard_summary = $dash->pull_summary();
        $company_info = $company->get_company_info($company_name); 
        return View::of_layout()->partial('contents', 'dashboard/dashboard_index_view', Array(
             'dashboard_summary' => $dashboard_summary
            ,'company_info'      =>$company_info
        ));
    }),

    'GET /dashboard/pwet' => function() {
        Helpers::show_data(Input::get('_pjax'));
        echo "<div class='button-gray'><a href='#'>pwet ka</a></div>";
    },
);
