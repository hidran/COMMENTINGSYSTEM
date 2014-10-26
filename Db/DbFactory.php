<?php
namespace Blog\Db;

/**
 *
 * @author arias
 *        
 */
abstract class DbFactory
{

    /**
     */
    public static $options ;
    public static function  getOptions()
    {
        return self::$options;
    }
  

    public static function create(array $options)
    {
        self::$options = $options;
        $defaultOptions = array(
            'adapter' => 'mysqli',
            'options' => array(
                'host' => 'localhost',
                'user' => 'root',
                'password' => '',
                'db' =>'bloggingsystem',
               
                'dsn' => ''
            )
        );
        $options = array_replace_recursive($defaultOptions, $options);
     	if(empty($options['adapter'])) 
        {
            throw new \InvalidArgumentException('No adapter set');
        }
    	if(empty($options['options'])) 
        {
            throw new \InvalidArgumentException('No options set');
        }
        $dbInstance = null;
         switch (strtolower($options['adapter'])){
            case 'mysqli' :
            	$dbInstance = new DbMysqli($options['options']);
            	break;
            case 'pdo' :
            	
            	
            	$dbInstance = new DbPdo($options['options']);
            	
            	break;
            default:
            	throw new \InvalidArgumentException('Unkmown adapater:'.$options['adapter']);
            	
        }
        if(!$dbInstance->getHandler()){
            try {
        	$dbInstance->Dbconnect();
            }catch(\Exception $e) {
                die($e->getMessage());
                
            }
        }
        return $dbInstance;
    }
}

?>