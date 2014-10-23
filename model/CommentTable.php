<?php
namespace Blog\Model;

use Blog\Db\DbConnection;

/**
 *
 * @author arias
 *        
 */
class CommentTable
{
 protected $tableName;
 protected $conn;
 public $error ='';
    /**
     */
    function __construct(DbConnection $conn,$tableName ='postcomments')
    {
       $this->conn = $conn;
       $this->tableName = $tableName;
       if(!$tableName){
           $this->tableName ='postcomments';
       }
    }
    public function fetchAll()
    {
    	$query = "SELECT * FROM ". $this->tableName;
    	$res = $this->conn->getHandler()->query($query);
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
    public function getPostComments($post_id)
    {
        $query = "SELECT * FROM  {$this->tableName} where post_id=" .(int)$post_id .' ORDER BY created desc';
        $res = $this->conn->getHandler()->query($query);
        $results = array();
         
        if ($res){
            $commentEntity = new Comment();
            foreach ($res as $data){
                $comment = clone $commentEntity;
                $comment->exchangeArray($data);
                $results[] = $comment;
            }
        }
        return $results;
    }
    public function create(Comment $comment){
    	if(!$this->isValid($comment)){
    		$this->error = 'Invalid supplied data';
    		return false;
    	}
        $query = 'INSERT INTO '.$this->tableName .' ';
        $query .= '(post_id,comment,email,created)';
        $query .= 'values (:post_id, :comment, :email,:created)';
        
       // var_dump($comment);die;
        $stm = $this->conn->getHandler()->prepare($query);
        $stm->bindValue(':comment' ,$comment->comment ,DbConnection::PDOSTR);
        $stm->bindValue(':email', $comment->email, DbConnection::PDOSTR);
        $stm->bindValue(':post_id', $comment->post_id , DbConnection::PDOINT);
        $stm->bindValue(':created', date('Y-m-d H:i:s') , DbConnection::PDOSTR);
        $res = $stm->execute();
        var_dump($res);
        if($res!== false){
        	return true;
        } else{
        	$error = $stm->errorInfo();
        	$this->error =$error[2];
        	return false;
        }
       
    
    }
    public function getError(){
    	return $this->error;
    }
    public function isValid(Comment $comment){
        return $comment->comment && $comment->email;
    }
    
}

?>