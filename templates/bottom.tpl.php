<div id="bottom">
<?php
if (!isset($_GET['p']) && $embed == 0 || in_array($p, $navs)):
	if ($p != 'home' && $p != 'member/home'):
		include template('install_app');
		include template('comments');
	endif;
	if (!is_birthday()):
		if ($show_donate):
			include template('donate_bottom');
		endif;
		if ($show_sponsor):
			include template('sponsor_bottom');
		endif;
	endif;
endif;
?>
</div>