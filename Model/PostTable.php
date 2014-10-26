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
    public $error = '';
    public $connection;

    /**
     */
    function __construct(DbConnection $conn, $tableName = 'posts')
    {
        $this->connection = $conn;
        $this->conn = $conn->getHandler();
        $this->tableName = $tableName;
        if (!$tableName) {
            $this->tableName = 'posts';
        }
    }

    public function fetchAll()
    {
        $query = "SELECT * FROM " . $this->tableName . ' ORDER BY created DESC';
        $res = $this->conn->query($query);
        $results = array();

        if ($res) {
            $postEntity = new Post();
            foreach ($res as $data) {
                $post = clone $postEntity;
                $post->exchangeArray($data);
                $results[] = $post;
            }
        }
        return $results;
    }

    public function fetch($post_id)
    {
        $query = "SELECT * FROM " . $this->tableName . ' where id=' . (int)$post_id . ' LIMIT 1';
        $res = $this->conn->query($query);
        $postEntity = array();
        if ($res) {
            foreach($res as $data);
           

            if ($data) {
                $postEntity = new Post();
                $postEntity->exchangeArray($data);
            }

        }
        return $postEntity;
    }
   protected function  getRealId($name, $dateCreated, $email){
   	$name = str_replace("'","''", $name);
   	$dateCreated = str_replace("'","''", $dateCreated);
   	$email = str_replace("'","''", $email);
   	$query = "SELECT id FROM " . $this->tableName ;
   	$query .= " where name='$name' and created='$dateCreated' and email='$email' LIMIT 1";
   //	echo $query;
   	$res = $this->conn->query($query);
   	$id = '';
   	if ($res) {
   		foreach ($res as $data);
   		
   		
   		$id= $data['id'];
       }
       return $id;
   }
    public function create(Post $post)
    {
        if (!$this->isValid($post)) {
            $this->error = 'Invalid supplied data';
            return false;
        }
        
        $name = str_replace("'","''",$post->name);
        $email = str_replace("'","''",$post->email);
        $message = str_replace("'","''",$post->message);
        $created = date('Y-m-d H:i:s');
        $post->created = $created;
        $query = 'INSERT INTO ' . $this->tableName . ' ';
        $query .= '(name,email,message,created)';
        $query .= "values ('$name', '$email','$message','$created')";
        $stm = $this->conn->prepare($query);
         
        $res = $stm->execute();
       if($res){
        $post->id = $this->getRealId($post->name, $created, $post->email);
       } else {
       	$this->error = $this->connection->getErrorInfo();
       }
       
        return $res;

    }

    public function isValid(Post $post)
    {
        $res = $post->name && $post->email && $post->message;
        $regex = '/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/';
        $preg = preg_match($regex, $post->email);
       
        $res = $res && $preg;
        return $res;
    }
    public function filterPost(Post &$post)
    {
        $post->name = preg_replace('//','',$post->name); 
    }

    public function getError()
    {
        return $this->error;
    }
}
