<div class='row'>
	<div class='col-md-2 pull-left'>
		<?= $friendsNav ?>
	</div>

	<div class='col-md-7 center-block'>

		<h2>Videos</h2>
		<div class='row well well-lg'>
			<h3>New Videos</h3>
			<div class='row scroll-h'>
				<div class='scroll-h-inner well well-sm'>
					<?php foreach ($videos as $video): ?>
						<span class='vid-thumb-container'>
							<h4><?= $video->title; ?></h4>
							<img class='vid-thumb' src=<?= $video->thumbnail ?>>
						</span>
					<?php endforeach; ?>
				</div>
			</div>
			
			<h3>Popular Videos</h3>
			<div class='row scroll-h'>
				<div class='scroll-h-inner well well-sm'>
					<?php foreach ($videos as $video): ?>
						<span class='vid-thumb-container'>
							<h4><?= $video->title; ?></h4>
							<img class='vid-thumb' src=<?= $video->thumbnail ?>>
						</span>
					<?php endforeach; ?>
				</div>
			</div>

		</div>

	</div>		

	<div class='col-md-3 pull-right'>
		<?= $videoNav ?>
	</div>
</div>