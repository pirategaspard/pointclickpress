<?php defined('SYSPATH') or die('No direct script access.');


return array(
	'admin' => array(
		'name' => 'PCP_admin',
		'encrypted' => TRUE,
		'lifetime' => 43200,
		'group' => 'default',
		'table' => 'sessions',
		'columns' => array(
			'session_id'  => 'session_id',
			'last_active' => 'last_active',
			'contents'    => 'contents'
		),
		'gc' => 500,
	),
	'PCP' => array(
		'name' => 'PCP',
		'encrypted' => TRUE,
		'lifetime' => 43200,
		'group' => 'default',
		'table' => 'sessions',
		'columns' => array(
			'session_id'  => 'session_id',
			'last_active' => 'last_active',
			'contents'    => 'contents'
		),
		'gc' => 500,
	)	
);


/*return array(
    'native' => array(
        'name' => 'session_name',
        'lifetime' => 43200,
    ),
    'cookie' => array(
        'name' => 'cookie_name',
        'encrypted' => TRUE,
        'lifetime' => 43200,
    ),
    'database' => array(
        'name' => 'cookie_name',
        'encrypted' => TRUE,
        'lifetime' => 43200,
        'group' => 'default',
        'table' => 'table_name',
        'columns' => array(
            'session_id'  => 'session_id',
            'last_active' => 'last_active',
            'contents'    => 'contents'
        ),
        'gc' => 500,
    ),
);
);*/

/*
 * CREATE TABLE  `sessions` (
    `session_id` VARCHAR(24) NOT NULL,
    `last_active` INT UNSIGNED NOT NULL,
    `contents` TEXT NOT NULL,
    PRIMARY KEY (`session_id`),
    INDEX (`last_active`)
) ENGINE = MYISAM; */
