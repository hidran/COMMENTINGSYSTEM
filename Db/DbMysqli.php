<?php
namespace Blog\Db;

use \mysqli;

class DbMysqli  extends mysqli implements DbConnection
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
     * @var string $user mysql user
     */
    protected $user;

    /**
     *
     * @var string $user mysql password
     */
    protected $password;

    /**
     *
     * @var handler $handler Handler returned by mysql connect
     */
    protected $handler;

    /**
     *
     * @var number $port mysql port connection. Defaults 3306
     */
    protected $port = 3306;
    
    /**
     *
     * @var string $socket 
     */
    protected $socket = 3306;
    
    public $adapterName ='mysqli';

    function __construct( array $options)
    {
        $this->host = isset($options['host'])? $options['host'] :'';
        $this->user = isset($options['user'])? $options['user'] :'';
        $this->db = isset($options['db'])? $options['db'] :'';
        $this->password = isset($options['password'])? $options['password'] :'';
        $this->port = isset($options['port'])? $options['port'] :3306;
        $this->socket = isset($options['socket'])? $options['socket'] :null;
       $this->Dbconnect();
    }

    public function Dbconnect()
    {
    	
    	if($this->handler){
    		return $this->handler;
    	}
        try {
            $this->handler = new \mysqli($this->host, $this->user, $this->password, $this->db, $this->port, $this->socket);
            if($this->handler->connect_errno){
            	throw new \Exception($this->handler->connect_error, $this->handler->connect_errno);
            }
            return $this->handler;
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }
    public function execute($statement)
    {
        return $this->handler->exec($statement);
    }
    public function fetch($statement)
    {
        return $this->handler->fetch_array($statement);
    }

    public function bindValue($statement)
    {
        return $this->handler->fetch_array($statement);
    }
    /**
     *
     * @return the $db
     */
    public function getHost()
    {
        return $this->host;
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
     * @return the $port
     */
    public function getPort()
    {
        return $this->port;
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

    /**
     *
     * @param number $port            
     */
    public function setPort($port)
    {
        $this->port = $port;
    }
    public function lastinsertid(){
    	return $this->handler->insert_id;
    }
    public function getErrorInfo(){
    	return $this->handler->error;
    }
}

?>