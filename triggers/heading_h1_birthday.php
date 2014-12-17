<?php
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/init.inc.php';
echo (has_dob() && has_birthday($dob,strtotime($_GET['time']))) ? birthday_title() : home_title();
?>