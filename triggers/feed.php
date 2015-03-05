<?php
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/init_trigger.inc.php';
if (isset($_GET['url'])) {
	load_rss_feed($_GET['url']);
}
?>