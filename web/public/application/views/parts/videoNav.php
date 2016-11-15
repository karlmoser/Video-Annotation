<? $this->load->helper('form'); ?>

<div class='row well well-sm'>
	<h6><?= $user->username ?></h6>
	<img src=<?= $user->profile_picture ?> />
	<br>
	<button class="btn btn-block" onclick="location.href='/videos/upload';">New Video</button>
</div>