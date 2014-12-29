<?php
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/init_trigger.inc.php';
if (isset($_GET['dob']) && isset($_GET['diff']) && isset($_GET['dt_change']) && isset($_GET['lang_code'])) {
	$embed_chart = new Chart($_GET['dob'],$_GET['diff'],0,$_GET['dt_change'],$_GET['lang_code']);
	$embed_chart->render_embed_chart();
}
?>