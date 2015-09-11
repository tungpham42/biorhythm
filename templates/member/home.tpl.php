<?php
if ((isset($_COOKIE['NSH:member']) && $_COOKIE['NSH:member'] == get_member_email()) || $_SESSION['loggedin'] == 1) {
	if (person_exists()) {
		include template('scripts_top');
		include template('member/person_dob_form');
	} else {
		include template('member/avatar');
		include template('scripts_top');
		include template('member/profile_form');
		include template('member/dob_form');
	}
	include template('proverb');
	include template('time');
	if (has_dob()) {
		//include template('news');
		include template('results');
	}
	include template('keyboard');
	echo list_persons();
	include template('explanation');
	include template('feed_blog');
	include template('feed_forum');
	include template('install_app');
	include template('comments');
	echo list_user_same_birthday_links('same-birthday-links');
	echo list_user_birthday_links('birthday-links');
	echo list_user_links('user-birthdates');
} else {
	header('Location: http'.(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 's':'').'://nhipsinhhoc.vn/member/login/');
}
?>