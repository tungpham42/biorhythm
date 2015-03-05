<?php
header('Content-Type: text/javascript');
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/init_trigger.inc.php';
if (isset($_GET['type']) && isset($_GET['dob']) && isset($_GET['diff']) && isset($_GET['dt_change']) && isset($_GET['lang_code'])) {
	switch ($_GET['type']) {
		case 'main':
			$chart->render_main_chart_script();
			break;
		case 'explanation':
			$explanation_chart = new Chart($_GET['dob'],$_GET['diff'],1,$_GET['dt_change'],$_GET['lang_code']);
			$explanation_chart->render_explanation_chart_script();
			break;
		case 'embed':
			$embed_chart = new Chart($_GET['dob'],$_GET['diff'],0,$_GET['dt_change'],$_GET['lang_code']);
			$embed_chart->render_embed_chart_script();
			break;
	}
}
?>