	<div id="airlock">
		<video id="vid1" class="video-js vjs-default-skin vjs-big-play-centered" controls preload="none" width="640" height="264"
		data-setup=''>
			<source src="http://clips.vorwaerts-gmbh.de/big_buck_bunny.mp4" type='video/mp4' />
			<track kind="captions" src="demo.captions.vtt" srclang="en" label="English"></track><!-- Tracks need an ending tag thanks to IE9 -->
		</video>
    </div>

    <script type="text/javascript">
    	var options ={
		    optionsAnnotator: {
		        user: {},
		        store: {}
		    },
		    optionsVideoJS: {},
		    optionsRS: {},
		    optionsOVA: {
		        posBigNew: 'ul'
		    },
		}, mplayer=videojs("vid1");

		//OVA handles the rangeslider set-up as well.
    	var ova = new OpenVideoAnnotation.Annotator($('#airlock'), options);
    </script>

</script>