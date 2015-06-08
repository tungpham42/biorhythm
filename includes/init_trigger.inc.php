<?php
ini_set('session.save_path',realpath($_SERVER['DOCUMENT_ROOT'].'/session'));
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/database.inc.php';
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/functions.inc.php';
init_timezone();