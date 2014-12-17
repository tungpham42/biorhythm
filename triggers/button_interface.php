<?php
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/init_trigger.inc.php';
$button_id = $_GET['button_id'];
echo $button_interfaces[$button_id][$lang_code];
?>