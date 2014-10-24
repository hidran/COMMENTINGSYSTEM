<?php 
return  array(
		'adapter' => 'mysqli',
		'options' => array(
				'host' => 'localhost',
				'user' => 'root',
				'password' => '',
				'db' => 'bloggingsystem'
				,'dsn' => ''
		)
);

return  array(
    'adapter' => 'mysqli',
    'options' => array(
        'driver' => 'mysqli',
        'host' => 'localhost',
        'user' => 'root',
        'password' => '',
        'db' => 'bloggingsystem',
        'dsn' => '',
    		'options' => array(),
    )
);

return  array(
    'adapter' => 'pdo',
    'options' => array(
        'driver' => 'mysql',
        'host' => 'localhost',
        'user' => 'root',
        'password' => '',
        'db' => 'bloggingsystem',
        'dsn' => '',
        'options' => array(),
    )
);
