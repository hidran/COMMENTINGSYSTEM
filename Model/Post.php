<?php
namespace Blog\Model;

/**
 *
 * @author arias
 *
 */
class Post
{
    public $id;
    public $name;
    public $email;
    public $message;
    public $created;

    /**
     */
    function __construct()
    {
    }

    public function exchangeArray(array $data)
    {
        $this->id = isset($data['id']) ? $data['id'] : null;
        $this->name = isset($data['name']) ? $data['name'] : '';
        $this->email = isset($data['email']) ? $data['email'] : '';
        $this->message = isset($data['message']) ? $data['message'] : '';
        $this->created = isset($data['created']) ? $data['created'] : '';
    }
}
