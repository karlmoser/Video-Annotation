<div class='container-fluid'>
	<!-- User Image and Username -->
	<div class='row well well-sm'>
		<div class='col-sm-6 col-md-6 col-lg-6'>
			<div class='well'>
				<img width='128' height='128' src=<?= $user->profile_picture ?> />
				<h2><?= $user->username ?></h2>
			</div>
		</div>
		<div id='following' class='col-sm-6 col-md-6 col-lg-6 pull-right'>
			<div class='well'>
				<button id='unfollowButton' class='btn btn-primary btn-block' onClick="unfollow(<?= $this->session->userdata('id');?>, <?= $user->id ?>)">
				<span id='unfollowText'>Unfollow</span>
				<span id='unfollowIcon'>
					<i class="fa fa-spinner fa-spin"></i>
				</span>
			</button>
			<button id='followButton' class='btn btn-success btn-block' onClick="follow(<?= $this->session->userdata('id');?>, <?= $user->id ?>)">
				<span id='followText'>Follow</span>
				<span id='followIcon'>
					<i class="fa fa-spinner fa-spin"></i>
				</span>
			</button>
			</div>
		</div>
	</div>

	<!-- Public Videos -->
	<div class='row'>
		<div class='col-sm-12 col-md-12 col-lg-12'>
			<h3><?= $user->username ?>'s Public Videos</h3>
			<?php if (count($videos) > 0): ?>
				<div class='row scroll-h'>
					<div class='scroll-h-inner well well-sm'>
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
</div>

<?= $following; ?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#followIcon').hide();
		$('#unfollowIcon').hide();

		if( self ){
			$('#following').hide();
		}

		if( following ){
			//Hide the follow button
			$('#followButton').hide();
		} else {
			//Hide the unfollow button
			$('#unfollowButton').hide();
		}
	});

	follow = function(follower, user) {

		//Make the follow button spin
		$('#followText').hide();
		$('#followIcon').show();

		$.ajax({
			type:"POST",
			url:"/api/follow",
			data: {follower:follower, user:user},
			success: function(){
						setTimeout(function(){
							$('#followText').show();
							$('#followIcon').hide();
							$('#followButton').hide();
							$('#unfollowButton').show();
						}, 1000);
					 }
		});
	}

	unfollow = function(follower, user) {
		//Make the unfollow button spin
		$('#unfollowText').hide();
		$('#unfollowIcon').show();

		$.ajax({
			type:"POST",
			url:"/api/unfollow",
			data: {follower:follower, user:user},
			success: function(){
						setTimeout(function(){
							$('#unfollowText').show();
							$('#unfollowIcon').hide();
							$('#unfollowButton').hide();
							$('#followButton').show();
						}, 1000);
					 }
		});
	}
</script>