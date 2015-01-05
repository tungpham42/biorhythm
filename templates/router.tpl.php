<?php
include $template_path.'scripts_top.tpl.php';
if (isset($_GET['q']) && $_GET['q'] != '') {
	include $template_path.'search_results.tpl.php';
} else if (!isset($_GET['p']) || $_GET['p'] == 'home') {
	if ($embed == 0 && !isset($hide_lang_bar)) {
		include $template_path.'lang_bar.tpl.php';
		include $template_path.'home.tpl.php';
	} else if (isset($hide_lang_bar)) {
		include $template_path.'home.tpl.php';
	} else if ($embed == 1) {
		include $template_path.'embed.tpl.php';
	}
} else if ($p == 'login') {
	include $template_path.'login-page.tpl.php';
} else if ($p == 'rhythm') {
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1) {
		include $template_path.'admin/rhythm/index.tpl.php';
	} else {
		echo 'You are not authorized';
	}
} else if ($p == 'rhythm/create') {
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1) {
		include $template_path.'admin/rhythm/create.tpl.php';
	} else {
		echo 'You are not authorized';
	}
} else if ($p == 'rhythm/edit') {
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1) {
		include $template_path.'admin/rhythm/edit.tpl.php';
	} else {
		echo 'You are not authorized';
	}
} else if ($p == 'rhythm/delete') {
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1) {
		include $template_path.'admin/rhythm/delete.tpl.php';
	} else {
		echo 'You are not authorized';
	}
} else if ($p == 'user') {
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1) {
		include $template_path.'admin/user/index.tpl.php';
	} else {
		echo 'You are not authorized';
	}
} else if ($p == 'user/create') {
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1) {
		include $template_path.'admin/user/create.tpl.php';
	} else {
		echo 'You are not authorized';
	}
} else if ($p == 'user/edit') {
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1) {
		include $template_path.'admin/user/edit.tpl.php';
	} else {
		echo 'You are not authorized';
	}
} else if ($p == 'user/delete') {
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1) {
		include $template_path.'admin/user/delete.tpl.php';
	} else {
		echo 'You are not authorized';
	}
} else if ($p == 'hash') {
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1) {
		include $template_path.'admin/hash/index.tpl.php';
	} else {
		echo 'You are not authorized';
	}
} else if ($p == 'race' || $p == 'race/1') {
	include $template_path.'race/step1.tpl.php';
} else if ($p == 'race/2') {
	include $template_path.'race/step2.tpl.php';
} else if ($p == 'race/3') {
	include $template_path.'race/step3.tpl.php';
} else if ($p == 'race/single') {
	include $template_path.'race/single.tpl.php';
} else if ($p == 'bmi') {
	include $template_path.'bmi.tpl.php';
} else if ($p == 'lunar') {
	include $template_path.'lunar.tpl.php';
} else if ($p == 'pong') {
	include $template_path.'pong.tpl.php';
} else if ($p == 'tictactoe') {
	include $basepath.'/tic-tac-toe/play.php';
} else if ($p == 'donate') {
	include $template_path.'donate.tpl.php';
} else if ($p == 'sponsor') {
	include $template_path.'sponsor.tpl.php';
} else if ($p == 'thank-you') {
	include $template_path.'thank_you.tpl.php';
} else if ($p == 'xin-cam-on') {
	include $template_path.'cam_on.tpl.php';
} else {
	echo 'Page not found';
}
if (!isset($_GET['p']) && $embed == 0 || in_array($p, $navs)) {
	if (!is_birthday() && $show_ad) {
		include $template_path.'bottom.tpl.php';
	}
}
?>