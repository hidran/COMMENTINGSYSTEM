<?php
session_start();
session_regenerate_id();

function my_autoloader($class) {
	$class = str_replace('Blog\\', '', $class);
    // echo $class."<br>";
    /**
     * Class map array for autoloading classes
     */
    $classMap = array(
        'Controller\BlogController' => 'Controller/BlogController.php',
        'Db\DbConnection' => 'Db/DbConnection.php',
        'Db\DbFactory' => 'Db/DbFactory.php',
        'Db\DbPdo' => 'Db/DbPdo.php',
        'DbConnection' => 'Db/DbConnection.php',
        'Db\DbConnection' => 'Db/DbConnection.php',
        'Model\PostTable' => 'Model/PostTable.php',
        'Model\Post' => 'Model/Post.php',
        'Model\CommentTable' => 'Model/CommentTable.php',
    	'Model\Comment' => 'Model/Comment.php',
        'Db\DbMysqli' => 'Db/DbMysqli.php',
    );
	
	require_once $classMap[$class];
}
spl_autoload_register('my_autoloader');

$options = require_once 'config/application.config.php';

$blog =  Blog\Controller\BlogController::getInstace($options);
$blog->setProperties();
$blog->process();
$blog->display();
