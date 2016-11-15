<h1>Annotations by <?= $user->username; ?></h1>
<?php if (sizeof($annotations) > 0): ?>
	<div class='well well-sm'>
		<div class='row'>
			<div class='col-sm-1 col-md-1 col-lg-1'>
				
			</div>
			<div class='col-sm-3 col-md-3 col-lg-3'>
				<h1>Video</h1>
			</div>
			<div class='col-sm-8 col-md-8 col-lg-8'>
				<h1>Annotation</h1>
			</div>
		</div>
		<?php foreach ($annotations as $annotation): ?>
			<hr>
			<div class='row'>
				<div class='col-sm-1 col-md-1 col-lg-1'>
					<button type="button" class="btn btn-primary" onClick='setAnnotation(<?= $annotation->id ?>);' data-toggle="modal" data-target="#myModal">
					  Share
					</button>
				</div>
				<div class='col-sm-3 col-md-3 col-lg-3'>
					<a href="/videos/single/<?=$annotation->annotation->video->id ?>">
						<?= $annotation->annotation->video->title; ?>
						<img src="<?= $annotation->annotation->video->thumbnail ?>">
					</a>
				</div>
				<div class='col-sm-8 col-md-8 col-lg-8'>
					<?= $annotation->text; ?>
				</div>
			</div>
		<?php endforeach ?>
	</div>
<?php else: ?>
	<div class='well well-sm'>
		It looks like this user doesn't have any annotations yet!
	</div>
<?php endif; ?>

<!-- Share Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Who would you like to share this with?</h4>
      </div>
      <div class="modal-body">
      	<form class='share'>
      		<input class='form-control' placeholder='Enter a username here...'></input>
      	</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onClick='share();'>Share</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	var annotation = null;

	var setAnnotation = function(_annotation){
		annotation = _annotation
	}

	var share = function(){
		var _annotation = annotation;
		var _to = $('input.form-control').val();
		var _from = '<?= $this->session->userdata('username'); ?>';

		$.ajax({
			type:"POST",
			url:"/api/shareAnnotation",
			data: {_text_annotation:_annotation, _to:_to, _from:_from},
			success: function(data){
						alert('Message sent!');
						$('#myModal').modal('hide');
					 }
		});
	}

</script>