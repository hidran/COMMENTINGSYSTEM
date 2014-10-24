<?php
namespace Blog\Controller;

use Blog\Db\DbFactory;
use Blog\Model\PostTable;
use Blog\Model\CommentTable;
use Blog\Model\Post;
use Blog\Model\Comment;

/**
 *
 * @author arias
 *
 */
class BlogController
{

    public $post_id;

    public $comment_id;

    public $name;

    public $email;

    public $message;
    public $error;

    public $comment;

    private $tpl;

    private $connection;

    public $action;

    public $isAjax = null;

    private static $instance = null;

    public $postTable;

    public $commentTable;

    public $content;

    public $headerTitle;
    public $timeZone = 'Europe/Paris';
    public $dateFormt = 'd/M/Y H:i';
    private $token;

    protected $allowedActions = array();
    protected $antiSpamQuestions = array();
    protected $question;
    public $answer;
    
    public $allowedTags = array();
    protected $applicationConfig = array();
    public $hideForm = 1;
    public $showComments = 0;

    /**
     */
    function __construct(array $options = array())
    {
    	if(!empty($options['allowedTags'])){
    		$this->allowedTags = $options['allowedTags'];
    	}
       	if(!empty($options['antiSpamQuestions'])){
    		$this->antiSpamQuestions = $options['antiSpamQuestions'];
    	}
    	//var_dump($this->antiSpamQuestions);
    	if(!empty($options['allowedActions'])){
    		$this->allowedActions = $options['allowedActions'];
    	} else {
    		throw new \InvalidArgumentException('No actions defined!');
    	}
    //	var_dump($options['db']);
    	 
       	if(empty($options['db'])){
    	
    		throw new \InvalidArgumentException('No db connection defined!');
    	}
    	 
    	$this->tpl = 'View/index.tpl.php';
        $this->connection = DbFactory::create($options['db']);

        $this->action = 'index';
        $this->headerTitle = 'COMMENTING SYSTEM';
        $this->postTable = new PostTable($this->connection);
        $this->commentTable = new CommentTable($this->connection);
    }

    public static function getInstace(array $options)
    {
        if (self::$instance == null) {
            $c = __CLASS__;
            self::$instance = new $c($options);
        }
        return self::$instance;
    }

    public function process()
    {
        if (in_array($this->action, $this->allowedActions) && method_exists($this, $this->action)) {
            return $this->{$this->action}();
        } else {
            die($this->action . ' not allowed');
        }
        $this->index();
    }

    public function setProperties()
    {
        $data = array_merge($_GET, $_POST);
        foreach ($data as $key => $val) {

            if (property_exists($this, $key)) {
                $this->{$key} = $val;
            }
        }
    }

    public function index()
    {
        $this->token = $this->generateToken();
        $_SESSION['token'] = $this->token;
       
         $this->generateRamdomQuestion();
        
        $this->posts = $this->postTable->fetchAll();
        $this->content = require_once 'View/newPost.tpl.php';
        $this->content .= require_once 'View/posts.tpl.php';
        $this->tpl = $this->tpl = 'View/index.tpl.php';
    }

    public function getPosts()
    {
        return $this->postTable->fetchAll();
    }

    public function getPost()
    {
        $this->postTable->get($this->post_id);
        $this->index();
    }

    public function showPost()
    {
        $this->token = $this->generateToken();
        $_SESSION['token'] = $this->token;
        $this->generateRamdomQuestion();
        $post = $this->postTable->fetch($this->post_id);
        $this->post = $post;
        $this->headerTitle = $post->name;
        $this->post->comments = array();
        if ($post) {
            $this->post->comments = $this->commentTable->getPostComments($this->post_id);
        }
        $this->content = require_once 'View/post.tpl.php';
        $this->tpl = $this->tpl = 'View/index.tpl.php';

    }

    public function savePost()
    {
        if (empty($_POST['token']) || ($_POST['token'] != $_SESSION['token'])) {
            die('<p class="bg-danger">Invalid token!</p>');
        }
        if (empty($_POST['answer']) || ($_POST['answer'] != $_SESSION['currentQuestion']['answer'])) {
        	die('<p class="bg-danger">Wrong answer!</p>');
        }
        $post = new Post();
        $post->exchangeArray($_POST);
        $post->comments = array();
       // var_dump($post);
        $res = $this->postTable->create($post);
     //   var_dump($post);
        if ($res) {
            $message = 'Post successfully created';
        } else {
            $message = 'Error creating posts';
        }
        if ($this->isAjax) {
            $this->post = $post;
             echo  require_once 'View/post.tpl.php';
         
        } else {
            header("Location:?message=" . urldecode($message));
        }
        exit();
    }

    public function saveComment()
    {
        if (empty($_POST['token']) || ($_POST['token'] != $_SESSION['token'])) {
            die('<p class="bg-danger">Invalid token!</p>');
        }
        if (empty($_POST['answer']) || ($_POST['answer'] != $_SESSION['currentQuestion']['answer'])) {
        	die('<p class="bg-danger">Wrong answer!</p>');
        }
        
        $comment = new Comment();
        $comment->exchangeArray($_POST);
        $res = $this->commentTable->create($comment);
        if ($res) {
            $message = 'Comment added';
        } else {
            $this->error = $this->commentTable->getError();
        }
        if ($this->isAjax) {
            ob_start();
            require_once 'View/comment.tpl.php';
            $output = ob_get_contents();
            ob_end_clean();
            echo $output;
        } else {
            $url = "?post_id={$this->post_id}&action=showPost&error=" . urldecode($this->error);
            $url .= '&message=' . urldecode($this->message);
            header("Location:$url");

        }
        exit;
    }

    public function newPost()
    {
        $this->token = $this->generateToken();
        $_SESSION['token'] = $this->token;
         $this->generateRamdomQuestion();
        $this->content = require_once 'View/newPost.tpl.php';
        $this->content = str_replace('style="display: none"','', $this->content);


    }

    public function getPostComments()
    {
        return $this->commentTable->getComments($this->post_id);
    }

    public function displayAjax()
    {
      echo  $this->content;
    }

    public function display()
    {
        if ($this->isAjax) {
            $this->displayAjax();
            exit;
        }
        if ($this->tpl) {
            require_once $this->tpl;
        }
    }

    public function formatDate($date)
    {
        $dt = new \DateTime($date, new \DateTimeZone($this->timeZone));
        return $dt->format($this->dateFormt);
    }

    protected function generateToken()
    {
        return md5(time());
    }

    public function filterPostData()
    {
        $tags = implode('', $this->allowedTags);
        if (isset($_POST)) {
            if (isset($_POST['name'])) {
                $_POST['name'] = strip_tags($_POST['name']);
            }
            if (isset($_POST['message'])) {
                $_POST['message'] = strip_tags($_POST['message'], $tags);
                $_POST['message'];
            }
            if (isset($_POST['name'])) {
                $_POST['comment'] = strip_tags($_POST['comment'], $tags);
            }
        }

    }
   protected function generateRamdomQuestion(){
   	$id = mt_rand(0,count($this->antiSpamQuestions)-1);
   	$this->question = $this->antiSpamQuestions[$id];
   	$_SESSION['currentQuestion'] = $this->question;
   	
   }
}

?>