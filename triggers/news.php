<?php
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/init_trigger.inc.php';
if (isset($_GET['lang_code'])) {
	load_news_feed(get_zodiac_from_dob($dob,$_GET['lang_code']).' '.date('Y'));
	load_news_feed(get_zodiac_from_dob($dob,$_GET['lang_code']));
	load_news_feed(get_lunar_year($dob,$_GET['lang_code']).' '.date('Y'));
	load_news_feed(get_lunar_year($dob,$_GET['lang_code']));
}
?>