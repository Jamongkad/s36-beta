<?php
use Contact\Repositories\DBContact;
use Contact\Services\ContactMetrics;

$contact = new DBContact;

return array(
    'GET /contacts' => Array('name' => 'contacts', 'before' => 's36_auth', 'do' => function() use ($contact) { 

        $auth = new S36Auth;

        $metric = new DBMetric;
        $metric->company_id = $auth->user()->companyid;

        $contact_metrics = new ContactMetrics($contact, $metric, $auth);

        $limit = 7;

        $pagination = new ZebraPagination;
        $offset = ($pagination->get_page() - 1) * $limit;

        $contacts = $contact->fetch_contacts($limit, $offset);
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

    'POST /contacts/search' => function() use ($contact) {

        $contact_metrics = new ContactMetrics;

        $search_term = Input::get('search_contact');
 
        $pagination = new ZebraPagination;
        $limit = 7;
        $offset = ($pagination->get_page() - 1) * $limit; 

        $contacts = $contact->fetch_contacts($limit, $offset, $search_term);
        $pagination->records($contacts->total_rows);
        $pagination->records_per_page($limit);

        $page = Input::get('page');
        
        return View::of_layout()->partial('contents', 'contact/contacts_index_view', Array(
            'contacts' => $contacts 
          , 'metrics' => $contact_metrics->render_metric_bar()
          , 'pagination' => $pagination->render()
          , 'page' => ($page) ? '&page='.$page : null
        ));
    },

    'GET /contacts/view_contact' => Array('name' => 'view_contacts', 'before' => 's36_auth', 'do' => function() use($contact) { 
        $get_data = (object)Input::get();

        $category = new DBCategory;
        $contact_metrics = new ContactMetrics;
        $contact_person = $contact->get_contact_feedback($get_data);

        $page = Input::get('page');

        return View::of_layout()->partial('contents', 'contact/contacts_inbox_view', Array(  
            'metrics' => $contact_metrics->render_metric_bar()
          , 'categories' => $category->pull_site_categories()
          , 'status' => DB::table('Status', 'master')->get()
          , 'contact_person' => $contact_person
          , 'page' => ($page) ? '?page='.$page : null
          , 'admin_check' => S36Auth::user()
          , 'priority_obj' => (object)Array(0 => 'low', 60 => 'medium', 100 => 'high')
        ));

    }),

    'GET /contacts/edit_contact' => Array('name' => 'edit_contacts', 'before' => 's36_auth', 'do' => function() use($contact) { 
        $get_data = (object)Input::get();
        $contact_metrics = new ContactMetrics;

        $page = Input::get('page');

        return View::of_layout()->partial('contents', 'contact/contacts_edit_view', Array( 
            'metrics' => $contact_metrics->render_metric_bar()
          , 'contact_person' => $contact->get_contact_info($get_data->email)
          , 'page' => ($page) ? '?page='.$page : null
          , 'countries' => DB::Table('Country', 'master')->get()
          , 'errors' => Array()
        ));
    }),

    'POST /contacts/edit_contact' => function() use($contact) {

        $data = Input::get();

        $page = (($data['page']) ? '&page='.$data['page'] : null);
 
        $contact_metrics = new ContactMetrics;        

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
