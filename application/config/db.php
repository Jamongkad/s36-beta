<?php
//TODO GENERALIZE THIS!!
function host_determiner_db() {
    
    $http_host = $_SERVER['SERVER_NAME'];
    //localhost
    if($http_host == 'dev.36stories.localhost') 
        return 'localhost';
    
    //DEV
    if($http_host == 'www.gearfish.com') 
        return 'localhost';

    //STAGING
    if($http_host == 'ec2-50-18-107-194.us-west-1.compute.amazonaws.com')
        return 'stagedb.c7lrkmoeb1l2.us-west-1.rds.amazonaws.com';

    //PRODUCTION
    $str = $_SERVER['SERVER_NAME'];
    $pattern = '#([a-z]+\.|https?:\/\/){1}[a-zA-Z0-9]{2,}\.[a-zA-Z0-9]{2,}(\S*)#i';
    preg_match_all($pattern, $str, $matches, PREG_PATTERN_ORDER);  
    if($matches[0])
        return 'prod-db1.c7lrkmoeb1l2.us-west-1.rds.amazonaws.com';
}

print_r(host_determiner_db());

return array(

	/*
	|--------------------------------------------------------------------------
	| Default Database Connection
	|--------------------------------------------------------------------------
	|
	| The name of your default database connection.
	|
	| This connection will be used by default for all database operations
	| unless a different connection is specified when performing the operation.
	|
	*/

	'default' => 'master',

	/*
	|--------------------------------------------------------------------------
	| Database Connections
	|--------------------------------------------------------------------------
	|
	| Here you can define all of the databases used by your application.
	|
	| Supported Drivers: 'mysql', 'pgsql', 'sqlite'.
	|
	| Note: When using the SQLite driver, the path and "sqlite" extention will
	|       be added automatically. You only need to specify the database name.
	|
	*/

	'connections' => array(

		'sqlite' => array(
			'driver'   => 'sqlite',
			'database' => 'application',
		),

		'master' => array(
			'driver'   => 'mysql',
			'host'     => host_determiner_db(),
			'host'     => 'localhost',
			'database' => 's36',
			'username' => 'root',
			'password' => 'brx4*svv',
			'charset'  => 'utf8',
		),

		'pgsql' => array(
			'driver'   => 'pgsql',
			'host'     => 'localhost',
			'database' => 'database',
			'username' => 'root',
			'password' => 'password',
			'charset'  => 'utf8',
		),

	),

);
