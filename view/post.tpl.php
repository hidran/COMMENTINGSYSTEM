<?php
ob_start();
/*
 * @var Blog\Model\Post $post
 */
if ($this->post) {
    $newComment = require_once 'View/newComment.tpl.php';
  
    ?>


    <article id="<?= $this->post->id ?>" xmlns="http://www.w3.org/1999/html">
        <header>
            <div class="row">
                <div class="col-md-12 text-left">
                    <h1><a href="?action=showPost&amp&post_id=<?= $this->post->id ?>"><?= $this->post->name ?></a></h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-offset-1 col-md-11 published_date">
                    Published
                    <time datetime="<?= $this->post->created ?>">
                        <?= $this->formatDate($this->post->created) ?>
                    </time>

                    by <a mailto="<?= $this->post->email ?>"><?= $this->post->email ?></a>


                </div>
            </div>
        </header>
        <section>
            <div class="row">
                <div class="col-md-12">
                    <p><?= $this->post->message ?></p>
                </div>
            </div>


        </section>
        <br>

        <div class="row">
            <div class="col-md-10 col-md-offset-2">

                <div class="row" >
                    <div class="col-md-12" id="comments">
                <?php
                if (!$this->isAjax) {
                    echo '<h3>COMMENTS</h3>';
                    echo  $newComment ;
                }
                if (!$this->isAjax && $this->post->comments) {
                    ?>
                  

                        <?php
                        foreach ($this->post->comments as $comment) {
                              
                            echo '<hr>';
                            require 'View/comment.tpl.php';
                         
                            } 
                        ?>
                   
                <?php
                }
                ?>
                    </div>
                </div>
            </div>
        </div>
    </article>


<?php
} else {
    echo "<div class='row'><div class='col-md-12'>No records found</div></div>";
}
$content = ob_get_contents();
ob_end_clean();
return $content;
?>