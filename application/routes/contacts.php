<?php
use Contact\Repositories\DBContact;
use Contact\Services\ContactMetrics;

$contact = new DBContact;
$contact_metrics = new ContactMetrics($contact, new DBMetric, new S36Auth);

return array(
    'GET /contacts' => Array('name' => 'contacts', 'before' => 's36_auth', 'do' => function() use ($contact, $contact_metrics) { 
        $limit = 7;

        $pagination = new ZebraPagination;
        $offset = ($pagination->get_page() - 1) * $limit;

        $contacts = $contact->fetch_contacts($offset, $limit);
        $pagination->selectable_pages(4);
        $pagination->records($contacts->total_rows);
        $pagination->records_per_page($limit);

        $page = Input::get('page');
        
        return View::of_layout()->partial('contents', 'contact/contacts_index_view', Array(
            'contacts' => $contacts 
          , 'metrics' => $contact_metrics->render_metric_bar()
          , 'pagination' => $pagination->render()
          , 'page' => ($page) ? '&page='.$page : null
        ));
    }),
    
    'POST /contacts/search' => function() use ($contact, $contact_metrics) {

        $search_term = Input::get('search_contact');
        $pagination = new ZebraPagination;
        $limit = 7;
        $offset = ($pagination->get_page() - 1) * $limit; 

        $search_results = $contact->search_contacts($search_term, $offset, $limit);
        $pagination->records($search_results->total_rows);
        $pagination->records_per_page($limit);

        $page = Input::get('page');
        
        return View::of_layout()->partial('contents', 'contact/contacts_index_view', Array(
            'contacts' => $search_results 
          , 'metrics' => $contact_metrics->render_metric_bar()
          , 'pagination' => $pagination->render()
          , 'page' => ($page) ? '&page='.$page : null
        ));

    },

    'GET /contacts/view_contact' => Array('name' => 'view_contacts', 'before' => 's36_auth', 'do' => function() use($contact, $contact_metrics) { 
        $get_data = (object)Input::get();

        $category = new DBCategory;
        $feedback_of_contact = $contact->get_contact_feedback($get_data);
        
        //we get the page no for the return trip
        $page = Input::get('page');

        return View::of_layout()->partial('contents', 'contact/contacts_inbox_view', array(  
            'metrics' => $contact_metrics->render_metric_bar()
          , 'categories' => $category->pull_site_categories()
          , 'status' => DB::Table('Status', 'master')->get()
          , 'feedback_of_contact' => $feedback_of_contact
          , 'page' => ($page) ? '?page='.$page : null
          , 'admin_check' => s36auth::user()
          , 'priority_obj' => (object)array(0 => 'low', 60 => 'medium', 100 => 'high')
        ));
    }),

    'GET /contacts/pull_feedback_for_contact/(:num)/(:num)' => function($page, $limit) use ($contact) {

        $category = new DBCategory;

        $offset = ($page - 1) * $limit;

        $data_request = new StdClass;
        $data_request->limit = $limit;
        $data_request->offset = $offset;
        $data_request->company_id = S36Auth::user()->companyid;
        $data_request->name = Input::get('name');
        $data_request->email = Input::get('email');

        $feedback_of_contact = $contact->get_contact_feedback($data_request);
        //echo view partial here
        echo View::make('contact/partials/contacts_units_partial_view', array(  
            'categories' => $category->pull_site_categories()
          , 'status' => DB::Table('Status', 'master')->get()
          , 'feedback_of_contact' => $feedback_of_contact
          , 'admin_check' => s36auth::user()
          , 'priority_obj' => (object)array(0 => 'low', 60 => 'medium', 100 => 'high')
        ))->get();
    },

    'GET /contacts/edit_contact' => Array('name' => 'edit_contacts', 'before' => 's36_auth', 'do' => function() use($contact, $contact_metrics) { 
        $get_data = (object)Input::get();
        $page = Input::get('page');

        return View::of_layout()->partial('contents', 'contact/contacts_edit_view', Array( 
            'metrics' => $contact_metrics->render_metric_bar()
          , 'contact_person' => $contact->get_contact_info($get_data->email)
          , 'page' => ($page) ? '?page='.$page : null
          , 'countries' => DB::Table('Country', 'master')->get()
          , 'errors' => Array()
        ));
    }),

    'POST /contacts/edit_contact' => function() use($contact, $contact_metrics) {

        $data = Input::get();

        $page = (($data['page']) ? '&page='.$data['page'] : null);
 
        $rules = Array('firstname' => 'required');

        $validator = Validator::make($data, $rules);
        
        if(!$validator->valid()) {
            return View::of_layout()->partial('contents', 'contact/contacts_edit_view', Array(
                'metrics' => $contact_metrics->render_metric_bar()
              , 'contact_person' => $contact->get_contact_info($data['email'])
              , 'page' => (Input::get('page')) ? '?page='.Input::get('page') : null
              , 'countries' => DB::Table('Country', 'master')->get()
              , 'errors' => $validator->errors
            ));
        } 

        $contact->update_contact($data);     
        return Redirect::to('contacts/edit_contact?email='.$data['email'].$page); 
    },

    'GET /contacts/delete_contact' => function() use($contact) { 
        $data = Input::get();
        return Helpers::show_data($contact->delete_contact($data['email']));
    },
);
