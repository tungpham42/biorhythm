<?php
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/init_trigger.inc.php';
if (isset($_POST['rid'])) {
	$rid = $_POST['rid'];
	$rhythm = load_rhythm($rid);
	if ($rhythm['is_secondary'] == 0) {
		make_rhythm_secondary($rid);
	} else if ($rhythm['is_secondary'] == 1) {
		make_rhythm_primary($rid);
	}
	header('Location: '.$_SERVER['HTTP_REFERER'].'');
}
?>