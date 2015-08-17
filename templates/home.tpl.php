<?php
include template('dob_form');
include template('proverb');
if (isset($_COOKIE['NSH:member'])) {
	include template('clock');
}
if (!has_dob()) {
	include template('help');
}
include template('scripts_top');
if ($show_donate) {
	include template('donate_top');
}
if ($show_sponsor) {
	include template('sponsor_top');
}
if (has_dob()) {
	if (isset($_COOKIE['NSH:member'])) {
		//include template('news');
	}
	include template('results');
} else if (!has_dob()) {
	include template('explanation_chart');
}
include template('keyboard');
include template('explanation');
include template('install_app');
//include template('feed_blog');
echo list_user_same_birthday_links('same-birthday-links');
echo list_user_birthday_links('birthday-links');
echo list_user_links('user-birthdates');
?>