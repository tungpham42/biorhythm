<?php
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