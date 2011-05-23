<?php defined('SYSPATH') or die('No direct access allowed.');

return array(

	'driver'       => 'ORM',
	'hash_method'  => 'sha256',
	'hash_key'     => 'PCP',
	'lifetime'     => 1209600,
	'session_key'  => 'auth_user',

	// Username/password combinations for the Auth File driver
	'users' => array(),

);
