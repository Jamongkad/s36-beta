<?php

return array(
    'GET /dashboard' => Array('name' => 'dashboard', 'before' => 's36_auth', 'do' => function() {
        //print_r(Config::get('application.deploy_env'));

        $arr_data = Array(
            Array('Germany', 100) 
          , Array('United States', 450)
          , Array('Philippines', 290)
          , Array('Singapore', 780)
          , Array('Thailand', 659)
          , Array('Vietnam', 500)
          , Array('China', 300) 
          , Array('China', 300)
        );

        $geo_chart_data = json_encode($arr_data);

        return View::of_layout()->partial('contents', 'dashboard/dashboard_index_view', Array(
            'geo_chart_data' => $geo_chart_data
        ));
    }),
);
