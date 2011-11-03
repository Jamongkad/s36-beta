<?php

return array(
    'GET /contacts' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function() { 
        $contact = new Contact;
        return View::of_layout()->partial('contents', 'inbox/contacts_view', Array(
            'contacts' => $contact->fetch_contacts()
        ));
    }),

    'GET /contacts/important' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function() { 
        return View::of_layout()->partial('contents', 'inbox/contacts_view');
    }),

    'GET /contacts/request' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function() { 
        return View::of_layout()->partial('contents', 'inbox/contacts_view');
    }),
);
