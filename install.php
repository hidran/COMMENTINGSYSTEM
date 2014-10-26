<?php

$config = require_once 'config/application.config.php';

$db = $config['db']['options'];

try{
    if(empty($db['host'])){
        throw new Exception('No host defined in config/application.config.php'.print_r($config,1));
     }
    if(empty($db['db'])){
          throw new Exception('No database defined defined in config/application.config.php'.print_r($config,1));
    }
    
   $res= mysqli_connect($db['host'], $db['user'], $db['password']);
   if($res){
   $selDb= $res->select_db($db['db']);
   if(!$selDb){
       $data = file_get_contents('data/bloggingsystem.sql');
       $script = explode(';',$data);
      // var_dump($script);die;
       foreach ($script as $command){
         $multiRes= $res->query($command);
         if(!$multiRes){
             throw new Exception($res->error);
             break;
         }
       }
     
      if($multiRes){
          header("Location:index.php");
      } else {
          throw new Exception($res->error);
      }
   }
   } else{
       throw new Exception('Wrong db parameters');
   }
} catch (Exception $e){
    die($e->getMessage());
}