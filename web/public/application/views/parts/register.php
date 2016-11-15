<?php $this->load->helper('form'); ?>
<div class='row vertical-center'>
	<div class='col-md-4 col-centered well well-lg'>
		<?= form_open('forms/register'); ?>

		<div class='form-line'>
			<?= form_label('E-Mail: ', 'email'); ?>
			<?= form_input('email', ''); ?>
		</div>

		<div class='form-line'>
			<?= form_label('Username: ', 'username'); ?>
			<?= form_input('username', ''); ?>
		</div>
		
		<div class='form-line'>
			<?= form_label('Password: ', 'password'); ?>
			<?= form_password('password', ''); ?>
		</div>

		<div class='form-line'>
			<?= form_label('Repeat Password: ', 'password2'); ?>
			<?= form_password('password2', ''); ?>
		</div>

		<input type="submit" class='btn btn-block btn-primary' name='register' value="Register"></input>
	</div>
</div>