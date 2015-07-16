<?php
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/init_member.inc.php';
ini_set('session.save_path',realpath($_SERVER['DOCUMENT_ROOT'].'/session'));
setcookie('NSH:member',get_member_email(),1,'/');
header('Location: '.$_SERVER['HTTP_REFERER'].'');
?>
