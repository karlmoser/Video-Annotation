<div class='row well well-sm'>
	<!-- Iterate over all of the friends to produce a friends list -->
	<?php if (count($following) < 1): ?>
		<div class='text-center col-md-12'>
			You're not following anyone!
		</div>
	<?php else: ?>
		<?php foreach ($following as $followed): ?>
			<div class='text-center col-md-12'>
				<a href="/users/profile/<?= $followed->username; ?>">
					<img class='profile-picture' src=<?= $followed->profile_picture ?> />
					<div class='profile-username'><?= $followed->username; ?></div>
				</a>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>