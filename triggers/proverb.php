<?php
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/init_trigger.inc.php';
if (isset($_GET['lang_code'])) {
	render_proverb($_GET['lang_code']);
}
?>