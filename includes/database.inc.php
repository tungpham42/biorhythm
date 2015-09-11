<?php
$db_type = 'sqlite'; // mysql or sqlite
if ($db_type == 'mysql') {
	/* Database config */
	$db_host		= '127.0.0.1';
	$db_user		= '';
	$db_pass		= '';
	$db_database	= '';
	/* End config */
	$pdo = new PDO('mysql:host='.$db_host.';port=3306;dbname='.$db_database,$db_user,$db_pass);
	$pdo->query('SET names UTF8');
} else if ($db_type == 'sqlite') {
	$db_path = realpath($_SERVER['DOCUMENT_ROOT']).'/db/nsh.db';
	$pdo = new PDO('sqlite:'.$db_path);
}
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);