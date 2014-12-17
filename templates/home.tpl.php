<?php
include $template_path.'dob_form.tpl.php';
if ($show_donate) {
	include $template_path.'donate_top.tpl.php';
}
if ($show_sponsor) {
	include $template_path.'sponsor_top.tpl.php';
}
if (has_dob()) {
	include $template_path.'proverb.tpl.php';
	//include $template_path.'video.tpl.php';
	include $template_path.'results.tpl.php';
}
if (!has_dob()) {
	include $template_path.'explanation_chart.tpl.php';
}
include $template_path.'explanation.tpl.php';
echo list_user_same_birthday_links('same-birthday-links');
echo list_user_birthday_links('birthday-links');
echo list_user_links('dobs');
if (!is_birthday() && $show_ad) {
	include $template_path.'banner_728x90.tpl.php';
	include $template_path.'banner_300x250.tpl.php';
}
if ($show_donate) {
	include $template_path.'donate_bottom.tpl.php';
}
if ($show_sponsor) {
	include $template_path.'sponsor_bottom.tpl.php';
}
include $template_path.'install_app.tpl.php';
?>