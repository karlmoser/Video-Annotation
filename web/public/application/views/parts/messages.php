<h1>Messages</h1>
<?php if (sizeof($messages) > 0): ?>
	<div class='well well-sm'>
		<div class='row'>
			<div class='col-sm-2 col-md-2 col-lg-2'>
				<h3>From</h3>
			</div>
			<div class='col-sm-3 col-md-3 col-lg-3'>
				<h3>Video</h3>
			</div>
			<div class='col-sm-7 col-md-7 col-lg-7'>
				<h3>Annotation</h3>
			</div>
		</div>
		<?php foreach ($messages as $message): ?>
			<hr>
			<div class='row'>
				<div class='col-sm-2 col-md-2 col-lg-2'>
					<a href="/users/profile/<?=$message->sender->username;?>">
						<?= $message->sender->username; ?><br>
						<img height='100' src="<?= $message->sender->profile_picture; ?>">
					</a>
				</div>
				<div class='col-sm-3 col-md-3 col-lg-3'>
					<a href="/videos/single/<?=$message->annotation->annotation->video->id?>">
					<?= $message->annotation->annotation->video->title; ?><br>
						<img height='100' src="<?= $message->annotation->annotation->video->thumbnail; ?>">
					</a>
				</div>
				<div class='col-sm-7 col-md-7 col-lg-7'>
					<?= $message->annotation->text; ?>
				</div>
			</div>
		<?php endforeach ?>
	</div>
<?php else: ?>
	<div class='well well-sm'>
		It looks like you don't have any messages yet!
	</div>
<?php endif; ?>