<?php
ini_set('session.save_path','tcp://localhost:6379');
session_name('NSH');
session_start();
session_destroy();
header('Location: '.$_SERVER['HTTP_REFERER'].'');
?>
