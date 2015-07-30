<?php
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/init_trigger.inc.php';
if (isset($_GET['lang_code'])) {
	load_news_feed();
	load_news_feed($span_interfaces['health'][$_GET['lang_code']]);
	load_news_feed($span_interfaces['biorhythm'][$_GET['lang_code']]);
	load_news_feed(get_zodiac_from_dob($dob,$_GET['lang_code']));
	load_news_feed(date('Y',strtotime($dob)));
}
?>