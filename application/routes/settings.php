<?php

$category = new DBCategory;

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
        $company = new Company\Repositories\DBCompany;

        $post = (object)Input::get();
        $company->update_company_emails($post);
 
        //lets help the user along!
        if($forward_to = Input::get('forward_to')) {
            return Redirect::to($forward_to);
        } else { 
            return Redirect::to('settings');
        }         
    },

    'GET /settings/company'  => Array('name' => 'settings', 'before' => 's36_auth', 'do' => function(){  
        $user = S36Auth::user();

        return View::of_layout()->partial('contents', 'settings/settings_company_view', Array( 
            'user' => $user
        ));
    }),

    'POST /settings/save_companysettings' => function() {
        $company_settings = new Company\Services\CompanySettings;
        $company_settings->upload_companylogo($_FILES);
        $filename = $company_settings->get_filename();
        $errors = $company_settings->get_errors();  
        $company_settings->save_companysettings();

        Helpers::dump($filename);
        Helpers::dump($errors);
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
