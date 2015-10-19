<?php
function libraries_autoload($class_name) {
	require realpath($_SERVER['DOCUMENT_ROOT']).'/includes/libraries/'.$class_name.'.class.php';
}
function google_api_php_client_autoload($class_name) {
	$class_path = explode('_', $class_name);
	if ($class_path[0] != 'Google') {
		return;
	}
	if (count($class_path) > 3) {
		// Maximum class file path depth in this project is 3.
		$class_path = array_slice($class_path, 0, 3);
	}
	$file_path = realpath($_SERVER['DOCUMENT_ROOT']).'/includes/' . implode('/', $class_path) . '.php';
	if (file_exists($file_path)) {
		require_once($file_path);
	}
}
spl_autoload_register('libraries_autoload');
spl_autoload_register('google_api_php_client_autoload');
function is_public_server() {
	if (substr($_SERVER['REMOTE_ADDR'],0,7) == '108.162' || substr($_SERVER['REMOTE_ADDR'],0,7) == '173.245' || substr($_SERVER['REMOTE_ADDR'],0,6) == '66.220' || substr($_SERVER['REMOTE_ADDR'],0,7) == '173.252' || substr($_SERVER['REMOTE_ADDR'],0,5) == '31.13' || substr($_SERVER['REMOTE_ADDR'],0,10) == '64.233.172' || substr($_SERVER['REMOTE_ADDR'],0,6) == '69.171' || substr($_SERVER['REMOTE_ADDR'],0,6) == '66.102' || substr($_SERVER['REMOTE_ADDR'],0,9) == '66.249.83' || substr($_SERVER['REMOTE_ADDR'],0,6) == '66.249') {
		return true;
	} else {
		return false;
	}
}
function is_bot() {
	if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/bot|crawl|slurp|spider/i', $_SERVER['HTTP_USER_AGENT'])) {
		return true;
	} else {
		return false;
	}
}
function prevent_xss($query_string) {
	return htmlentities($query_string, ENT_QUOTES, 'UTF-8');
}
function init_timezone() {
	global $geoip_record;
	if (is_public_server() || is_bot() || !isset($geoip_record)) {
		date_default_timezone_set('Asia/Ho_Chi_Minh');
	} else if (!is_public_server() && !is_bot() && isset($geoip_record)) {
		$timezone = get_time_zone($geoip_record->country_code,$geoip_record->region);
		date_default_timezone_set($timezone);
	}
}
function init_lang_code() {
	global $geoip_record;
	global $lang_codes;
	global $one_lang;
	$lang_code = 'vi';
	$country_code = isset($geoip_record) ? $geoip_record->country_code: 'VN';
	$country_codes = array(
		'vi' => array('VN'),
		'en' => array('UK', 'US'),
		'ru' => array('RU', 'AM', 'AZ', 'BY', 'KZ', 'KG', 'MD', 'TJ', 'UZ', 'TM', 'UA'),
		'es' => array('ES', 'CO', 'PE', 'VE', 'EC', 'GT', 'CU', 'BO', 'HN', 'PY', 'SV', 'CR', 'PA', 'GQ', 'MX', 'AR', 'CL', 'DO', 'NI', 'UY', 'PR'),
		'zh' => array('CN', 'HK', 'MO', 'TW', 'SG'),
		'ja' => array('JP')
	);
	if (isset($one_lang)) {
		setcookie('NSH:lang', $one_lang, time()+(10*365*24*60*60), '/'.$one_lang.'/');
		$lang_code = $one_lang;
	}
	if (!isset($_COOKIE['NSH:lang'])) {
		if (in_array($country_code, $country_codes['vi']) || is_public_server() || is_bot()) {
			setcookie('NSH:lang', 'vi', time()+(10*365*24*60*60), '/');
			$lang_code = 'vi';
		} else if (in_array($country_code, $country_codes['en'])) {
			setcookie('NSH:lang', 'en', time()+(10*365*24*60*60), '/');
			$lang_code = 'en';
		} else if (in_array($country_code, $country_codes['ru'])) {
			setcookie('NSH:lang', 'ru', time()+(10*365*24*60*60), '/');
			$lang_code = 'ru';
		} else if (in_array($country_code, $country_codes['es'])) {
			setcookie('NSH:lang', 'es', time()+(10*365*24*60*60), '/');
			$lang_code = 'es';
		} else if (in_array($country_code, $country_codes['zh'])) {
			setcookie('NSH:lang', 'zh', time()+(10*365*24*60*60), '/');
			$lang_code = 'zh';
		} else if (in_array($country_code, $country_codes['ja'])) {
			setcookie('NSH:lang', 'ja', time()+(10*365*24*60*60), '/');
			$lang_code = 'ja';
		}
	} else if (isset($_COOKIE['NSH:lang'])) {
		$lang_code = $_COOKIE['NSH:lang'];
	}
	$lang_code = (isset($one_lang)) ? $one_lang: ((isset($_GET['lang']) && in_array($_GET['lang'], $lang_codes)) ? prevent_xss($_GET['lang']): $lang_code);
	return $lang_code;
}
function get_timezone() {
	global $geoip_record;
	$timezone = get_time_zone($geoip_record->country_code,$geoip_record->region);
	return $timezone;
}
function get_timezone_offset($remote_tz, $origin_tz = 'UTC') {
	$origin_dtz = new DateTimeZone($origin_tz);
	$remote_dtz = new DateTimeZone($remote_tz);
	$origin_dt = new DateTime('now', $origin_dtz);
	$remote_dt = new DateTime('now', $remote_dtz);
	$offset = $remote_dtz->getOffset($remote_dt) - $origin_dtz->getOffset($origin_dt);
	return $offset/3600;
}
function digitval($number) {
	$sum = 0;
	while ($number > 0) {
	    $rem = $number % 10;
	    $number = $number / 10;
	    $sum = $sum + $rem;
	}
	if (strlen($sum) >= 2)
		$res = digitval($sum);
	elseif ($sum == 11 || $sum == 22)
		$res = $sum;
	else
		$res = $sum;
	return $res;
}
function calculate_life_path($dob) {
	$life_path_number = 0;
	$year = date('Y',strtotime($dob));
	$month = date('m',strtotime($dob));
	$day = date('d',strtotime($dob));
	$life_path_number = digitval(digitval($year) + digitval($month) + digitval($day));
	return $life_path_number;
}
function has_one_lang() {
	global $hide_lang_bar;
	global $hide_nav;
	if ($hide_lang_bar == true && $hide_nav == true) {
		return true;
	} else {
		return false;
	}
}