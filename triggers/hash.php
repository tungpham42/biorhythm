<?php
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/init_trigger.inc.php';
if (isset($_POST['unhashed'])) {
	echo hash_pass($_POST['unhashed']);
}
?>