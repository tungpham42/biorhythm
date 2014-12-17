<?php
ob_start('ob_gzhandler');
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/database.inc.php';
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/functions.inc.php';
init_timezone();
if (substr($_SERVER['HTTP_HOST'], 0, 4) === 'www.') {
	header("HTTP/1.1 301 Moved Permanently");
	header('Location: http'.(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 's':'').'://' . substr($_SERVER['HTTP_HOST'], 4).$_SERVER['REQUEST_URI']);
	exit;
}
/* Auth */
session_name('NSH');
if (!session_id()) session_start();
if (!isset($_SESSION['loggedin'])) {
	$_SESSION['loggedin'] = null; 
}
$err = array();
if (isset($_POST['login'])) {
	if (!$_POST['username'] || !$_POST['password'])
		$err[] = 'All the fields must be filled in!';
	if (!count($err)) {
		if ($_POST['username'] == credential(0) && check_pass($_POST['password'],credential(1))) {
			$_SESSION['loggedin'] = 1;
			header('location: '.$_SERVER['HTTP_REFERER']);
		} else if ($_POST['username'] != credential(0) || !check_pass($_POST['password'],credential(1))) {
			$err[] = 'Wrong username and/or password!';
		}
	}
}
/* End Auth */
/* Initiate Program */
if (isset($_GET['q']) && $_GET['q'] != '') {
	$h1 = search_title();
	$title = search_title();
	$body_class = 'search';
} else if (!isset($_GET['p']) || $_GET['p'] == 'home') {
	$h1 = home_title();
	$title = home_title();
	if ($embed == 0 && has_dob()) {
		$body_class = 'home has_dob';
	} else if ($embed == 0) {
		$body_class = 'home';
	} else if ($embed == 1) {
		$body_class = 'embed';
	}
} else if ($p == 'login') {
	$h1 = 'Login';
	$title = 'Login';
	$body_class = 'login';
} else if ($p == 'rhythm') {
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1) {
		$h1 = 'List rhythms';
		$title = 'List rhythms';
		$body_class = 'admin rhythm';
	} else {
		$h1 = 'Not authorized';
		$title = 'Not authorized';
		$body_class = 'not-authorized';
	}
} else if ($p == 'rhythm/create') {
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1) {
		$h1 = 'Create rhythm';
		$title = 'Create rhythm';
		$body_class = 'admin rhythm';
	} else {
		$h1 = 'Not authorized';
		$title = 'Not authorized';
		$body_class = 'not-authorized';
	}
} else if ($p == 'rhythm/edit') {
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1) {
		$h1 = 'Edit rhythm';
		$title = 'Edit rhythm';
		$body_class = 'admin rhythm';
	} else {
		$h1 = 'Not authorized';
		$title = 'Not authorized';
		$body_class = 'not-authorized';
	}
} else if ($p == 'rhythm/delete') {
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1) {
		$h1 = 'Delete rhythm';
		$title = 'Delete rhythm';
		$body_class = 'admin rhythm';
	} else {
		$h1 = 'Not authorized';
		$title = 'Not authorized';
		$body_class = 'not-authorized';
	}
} else if ($p == 'user') {
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1) {
		$h1 = 'List users';
		$title = 'List users';
		$body_class = 'admin user';
	} else {
		$h1 = 'Not authorized';
		$title = 'Not authorized';
		$body_class = 'not-authorized';
	}
} else if ($p == 'user/create') {
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1) {
		$h1 = 'Create user';
		$title = 'Create user';
		$body_class = 'admin user';
	} else {
		$h1 = 'Not authorized';
		$title = 'Not authorized';
		$body_class = 'not-authorized';
	}
} else if ($p == 'user/edit') {
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1) {
		$h1 = 'Edit user';
		$title = 'Edit user';
		$body_class = 'admin user';
	} else {
		$h1 = 'Not authorized';
		$title = 'Not authorized';
		$body_class = 'not-authorized';
	}
} else if ($p == 'user/delete') {
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1) {
		$h1 = 'Delete user';
		$title = 'Delete user';
		$body_class = 'admin user';
	} else {
		$h1 = 'Not authorized';
		$title = 'Not authorized';
		$body_class = 'not-authorized';
	}
} else if ($p == 'hash') {
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1) {
		$h1 = 'Hash';
		$title = 'hash';
		$body_class = 'admin hash';
	} else {
		$h1 = 'Not authorized';
		$title = 'Not authorized';
		$body_class = 'not-authorized';
	}
} else if ($p == 'race' || $p == 'race/1') {
	$h1 = 'Đua hộp - Bước 1';
	$title = 'Đua hộp - Bước 1';
	$body_class = 'game race';
} else if ($p == 'race/2') {
	$h1 = 'Đua hộp - Bước 2';
	$title = 'Đua hộp - Bước 2';
	$body_class = 'game race';
} else if ($p == 'race/3') {
	$h1 = 'Đua hộp - Chơi';
	$title = 'Đua hộp - Chơi';
	$body_class = 'game race';
} else if ($p == 'race/single') {
	$h1 = 'Square Race - Single Player';
	$title = 'Square Race - Single Player';
	$body_class = 'game race';
} else if ($p == 'bmi') {
	$h1 = 'Tính BMI';
	$title = 'Tính BMI';
	$body_class = 'bmi';
} else if ($p == 'lunar') {
	$h1 = 'Tính ngày Âm lịch';
	$title = 'Tính ngày Âm lịch';
	$body_class = 'lunar';
} else if ($p == 'pong') {
	$h1 = 'Bóng bàn 3D';
	$title = 'Bóng bàn 3D';
	$body_class = 'game pong';
} else if ($p == 'tictactoe') {
	$h1 = 'Tic tac toe';
	$title = 'Tic tac toe';
	$body_class = 'tictac';
} else if ($p == 'donate') {
	$h1 = 'Ủng hộ Nhịp Sinh Học . VN';
	$title = 'Ủng hộ Nhịp Sinh Học . VN';
	$body_class = 'donate';
} else if ($p == 'sponsor') {
	$h1 = 'Sponsor Nhịp Sinh Học . VN';
	$title = 'Sponsor Nhịp Sinh Học . VN';
	$body_class = 'sponsor';
} else if ($p == 'thank-you') {
	$h1 = 'Thank you for your sponsor';
	$title = 'Thank you for your sponsor';
	$body_class = 'thank-you';
} else if ($p == 'xin-cam-on') {
	$h1 = 'Bạn đã tài trợ 50.000 VNĐ';
	$title = 'Bạn đã tài trợ 50.000 VNĐ';
	$body_class = 'cam-on';
} else {
	$h1 = '404 page not found';
	$title = '404 page not found';
	$body_class = 'not-found';
}
if (has_dob() && date('m-d',strtotime($dob)) == date('m-d')) {
	$h1 = birthday_title();
	$title = birthday_title();
}
$site_name = site_name();
$birthday_wish = birthday_wish();
switch($p) {
	case 'bmi':
		$meta_description = 'Tính chỉ số BMI dựa trên cân nặng và chiều cao của bạn.';
		break;
	case 'lunar':
		$meta_description = 'Chuyển đổi ngày Dương lịch sang ngày Âm lịch.';
		break;
	case 'pong':
		$meta_description = 'Trò chơi bóng bàn 3D hấp dẫn.';
		break;
	default:
		$meta_description = (can_wish() ? birthday_title() : $title).((has_dob()) ? ' - '.$chart->render_meta_description(): '').' - '.head_description();
}
$head_title = (can_wish() ? birthday_title() : $title).' | '.$site_name;
$head_description = can_wish() ? $birthday_wish: $meta_description;