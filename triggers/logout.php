<?php
ini_set('session.save_path',realpath($_SERVER['DOCUMENT_ROOT'].'/session'));
session_name('NSH');
session_start();
session_destroy();
header('Location: '.$_SERVER['HTTP_REFERER'].'');
?>
