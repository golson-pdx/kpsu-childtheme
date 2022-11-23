<?php /* Template Name: PlayerPopout */ ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js
									<?php
										// Class scheme_xxx need in the <html> as context for the <body>!
										echo ' scheme_' . esc_attr( rareradio_get_theme_option( 'color_scheme' ) );
									?>
										">
<head>
	<?php wp_head(); ?>
	<link href="https://kpsu.org/rareradio/wp-content/themes/rareradio-child/fontawesome/css/all.css" rel="stylesheet">
    <script defer src="https://kpsu.org/rareradio/wp-content/themes/rareradio-child/fontawesome/js/all.js"></script> <!--load all styles -->
</head>

<body scroll="no" class="body-radio-player">
<div class="player-header">
<img src="https://kpsu.org/rareradio/wp-content/uploads/2021/10/kpsufallsticker21-5-1.png" alt="KPSU Logo" class="player-header-logo"/>
<h1>KPSU Radio Player</h1>
</div>

<div class="popoutradiowrapper">
<div class="radioplayer" data-src="https://streamer.radio.co/scad0cc067/listen" data-autoplay="false" data-playbutton="true" data-volumeslider="true" data-elapsedtime="true" data-nowplaying="true" data-showplayer="true"></div>
	</div>
</body>

<footer>
	
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="https://public.radio.co/playerapi/jquery.radiocoplayer.min.js"></script>
<script>
	//jQuery(document).ready(function($) {
		//jQuery('ul.tabs').tabs();
	//});
    
	//initialise the plugin with the element
	var player = $('.radioplayer').radiocoPlayer();

	player.event('audioPlay', function(event){ 
		var volumeLevel = $('.radioco-volume').val();
		player.volume(volumeLevel);
		console.log("Now playing at volume level " + volumeLevel + " out of 100");
	});


</script>
</footer>