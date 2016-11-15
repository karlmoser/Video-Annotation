<div>
	<video id="videoPlayer" controls="true" style="max-width: 100%; margin: 0 auto;"></video>
</div>
<script src="http://192.168.33.10/js/dashjs/dist/dash.all.js"></script>
<script>
(function(){
	var url = "http://e8mk2e7v154v5.elementalclouddemo.com/out/i/3.mpd";
	var context = new Dash.di.DashContext();
	var player = new MediaPlayer(context);
	player.startup();
	player.attachView(document.querySelector("#videoPlayer"));
	player.attachSource(url);
})();
</script>
