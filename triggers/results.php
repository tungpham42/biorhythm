<?php
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/init_member.inc.php';
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/init_trigger.inc.php';
$chart->render_results();
?>