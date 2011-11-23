<?php

return array(
    'GET /contacts' => Array('name' => 'contacts', 'before' => 's36_auth', 'do' => function() { 
        $contact = new Contact;
        $contact_metrics = new ContactMetrics;

        $limit = 10;

        $pagination = new ZebraPagination;
        $offset = ($pagination->get_page() - 1) * $limit;

        $contacts = $contact->fetch_contacts($limit, $offset);
        $pagination->records($contacts->total_rows);
        $pagination->records_per_page($limit);
        
        return View::of_layout()->partial('contents', 'inbox/contacts_index_view', Array(
            'contacts' => $contacts 
          , 'metrics' => $contact_metrics->render_metric_bar()
          , 'pagination' => $pagination->render()
        ));
    }),

    'GET /contacts/view_contact/(:any)' => Array('name' => 'view_contacts', 'before' => 's36_auth', 'do' => function($name) { 
        $contacts = new Contact;
        $contact_metrics = new ContactMetrics;

        return View::of_layout()->partial('contents', 'inbox/contacts_inbox_view', Array(  
            'metrics' => $contact_metrics->render_metric_bar()
        ));
      
    }),

    'GET /contacts/edit_contact/([0-9]+)' => Array('name' => 'edit_contacts', 'before' => 's36_auth', 'do' => function($id) { 
        return $id;
        //return View::of_layout()->partial('contents', 'inbox/contacts_view');
    }),

);
