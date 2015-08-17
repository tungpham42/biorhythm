<?php
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/init_trigger.inc.php';
if (isset($_GET['lang_code'])) {
	include realpath($_SERVER['DOCUMENT_ROOT']).'/templates/fb_root.tpl.php';
	include realpath($_SERVER['DOCUMENT_ROOT']).'/templates/fb_comments.tpl.php';
	include realpath($_SERVER['DOCUMENT_ROOT']).'/templates/g_comments.tpl.php';
}
?>