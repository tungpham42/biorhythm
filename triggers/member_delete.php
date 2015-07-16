<?php
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/init_member.inc.php';
if (isset($_GET['email'])) {
	delete_member($_GET['email']);
	header('Location: '.$_SERVER['HTTP_REFERER'].'');
}
?>