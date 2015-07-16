<?php
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/init_member.inc.php';
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/init_trigger.inc.php';
if (isset($_POST['pid']) && isset($_POST['fullname']) && isset($_POST['dob'])) {
	edit_person($_POST['pid'],$_POST['fullname'],$_POST['dob']);
}
?>