<?php
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/init.inc.php';
if (isset($_GET['1111']) && $_GET['1111'] == '2222') {
	email_daily_suggestion();
	echo 'success';
} else {
	echo 'wrong';
}
?>