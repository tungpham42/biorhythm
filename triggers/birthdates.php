<?php
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/init_trigger.inc.php';
echo isset($_GET['keyword']) ? list_ajax_user_links('dobs',$_GET['keyword']): list_ajax_user_links('dobs');
?>