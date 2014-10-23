<?php
ob_start();
/*
 * @var Blog\Model\Post $post
 */
if ($this->posts) {  ?>

<div class="row">
    <div class="col-md-12"  id="posts">
    

<?php 
    foreach ($this->posts as $post) { ?>
   <article id="<?= $post->id?>">
		<header>
		<div class="row">
			<div class="col-md-12 text-left">
			    <h1><a href="?action=showPost&amp&post_id=<?=$post->id?>"><?= $post->name?></a></h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-11 published_date">
				Published <time datetime="<?= $post->created?>">
				    <?= $this->formatDate($post->created)?>
                </time>
			
			by <a mailto="<?= $post->email?>"><?= $post->email?></a>
				  
               
			</div>
		</div>
		</header>
		<section>
		<div class="row">
			<div class="col-md-12"><p><?= $post->message?></p></div>
			</div>
		</section>
	</article>
<?php
    }
    ?>
    </div>
</div>
<?php 
}
$content = ob_get_contents();
ob_end_clean();
return $content;
?>