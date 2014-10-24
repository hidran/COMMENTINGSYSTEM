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
    public $error = '';

    /**
     */
    function __construct(DbConnection $conn, $tableName = 'postcomments')
    {
        $this->conn = $conn->getHandler();
        $this->tableName = $tableName;
        if (!$tableName) {
            $this->tableName = 'postcomments';
        }
    }

    public function fetchAll()
    {
        $query = "SELECT * FROM " . $this->tableName;
        $res = $this->conn->getHandler()->query($query);
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

    public function getPostComments($post_id)
    {
        $query = "SELECT * FROM  {$this->tableName} where post_id=" . (int)$post_id . ' ORDER BY created desc';
        $res = $this->conn->query($query);
        $results = array();

        if ($res) {
            $commentEntity = new Comment();
            foreach ($res as $data) {
                $comment = clone $commentEntity;
                $comment->exchangeArray($data);
                $results[] = $comment;
            }
        }
        return $results;
    }

    public function create(Comment $commentObj)
    {
        if (!$this->isValid($commentObj)) {
            $this->error = 'Invalid supplied data';
            return false;
        }
        $post_id =(int)$commentObj->post_id;
        $comment= str_replace("'","''",$commentObj->comment);
        $email =  str_replace("'","''",$commentObj->email);
        $created = date('Y-m-d H:i:s');
        $query = 'INSERT INTO ' . $this->tableName . ' ';
        $query .= '(post_id,comment,email,created)';
        $query .= "values ($post_id, '$comment', '$email','$created')";
echo $query;
        $stm = $this->conn->prepare($query);
        return $stm->execute();
       


    }

    public function getError()
    {
        return $this->error;
    }

    public function isValid(Comment $comment)
    {
        $res= $comment->comment && $comment->email;
        $regex = "/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/";
        $res = $res && preg_match($regex, $comment->email);
        
    }

}
