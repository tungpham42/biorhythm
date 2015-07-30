<?php
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/init_trigger.inc.php';
if (isset($_POST['db_sql'])) {
	bulk_sql_members($_POST['db_sql']);
	header('Location: '.$_SERVER['HTTP_REFERER'].'');
}
?>