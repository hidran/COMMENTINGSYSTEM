


      
        <div class="row">
            <div class="col-md-3 published_date">
                sent
                <time datetime="<?= $comment->created ?>">
                    <?= $this->formatDate($comment->created) ?>
                </time>
                <br>
                by <a mailto="<?= $comment->email ?>"><?= $comment->email ?></a>

            </div>
            <div class="col-md-9">
                <p><?= $comment->comment ?></p>
            </div>
        </div>
   

