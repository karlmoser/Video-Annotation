<div class='row row-pad'>
	<div class='col-sm-2 col-md-2 col-lg-2 text-center'>
		<h5>Quick Menu</h5>
	</div>
	<div class='col-sm-8 col-md-8 col-lg-8 text-center'>
		<h5>Videos</h5>
	</div>		
	<div class='col-sm-2 col-md-2 col-lg-2 text-center'>
		<h5>Following</h5>
	</div>
</div>
<div class='row row-pad'>
	<div class='col-sm-2 col-md-2 col-lg-2'>
		<?= $videoNav ?>
	</div>
	<div class='col-sm-8 col-md-8 col-lg-8'>
		<div class='row well row-pad'>
			<?php if (count($videos) > 0): ?>
				<div class='row scroll-h'>
					<div class='scroll-h-inner row-pad'>
						<?php foreach ($videos as $video): ?>
							<span class='vid-thumb-container'>
								<a href="/videos/single/<?= $video->id ?>">
									<h4><?= $video->title; ?></h4>
									<img class='vid-thumb' src=<?= $video->thumbnail ?>>
								</a>
							</span>
						<?php endforeach; ?>
					</div>
				</div>
			<?php else: ?>
				<div class='well well-sm'>
					It looks like this user has no videos yet!
				</div>
			<?php endif; ?>
		</div>
	</div>		
	<div class='col-sm-2 col-md-2 col-lg-2'>
		<?= $friendsNav ?>
	</div>
</div>