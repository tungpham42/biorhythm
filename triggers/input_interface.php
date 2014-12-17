<?php
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/init_trigger.inc.php';
$input_id = $_GET['input_id'];
echo $input_interfaces[$input_id][$lang_code];
?>