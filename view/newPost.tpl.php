<?php
ob_start ();
?>
<div class="row" id="newPostAnchor"></div>
<form role="form" class="form-horizontal" id="newPost"
	<?=$this->hideForm?'style="display: none"':''?> action="?"
	method="post" onsubmit="this.style.display='none';return(submitData(this,'posts'))">
	<div class="form-group">
		<label for="email" class="col-md-2 control-label">Email address</label>
		<div class="col-md-10">
			<input class="form-control" type="email" name="email" required
				class="form-control" id="email" placeholder="Enter email">
		</div>
	</div>
	<div class="form-group">
		<label for="name" class="col-md-2 control-label">Title</label>
		<div class="col-md-10">
			<input class="form-control" type="text" required maxlength="254"
				class="form-control" id="name" name="name" placeholder="post title">
		</div>
	</div>
	<div class="form-group">
		<label for="message" class="col-md-2 control-label">Message</label>
		<div class="col-md-10">
			<textarea class="form-control" required id="message" name="message"
				rows="2" class="field col-md-12"></textarea>
		</div>
	</div>
	<div class="form-group">
		<label for="message" class="col-md-2 control-label">Prove you are
			human</label>
		<div class="col-md-10">
			<div class="row">
				<div class="col-md-6">
					<input class="form-control" disabled type="text"
						value="<?=$this->question['question']?>" size="16">
				</div>
				<div class="col-md-6">
					<input class="form-control" type="text" required maxlength="2"
						class="form-control" size="2" id="answer" name="answer"
						placeholder="Insert result">

				</div>
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-2"></div>
		<div class="col-md-5  text-center">
			<button type="reset" class="btn btn-default btn-lg">Reset</button>
		</div>
		<div class="col-md-5  text-center">
			<button type="submit" class="btn btn-primary btn-lg">Submit</button>
			<input type="hidden" name="action" value="savePost"> <input
				type="hidden" name="isAjax" id="isAjax" value="0"> <input
				type="hidden" name="token" value="<?=$this->token?>">
		</div>

	</div>
	<div class="form-group">
		<p class="text-info"> Allowed tags : <?=htmlentities(implode(',',$this->allowedTags))?>
	
	
	</div>
</form>


<?php
$content = ob_get_contents ();
ob_end_clean ();
return $content;
?>