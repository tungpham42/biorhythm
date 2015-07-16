<?php
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/init_member.inc.php';
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/init_trigger.inc.php';
if (isset($_POST['pid'])) {
	remove_person($_POST['pid']);
}
?>