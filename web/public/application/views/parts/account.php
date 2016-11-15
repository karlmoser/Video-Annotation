<?php $this->load->helper('form'); ?>
<div class='row'>
	<div class='col-sm-1 col-md-1 col-lg-1'></div>
		<div class='col-sm-10 col-md-10 col-lg-10 center-block'>
			<h1>My Account</h1>
		</div>
	<div class='col-sm-1 col-md-1 col-lg-1'></div>
</div>

<div class='row'>
	<div class='col-sm-1 col-md-1 col-lg-1'></div>
		<div class='col-sm-10 col-md-10 col-lg-10 center-block'>
			<div class='row well well-lg'>
				<div class='col-sm-3 col-md-3 col-lg-3'>
					<img src=<?= $user->profile_picture ?> />
					<h3> <?= $user->username; ?> </h3>
				</div>

				<div class='col-sm-9 col-md-9 col-lg-9 text-right'>
					<h2>Change Password</h2>
					<?= form_open( 'forms/changePassword' ); ?>

					<div>
					<?= form_label( 'Old Password: ', 'old_password' ); ?>
					<?= form_password( 'old_password', '' ); ?>
					</div>

					<div>
					<?= form_label( 'New Password: ', 'new_password' ); ?>
					<?= form_password( 'new_password', '' ); ?>
					</div>

					<div>
						<?= form_label( 'Repeat Password: ', 'new_password2' ); ?>
						<?= form_password( 'new_password2', '' ); ?>
					</div>

					<div>
						<?= form_submit( 'change_password', 'Change Password', array('class' => 'btn btn-primary') ); ?>
					</div>

					</form>
				</div>
			</div>

			<div class='row well'>
				<h2>Upload New Profile Picture</h2>

				<?= form_open_multipart( 'forms/setProfilePicture' ); ?>
					<div class='form-line'>
						<input type="file" name="userfile" size="20" class='btn btn-block' />
					</div>
					
					<div class='form-line'>
						<input type="submit" value="Upload Picture" class='btn btn-primary btn-block'/>
					</div>
				</form>
			</div>
		</div>
	<div class='col-sm-1 col-md-1 col-lg-1'></div>
</div>