<?php
$config = array ();
$config ['db'] = array (
		'adapter' => 'pdo', // it could be mysqli
		'options' => array (
				'driver' => 'mysql', // any pdo supported driver: sqllite, mysql, oci
				'host' => 'localhost',
				'user' => 'root',
				'password' => '',
				'db' => 'bloggingsystem',
				'options' => array () 
		) 
);

$config ['allowedActions'] = array (
		'index',
		'newPost',
		'getPost',
		'getPosts',
		'getPostComments',
		'savePost',
		'saveComment',
		'showPost',
		'saveComment' 
);
$config ['allowedTags'] = array (
		'<li>',
		'<p>',
		'<br>',
		'<pre>',
		'<code>',
		'<b>' 
);

$config ['antiSpamQuestions'] = array (
		array (
				'question' => '2x2',
				'answer' => 4 
		) ,
		array (
				'question' => '2+2',
				'answer' => 4
		),
		array (
				'question' => '6x6',
				'answer' => 36
		),
		array (
				'question' => '12-6',
				'answer' => 6
		),
		array (
				'question' => '5+6',
				'answer' => 11
		),
 
    array (
        'question' => '9-2',
        'answer' => 7
    )
);
return $config;