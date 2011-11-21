<?php

return array(
    'GET /contacts' => Array('name' => 'contacts', 'before' => 's36_auth', 'do' => function() { 
        $contact = new Contact;
        $limit = 10;

        $pagination = new ZebraPagination;
        $offset = ($pagination->get_page() - 1) * $limit;

        $contacts = $contact->fetch_contacts($limit, $offset);
        $pagination->records($contacts->total_rows);
        $pagination->records_per_page($limit);
        
        return View::of_layout()->partial('contents', 'inbox/contacts_view', Array(
            'contacts' => $contacts 
          , 'pagination' => $pagination->render()
        ));
    }),

    'GET /contacts/view_contact/([0-9]+)' => Array('name' => 'view_contacts', 'before' => 's36_auth', 'do' => function($id) { 
        return $id;
        //return View::of_layout()->partial('contents', 'inbox/contacts_view');
    }),

    'GET /contacts/important' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function() { 
        return View::of_layout()->partial('contents', 'inbox/contacts_view');
    }),

    'GET /contacts/request' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function() { 
        return View::of_layout()->partial('contents', 'inbox/contacts_view');
    }),
);
