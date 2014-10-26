
<?php 
 if($this->error){ ?>
    <div class="row" id="errorMsg">
    <div class ="col-md-12"><p class="bg-danger"><?=$this->error?></p></div>
    </div> 
 <?php 
 } else {
?>

      
        <div class="row">
            <div class="col-md-3 published_date">
                sent
                <time datetime="<?= $comment->created ?>">
                    <?= $this->formatDate($comment->created) ?>
                </time>
                <br>
                by <a href="mailto:<?= $comment->email ?>"><?= $comment->email ?></a>

            </div>
            <div class="col-md-9">
                <p><?= $comment->comment ?></p>
            </div>
        </div>
   
   <?php 
 }
   ?>

