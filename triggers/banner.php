<?php
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/init_trigger.inc.php';
$partner = (isset($_POST['partner'])) ? $_POST['partner']: 'lazada';
render_ad($partner);
?>