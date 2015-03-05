<?php
header('Content-Type: application/json');
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/init.inc.php';
if (isset($_GET['term'])) {
	$users = search_array('nsh_users','name',$_GET['term']);
	$usernames = array_column($users,'name');
	$response = json_encode($usernames);
	echo $response;
}
?>