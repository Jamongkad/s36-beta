<?php

return array(

   /* Configuration name */
	'mongo' => array(

		/**
		 * Connection Setup
		 *
		 * See http://www.php.net/manual/en/mongo.construct.php for more information
		 *
		 * or just edit / uncomment the keys below to your requirements
		 */
		'connection' => array(

			/** hostnames, separate multiple hosts by commas **/
			'hostnames' => 'localhost',

			/** database to connect to **/
			'database'  => 's36_mdb',

			/** authentication **/
			'username'  => '',
			'password'  => '',

		)

	)
);
