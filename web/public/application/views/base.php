<!DOCTYPE html>
<html>
<head>
	<title><?= $title ?></title>

	<!-- JQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

	<!-- jQuery UI -->
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

	<!-- Latest compiled and minified Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Latest bootstrap.js -->
	<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

	<!-- Font Awesome CDN -->
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="/css/default.css">

	<!-- Video JS -->
	<link href="/js/videojs/video-js.css" rel="stylesheet">
	<script src="/js/videojs/combined.video.js"></script>
	<script>
	  videojs.options.flash.swf = "/js/videojs/video-js.swf"
	</script>

	<!-- Rangeslider Plugin -->
	<script type="text/javascript" src="/js/rangeslider.min.js"></script>
	<link rel="stylesheet" type="text/css" href="/css/rangeslider.min.css">

	<!-- VideoJS Overlay Plugin -->
	<script type="text/javascript" src="/js/videojs-overlay.js"></script>
	<link href="/css/videojs-overlay.css" rel='stylesheet'>
</head>
<body>
	<div class='container-fluid banner'>
		<?= $banner ?>
	</div>

	<div class='container-fluid content'>
		<?= $content ?>
	</div>
</body>
</html>