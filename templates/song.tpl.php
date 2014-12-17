<audio id="happy_birthday_song">
	<source src="/happy-birthday-songs/<?php echo $lang_code; ?>.mp3" type="audio/mpeg">
	Your browser does not support the audio element.
</audio>
<script>
$(document).ready(function(){
	if ($('body').hasClass('birthday')) {
		$('audio#happy_birthday_song').attr('controls','controls').attr('autoplay','autoplay');
	} else if (!$('body').hasClass('birthday')) {
		$('audio#happy_birthday_song').removeAttr('controls').removeAttr('autoplay');
	}
});
</script>