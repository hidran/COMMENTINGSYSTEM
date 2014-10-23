<?php
namespace Blog\Model;

use Blog\Db\DbConnection;

/**
 *
 * @author arias
 *        
 */
class PostTable
{
 protected $tableName;
 protected $conn;
 public $error ='';
    /**
     */
    function __construct(DbConnection $conn,$tableName ='posts')
    {
       $this->conn = $conn->getHandler();
       $this->tableName = $tableName;
       if(!$tableName){
           $this->tableName ='posts';
       }
    }
    public function fetchAll()
    {
    	$query = "SELECT * FROM ". $this->tableName.' ORDER BY created DESC';
    	$res = $this->conn->query($query);
    	$results = array();
    	
    	if ($res){
    		$postEntity = new Post();
    		foreach ($res as $data){
    			$post = clone $postEntity;
    			$post->exchangeArray($data);
    			$results[] = $post;
    		}
    	}
    	return $results;
    }
    public function fetch($post_id)
    {
        $query = "SELECT * FROM ". $this->tableName.' where id='.(int)$post_id .' LIMIT 1';
          $res = $this->conn->query($query);
        $postEntity =  array();
        if ($res ){
        	$data = $res->fetch();
        	
            if($data){
            	$postEntity = new Post();
                $postEntity->exchangeArray($data);
              }
            
        }
        return $postEntity;
    }
    public function create(Post $post){
    	if(!$this->isValid($post)){
    		$this->error = 'Invalid supplied data';
    		return false;
    	}
    	$query = 'INSERT INTO '.$this->tableName .' ';
    	$query .= '(name,email,message,created)';
    	$query .= 'values (:name, :email,:message,:created)';
    	  var_dump($this->conn);
    	 $stm = $this->conn->prepare($query);
    	 $stm->bindValue(':name' ,$post->name ,DbConnection::PDOSTR);
    	 $stm->bindValue(':email', $post->email, DbConnection::PDOSTR);
    	 $stm->bindValue(':message', $post->name , DbConnection::PDOSTR);
    	 $stm->bindValue(':created', date('Y-m-d H:i:s') , DbConnection::PDOSTR);
    	 return $stm->execute();
    	 
    }
    public function isValid(Post $post){
    	return $post->name && $post->email && $post->message;
    }
    public function getError(){
        return $this->error;
    }
}

?>