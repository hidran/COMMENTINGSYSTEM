<?php
namespace Blog\Db;

use \PDO, \PDOException;


class DbPdo extends PDO implements DbConnection
{

    /**
     *
     * @var string $host mysql IP e.g localhost
     */
    protected $host;

    /**
     *
     * @var string $db Database name
     */
    protected $db;

    /**
     *
     * @var string $user  user
     */
    protected $user;

    /**
     *
     * @var string $user  password
     */
    protected $password;

    /**
     *
     * @var handler $handler 
     */
    protected $handler;

    /**
     *
     * @var handler $dsn
     */
    protected $dsn;
    /**
     *
     * @var array $options PDO options
     */
    protected $options =  array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    ); 
    
    
    /**
     *
     * @var string $driver
     */
    protected $driver = 'mysqli';
    public $adapterName = 'pdo';
function __construct(array $options)
{
    $this->driver = isset($options['driver']) ? $options['driver'] : 'mysqli';
    
    $this->dsn = !empty($options['dsn']) ? $options['dsn'] : '';
    $this->host = !empty($options['host']) ? $options['host'] : '';
    $this->user = !empty($options['user']) ? $options['user'] : '';
    $this->db = !empty($options['db']) ? $options['db'] : '';
    
    $this->password = !empty($options['password']) ? $options['password'] : '';
     if( isset($options['options']) && is_array($options['options'])){
         $this->options = $options['options'] ;
     }
    if (empty($this->dsn) && $this->db && $this->host) {
         $this->dsn = $this->driver . ':dbname=' . $this->db . ';host=' . $this->host;
    }
    //die('dsn' .$this->dsn.$this->user .''. $this->password);
    if ($this->dsn) {
      $this->handler = $this->Dbconnect();
      
    }
   
}
    

    public function Dbconnect()
    {
    	
    	if($this->handler){
    		return $this->handler;
    	}
    	
        try {
             $this->handler = new PDO($this->dsn, $this->user, $this->password, $this->options);
            return $this->handler;
          } catch (PDOException $e) {
            die($e->getMessage());
        }
       
    }
    
    public function execute($statement)
    {
    	return $this->handler->exec($statement);
    }
    
    public function query($query)
    {  
        return $this->handler->query($query);
    }
    /**
     *
     * @return the $db
     */
    public function getDsn()
    {
        return $this->dsn;
    }

    /**
     *
     * @return the $db
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     *
     * @return the $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     *
     * @return the $password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     *
     * sets PDO $driver
     */
    public function setDriver($driver)
    {
         $this->driver = $driver;
    }
    
    /**
     *
     * @return the $driver
     */
    public function getDriver()
    {
        return $this->driver;
    }
    /**
     *
     * @return the $driver instance
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     *
     * @param string $db            
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     *
     * @param string $db            
     */
    public function setDb($db)
    {
        $this->db = $db;
    }

    /**
     *
     * @param string $user            
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     *
     * @param string $password            
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
public function getErrorInfo(){
	
	$error = $this->handler->errorInfo();
	if(isset($error[2])){
		return $error[2];
	}
	return false;
}
   
}

?>