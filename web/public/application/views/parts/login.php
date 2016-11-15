<?php $this->load->helper('form'); ?>
<div class='row vertical-center'>
	<div class='col-xs-10 col-sm-8 col-md-6 col-lg-4 col-centered text-center'>
		<p>Please Login to use this service.</p>
		<div class="well well-lg">
			<?= form_open('forms/login'); ?>
				<div class='form-line'>
					<?= form_label('Username: ', 'username'); ?>
					<?= form_input('username', ''); ?>
				</div>
				
				<div class='form-line'>
					<?= form_label('Password: ', 'password'); ?>
					<?= form_password('password', ''); ?>
				</div>

				<input type="submit" class='btn btn-block btn-primary' name='submit' value="Login"></input>
			</form>
			
			<?
			//TODO: Implement this feature when e-mail works
			/*
			<div class='form-button'>
				<?= form_submit('forgot', 'Forgot Username/Password'); ?>
			</div>
			*/
			?>

			<form action="/admin/register">
				<input type="submit" class="btn btn-block" value="Register">
			</form>
		</div>
	</div>
</div>