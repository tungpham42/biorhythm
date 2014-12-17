<?php
session_name('NSH');
session_start();
session_destroy();
header('Location: '.$_SERVER['HTTP_REFERER'].'');
?>
