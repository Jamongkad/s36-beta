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

);
