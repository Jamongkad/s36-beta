<?php
require_once 'determiner.php';
$determine = new Determiner;  

return array(

	/*
	|--------------------------------------------------------------------------
	| Application URL
	|--------------------------------------------------------------------------
	|
	| The URL used to access your application. No trailing slash.
	|
	*/

    'url'        => $determine->d->host,
    'deploy_env' => $determine->d->deploy_env,
    'env_name'   => $determine->d->env_name,
    'hostname'   => $determine->d->hostname,
    'fb_id'      => $determine->d->fb_id,
    'fb_secret'  => $determine->d->fb_secret,
    'subdomain'  => $determine->d->subdomain,

    /*
	|--------------------------------------------------------------------------
	| Application Directories
	|--------------------------------------------------------------------------
	|
	| The Directories used to access your different assets. No trailing slash.
	|
	*/
	'assets_dir'			=> $determine->d->assets_dir,
	'hosted_background'		=> '/uploaded_images/hosted_background',
	'attachments_small'		=> '/uploaded_images/form_upload/small',
	'attachments_medium'	=> '/uploaded_images/form_upload/medium',
	'attachments_large'		=> '/uploaded_images/form_upload/large',
    'avatar48_dir'			=> '/uploaded_images/avatar/small',
    'avatar150_dir'			=> '/uploaded_images/avatar/medium',
    'coverphoto_dir'		=> '/uploaded_images/coverphoto',
    'fullpage_pattern_dir'	=> 'fullpage/common/img/patterns',
    'upload_dir'			=> '/var/www/s36-upload-images',
    'uploaded_images_dir'	=> '/var/www/s36-upload-images/uploaded_images',

	/*
	|--------------------------------------------------------------------------
	| Application Index
	|--------------------------------------------------------------------------
	|
	| If you are including the "index.php" in your URLs, you can ignore this.
	|
	| However, if you are using mod_rewrite or something similar to get
	| cleaner URLs, set this option to an empty string.
	|
	*/

	'index' => '',

	/*
	|--------------------------------------------------------------------------
	| Application Language
	|--------------------------------------------------------------------------
	|
	| The default language of your application. This language will be used by
	| Lang library as the default language when doing string localization.
	|
	| If you are not using the Lang library, this option isn't really important.
	|
	*/

	'language' => 'en',

	/*
	|--------------------------------------------------------------------------
	| Application Character Encoding
	|--------------------------------------------------------------------------
	|
	| The default character encoding used by your application. This is the
	| character encoding that will be used by the Str, Text, and Form classes.
	|
	*/

	'encoding' => 'UTF-8',

	/*
	|--------------------------------------------------------------------------
	| Application Timezone
	|--------------------------------------------------------------------------
	|
	| The default timezone of your application. This timezone will be used when
	| Laravel needs a date, such as when writing to a log file.
	|
	*/

	'timezone' => 'Asia/Singapore',

	/*
	|--------------------------------------------------------------------------
	| Auto-Loaded Packages
	|--------------------------------------------------------------------------
	|
	| The packages that should be auto-loaded each time Laravel handles
	| a request. These should generally be packages that you use on almost
	| every request to your application.
	|
	| Each package specified here will be bootstrapped and can be conveniently
	| used by your application's routes, models, and libraries.
	|
	| Note: The package names in this array should correspond to a package
	|       directory in application/packages.
	|
	*/

	'packages' => array(),

	/*
	|--------------------------------------------------------------------------
	| Active Modules
	|--------------------------------------------------------------------------
	|
	| Modules are a convenient way to organize your application into logical
	| components. Each module may have its own libraries, models, routes,
	| views, language files, and configuration.
	|
	| Here you may specify which modules are "active" for your application.
	| This simply gives Laravel an easy way to know which directories to
	| check when auto-loading your classes, routes, and views.
	|
	*/

	'modules' => array(),

	/*
	|--------------------------------------------------------------------------
	| Application Key
	|--------------------------------------------------------------------------
	|
	| Your application key should be a 32 character string that is totally
	| random and secret. This key is used by the encryption class to generate
	| secure, encrypted strings.
	|
	| If you will not be using the encryption class, this doesn't matter.
	|
	*/

	'key' => '76wbf0w8c08ws1nbo9gbgyxn3iwfy0xg',

	/*
	|--------------------------------------------------------------------------
	| Twitter Application Keys
	|--------------------------------------------------------------------------
	*/
    //Dev
    'dev_twitter_key' => 'xWBm4zMz9q3cgiTnzZf6Rg', 
    'dev_twitter_secret' => 'TbCPpdcteB4pRAXqQGba8njhDYmg7LjfHq7YLgKlE',
    'dev_twitter_access_token' => '942732308-HHy4iqcRsv4nqTr1fYCH8j8TWfo87Z0cFYBDjpON',
    'dev_twitter_access_secret' => 'tGbbfd0FCj4nP5C94luz9TPJK5llj1vJnZCH8Eto',

    //Prod
    'prod_twitter_key' => 'WVqRJvcb13366Fbo4DlCBQ', 
    'prod_twitter_secret' => 'zesy83kVSpCZcVk0SJptABwBtAHfB3OqJV0zAblKw',
    'prod_twitter_access_token' => '942732308-dA31dLX08wovYj2W8Nh7IMEbYCZlYnP158DJRA2k',
    'prod_twitter_access_secret' => 'Md3Zq0tMyj7i5dPJHFgciRFgQ5eZ8HwmwhUMJG0vyus',
);
