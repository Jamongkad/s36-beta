<?php

$category = new Category;

return array (
    'GET /settings' => Array('name' => 'settings', 'before' => 's36_auth', 'do' => function() use ($category) {
        $user = S36Auth::user();
        return View::of_layout()->partial('contents', 'settings/settings_index_view', Array(
            'user' => $user
          , 'category' => $category->pull_site_categories()
        ));
    }),

    'POST /settings/rename_ctgy/([0-9]+)' => function($id) use($category) { 
        $ctgy_nm = Input::get('ctgy_nm');
        return $category->update_category_name($ctgy_nm, $id);
    },

    'GET /settings/delete_ctgy/([0-9]+)' => function($id) use($category) { 
        return $category->delete_category_name($id);
    },

    'POST /settings/write_ctgy' => function() use($category) {  
        $ctgy_nm = Input::get('ctgy_nm');
        $companyId = Input::get('companyId');
        return $category->write_category_name($ctgy_nm, $companyId);
    },

    'POST /settings/savesettings' => function() {
        $company = new Company;
        $post = (object)Input::get();
        Helpers::show_data($post); 
        $company->update_company_emails($post);
        return Redirect::to('settings');
    },

    'GET /settings/upgrade' => Array('name' => 'settings', 'before' => 's36_auth', 'do' => function() {
        return View::of_layout()->partial('contents', 'settings/settings_index_view');
    }),

    'GET /settings/change_card' => Array('name' => 'settings', 'before' => 's36_auth', 'do' => function() {
        return View::of_layout()->partial('contents', 'settings/settings_index_view');
    }),

    'GET /settings/cancel_account' => Array('name' => 'settings', 'before' => 's36_auth', 'do' => function() {
        return View::of_layout()->partial('contents', 'settings/settings_index_view');
    }),

);
