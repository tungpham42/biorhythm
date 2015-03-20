<?php
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/init.inc.php';
if (isset($_POST['page']) && isset($_POST['keyword'])) {
	echo list_users($_POST['page'],$_POST['keyword']);
}
?>