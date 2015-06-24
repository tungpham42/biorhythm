<div id="bottom">
<?php
if (!isset($_GET['p']) && $embed == 0 || in_array($p, $navs)):
	if ($p != 'home'):
		include template('install_app');
	endif;
	if (!is_birthday()):
		if ($show_ad):
?>
	<div id="bottom_banner">
<?php
			include template('banner_728x90');
			include template('banner_300x250');
?>
	</div>
<?php
		endif;
		if ($show_donate):
			include template('donate_bottom');
		endif;
		if ($show_sponsor):
			include template('sponsor_bottom');
		endif;
	endif;
	include template('comments');
endif;
?>
</div>