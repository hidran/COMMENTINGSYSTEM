<?php
namespace Blog\Model;

/**
 *
 * @author arias
 *        
 */
class Comment
{

    public $id;

    public $post_id;

    public $comment;

    public $createdDate;

    public $email;

    /**
     */
    function __construct()
    {}

    public function exchangeArray(array $data)
    {
        $this->id = isset($data['id']) ? $data['id'] : null;
        $this->comment = isset($data['comment']) ? $data['comment'] : '';
        $this->created = isset($data['created']) ? $data['created'] : '';
        $this->email = isset($data['email']) ? $data['email'] : '';
        $this->post_id = isset($data['post_id']) ? $data['post_id'] : '';
    }
}

?>