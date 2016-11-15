<?php $this->load->helper('form'); ?>
<div class='row text-center'>
	<h1>Upload Video</h1>
</div>
<div class='row row-pad'>

	<!-- Video Navigation -->
	<div class='col-sm-2 col-md-2 col-lg-2'>
		<?= $videoNav ?>
	</div>

	<!-- Main Content -->
	<div class='col-sm-8 col-md-8 col-lg-8'>
		<div class='well well-sm'>
			<div class='row full-height'>
				<div class='col-sm-12 col-md-12 col-lg-12'>
					<?= form_open_multipart('forms/uploadVideo'); ?>
					<h5>First, choose your file</h5>
					<input type="file" name="userfile" size="20" />
					<hr>
				</div>
			</div>

			<div class='row'>
				<div class='col-sm-12 col-md-12 col-lg-12'>
					<h5>Second, add a title and a short description of the video, and select your privacy settings</h5>
				</div>
			</div>

			<div class='row'>
				<div class='col-sm-8 col-md-8 col-lg-8'>
					<label>Title</label>
					<br>
					<input type="text" name="title"/>
					<br>

					<label>Description</label>
					<br>
					<textarea name="description" rows="8" cols="50"></textarea>
					<br>
				</div>
					

				<div class='col-sm-3 col-md-3 col-lg-3'>
					<h6>Privacy Settings</h6>
					<div class='well'>
						<label>Public</label>
						<input type="radio" name="permissions" value="public"/>
						<br>

						<label>Private</label>
						<input type="radio" name="permissions" value="private"/>
						<br>

						<label>Unlisted</label>
						<input type="radio" name="permissions" value="unlisted"/>
					</div>
				</div>
			</div>

			

			<div class='row full-height'>
				<div class='col-sm-12 col-md-12 col-lg-12'>
					<hr>
					<h5>Finally, submit your video!</h5>
					<input type="submit" class='btn btn-primary' value="Submit"/>
				</div>
			</div>
		</div>
	</div>

	<!-- Friends Navigation -->
	<div class='col-sm-2 col-md-2 col-lg-2'>
		<?= $friendsNav ?>
	</div>

</div>