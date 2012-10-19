<?php

return array(
	/*
	|--------------------------------------------------------------------------
	| View Names & Composers
	|--------------------------------------------------------------------------
	|
	| Named views give you beautiful syntax when working with your views.
	|
	| Here's how to define a named view:
	|
	|		'home.index' => array('name' => 'home')
	|
	| Now, you can create an instance of that view using the expressive View::of
	| dynamic method. Take a look at this example:
	|
	|		return View::of_layout();
	|
	| View composers provide a convenient way to add common elements to a view
	| each time it is created. For example, you may wish to bind a header and
	| footer partial each time the view is created.
	|
	| The composer will receive an instance of the view being created, and is
	| free to modify the view however you wish. Here is how to define one:
	|
	|		'home.index' => function($view)
	|		{
	|			//
	|		}
	|
	| Of course, you may define a view name and a composer for a single view:
	|
	|		'home.index' => array('name' => 'home', function($view)
	|		{
	|			//
	|		})	
	|
	*/

	'home.index' => array('name' => 'home', function($view)
	{
        return $view;
	}),
    
    'partials/layout' => array('name' => 'layout', function($view) { 
        $view->partial('header', 'partials/header');
        $view->partial('footer', 'partials/footer');
        return $view;
    }),

    'partials/widget_layout' => array('name' => 'widget_layout', function($view) {
        $view->partial('widget_header', 'partials/widget_header');
        $view->partial('widget_footer', 'partials/widget_footer'); 
        return $view;
    }),

    'partials/home_layout' => array('name' => 'home_layout', function($view) {
        $view->partial('home_header', 'partials/home_header');
        $view->partial('home_footer', 'partials/home_footer'); 
        return $view; 
    }),
 
    'partials/company_layout' => array('name' => 'company_layout', function($view) {
        $view->partial('company_header', 'partials/company_header');
        $view->partial('company_footer', 'partials/company_footer'); 
        return $view; 
    }),
     'partials/fullpage_layout' => array('name' => 'fullpage_layout', function($view) {
        $view->partial('company_header', 'partials/fullpage_header');
        $view->partial('company_footer', 'partials/fullpage_footer'); 
        return $view; 
    })
);
