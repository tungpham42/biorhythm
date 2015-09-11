<?php
/* Member Manipulation */
function get_member_email() {
	$email = '';
	$url = $_SERVER['REQUEST_URI'];
	$pattern = '/\/member\/(.*)\/.*/';
	preg_match($pattern, $url, $matches);
	if (isset($matches[1])) {
		if (filter_var($matches[1], FILTER_VALIDATE_EMAIL)) {
			$email = $matches[1];
		}
	} else {
		$url = $_SERVER['HTTP_REFERER'];
		preg_match($pattern, $url, $matches);
		if (isset($matches[1])) {
			if (filter_var($matches[1], FILTER_VALIDATE_EMAIL)) {
				$email = $matches[1];
			}
		}
	}
	return $email;
}
function create_member($email,$fullname,$password,$dob,$lang) {
	$hashed_password = hash_pass($password);
	$created_time = date('Y-m-d h:i:s A');
	$edited_time = 'Not edited yet';
	$path = realpath($_SERVER['DOCUMENT_ROOT']).'/member/'.$email;
	$index_path = $path.'/index.php';
	$db_path = $path.'/member.db';
	$index_content =
"<?php\r
\$_GET['p'] = 'member/home';\r
require_once realpath(\$_SERVER['DOCUMENT_ROOT']).'/includes/init_member.inc.php';\r
\$_GET['dob'] = get_member_dob();\r
\$_GET['fullname'] = get_member_fullname();\r
if (isset(\$_GET['pid']) && load_person(\$_GET['pid']) == null) {\r
	header('Location: http'.(isset(\$_SERVER['HTTPS']) && \$_SERVER['HTTPS']=='on' ? 's':'').'://nhipsinhhoc.vn/member/'.get_member_email().'/');\r
}\r
require_once realpath(\$_SERVER['DOCUMENT_ROOT']).'/index.php';\r
?>";
	$db_create_member_sql =
'CREATE TABLE IF NOT EXISTS member (
	email TEXT PRIMARY KEY,
	password TEXT NOT NULL,
	fullname TEXT NOT NULL,
	dob TEXT NOT NULL,
	lang TEXT NOT NULL,
	created_at TEXT NOT NULL,
	edited_at TEXT NOT NULL
);';
	$db_create_persons_sql =
'CREATE TABLE IF NOT EXISTS persons (
	pid INTEGER PRIMARY KEY AUTOINCREMENT,
	fullname TEXT NOT NULL,
	dob TEXT NOT NULL
);';
	$db_insert_sql = 'INSERT INTO member (email,password,fullname,dob,lang,created_at,edited_at) VALUES (:email,:password,:fullname,:dob,:lang,:created_at,:edited_at)';
	mkdir($path, 0777);
	if (!$handle = fopen($index_path, 'wb')) {
		echo 'Cannot open index file ('.$index_path.')';
		exit;
	}
	if (fwrite($handle, $index_content) === false) {
		echo 'Cannot write to index file ('.$index_path.')';
		exit;
	}
	fclose($handle);
	try {
		$db = new PDO('sqlite:'.$db_path);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$db_create_member_query = $db->prepare($db_create_member_sql);
		$db_create_member_query->execute();
		$db_create_persons_query = $db->prepare($db_create_persons_sql);
		$db_create_persons_query->execute();
		$db_insert_query = $db->prepare($db_insert_sql);
		$db_insert_query->bindParam(':email', $email);
		$db_insert_query->bindParam(':password', $hashed_password);
		$db_insert_query->bindParam(':fullname', $fullname);
		$db_insert_query->bindParam(':dob', $dob);
		$db_insert_query->bindParam(':lang', $lang);
		$db_insert_query->bindParam(':created_at', $created_time);
		$db_insert_query->bindParam(':edited_at', $edited_time);
		$db_insert_query->execute();
	} catch (PDOException $e) {
		echo 'ERROR: '.$e->getMessage();
	}
}
function edit_member($email,$fullname,$password,$dob,$lang) {
	$hashed_password = ($password == load_member()['password']) ? $password: hash_pass($password);
	$edited_time = date('Y-m-d h:i:s A');
	$path = realpath($_SERVER['DOCUMENT_ROOT']).'/member/'.$email;
	$db_path = $path.'/member.db';
	$db_sql = 'UPDATE member SET password=:password,fullname=:fullname,dob=:dob,lang=:lang,edited_at=:edited_at WHERE email=:email';
	try {
		$db = new PDO('sqlite:'.$db_path);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$db_query = $db->prepare($db_sql);
		$db_query->bindParam(':password', $hashed_password);
		$db_query->bindParam(':fullname', $fullname);
		$db_query->bindParam(':dob', $dob);
		$db_query->bindParam(':lang', $lang);
		$db_query->bindParam(':edited_at', $edited_time);
		$db_query->bindParam(':email', $email);
		$db_query->execute();
	} catch (PDOException $e) {
		echo 'ERROR: '.$e->getMessage();
	}	
}
function delete_path($path) {
	if (is_dir($path) === true) {
		$files = array_diff(scandir($path), array('.', '..'));
		foreach ($files as $file) {
			delete_path(realpath($path).'/'.$file);
		}
		return rmdir($path);
	} else if (is_file($path) === true) {
		return unlink($path);
	}
	return false;
}
function delete_member($email) {
	if (isset($email) && $email != '') {
		$path = realpath($_SERVER['DOCUMENT_ROOT']).'/member/'.$email;
		delete_path($path);
	}
}
function load_member() {
	$array = array();
	$email = get_member_email();
	if ($email != '') {
		$path = realpath($_SERVER['DOCUMENT_ROOT']).'/member/'.$email;
		$db_path = $path.'/member.db';
		$db_sql = 'SELECT * FROM "member"';
		try {
			$db = new PDO('sqlite:'.$db_path);
			$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			$db_query = $db->prepare($db_sql);
			$db_query->execute();
			if ($db_query) {
				while($row = $db_query->fetch(PDO::FETCH_ASSOC)) {
					$array = $row;
				}
			}
		} catch (PDOException $e) {
			echo 'ERROR: '.$e->getMessage();
		}
		return $array;
	} else {
		return null;
	}
}
function create_person($fullname,$dob) {
	$email = get_member_email();
	$path = realpath($_SERVER['DOCUMENT_ROOT']).'/member/'.$email;
	$db_path = $path.'/member.db';
	$db_sql = 'INSERT INTO persons (fullname,dob) VALUES (:fullname,:dob)';
	try {
		$db = new PDO('sqlite:'.$db_path);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$db_query = $db->prepare($db_sql);
		$db_query->bindParam(':fullname', $fullname);
		$db_query->bindParam(':dob', $dob);
		$db_query->execute();
		$last_id = $db->lastInsertId();
		echo $last_id;
	} catch (PDOException $e) {
		echo 'ERROR: '.$e->getMessage();
	}
}
function edit_person($pid,$fullname,$dob) {
	$email = get_member_email();
	$path = realpath($_SERVER['DOCUMENT_ROOT']).'/member/'.$email;
	$db_path = $path.'/member.db';
	$db_sql = 'UPDATE persons SET fullname=:fullname,dob=:dob WHERE pid=:pid';
	try {
		$db = new PDO('sqlite:'.$db_path);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$db_query = $db->prepare($db_sql);
		$db_query->bindParam(':fullname', $fullname);
		$db_query->bindParam(':dob', $dob);
		$db_query->bindParam(':pid', $pid);
		$db_query->execute();
	} catch (PDOException $e) {
		echo 'ERROR: '.$e->getMessage();
	}	
}
function remove_person($pid) {
	$email = get_member_email();
	$path = realpath($_SERVER['DOCUMENT_ROOT']).'/member/'.$email;
	$db_path = $path.'/member.db';
	$db_sql = 'DELETE FROM persons WHERE pid=:pid';
	try {
		$db = new PDO('sqlite:'.$db_path);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$db_query = $db->prepare($db_sql);
		$db_query->bindParam(':pid', $pid);
		$db_query->execute();
	} catch (PDOException $e) {
		echo 'ERROR: '.$e->getMessage();
	}	
}
function load_persons() {
	$array = array();
	$email = get_member_email();
	$path = realpath($_SERVER['DOCUMENT_ROOT']).'/member/'.$email;
	$db_path = $path.'/member.db';
	$db_sql = 'SELECT * FROM persons';
	try {
		$db = new PDO('sqlite:'.$db_path);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$db_query = $db->prepare($db_sql);
		$db_query->execute();
		if ($db_query) {
			while($row = $db_query->fetch(PDO::FETCH_ASSOC)) {
				$array[] = $row;
			}
		}
	} catch (PDOException $e) {
		echo 'ERROR: '.$e->getMessage();
	}
	return $array;
}
function load_person($pid) {
	$array = array();
	$email = get_member_email();
	$path = realpath($_SERVER['DOCUMENT_ROOT']).'/member/'.$email;
	$db_path = $path.'/member.db';
	$db_sql = 'SELECT * FROM persons WHERE pid=:pid';
	try {
		$db = new PDO('sqlite:'.$db_path);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$db_query = $db->prepare($db_sql);
		$db_query->bindParam(':pid', $pid);
		$db_query->execute();
		if ($db_query) {
			while($row = $db_query->fetch(PDO::FETCH_ASSOC)) {
				$array = $row;
			}
		}
	} catch (PDOException $e) {
		echo 'ERROR: '.$e->getMessage();
	}
	return isset($array) ? $array : null;
}
function person_exists() {
	if (isset($_GET['pid']) && load_person($_GET['pid']) !== null) {
		return true;
	} else {
		return false;
	}
}
function get_member_fullname() {
	$member = load_member();
	return person_exists() ? load_person($_GET['pid'])['fullname'] : ((!person_exists() && isset($member)) ? $member['fullname']: '');
}
function get_member_dob() {
	$member = load_member();
	return person_exists() ? load_person($_GET['pid'])['dob'] : ((!person_exists() && isset($member)) ? $member['dob']: '');
}
function list_person_links() {
	global $lang_code;
	global $span_interfaces;
	$output = '';
	$email = get_member_email();
	$persons = load_persons();
	usort($persons,'sort_fullname_ascend');
	$output .= '<li><a id="my_birthdate" class="m-btn" href="/member/'.$email.'/"><span>'.translate_span('me').' - '.load_member()['dob'].'</span></a></li>';
	$count = count($persons);
	for ($i = 0; $i < $count; ++$i) {
		$output .= '<li><a title="'.$persons[$i]['fullname'].'" class="m-btn" href="/member/'.$email.'/?pid='.$persons[$i]['pid'].'"><span>'.$persons[$i]['fullname'].' - '.$persons[$i]['dob'].'</span></a></li>';
	}
	return $output;
}
function list_persons() {
	global $lang_code;
	global $span_interfaces;
	$output = '';
	$email = get_member_email();
	$persons = load_persons();
	usort($persons,'sort_fullname_ascend');
	$output .= '<div class="dates-box">';
	$output .= '<h2 id="persons_list_h2" class="dates-header">'.translate_span('list_persons').'</h2>';
	$output .= '<ul class="dates" id="persons_list">';
	$output .= list_person_links();
	$output .= '</ul>';
	$output .= '<div class="clear"></div>';
	$output .= '</div>';
	return $output;
}
/**
 * Get either a Gravatar URL or complete image tag for a specified email address.
 *
 * @param string $email The email address
 * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
 * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
 * @param boole $img True to return a complete IMG tag False for just the URL
 * @param array $atts Optional, additional key/value attributes to include in the IMG tag
 * @return String containing either just a URL or a complete image tag
 * @source http://gravatar.com/site/implement/images/php/
 */
function get_gravatar($email, $s = 270, $d = '404', $r = 'g', $img = false, $atts = array()) {
	$url = 'http://www.gravatar.com/avatar/';
	$url .= md5(strtolower(trim($email)));
	$url .= "?s=$s&d=$d&r=$r";
	if ($img) {
		$url = '<img src="'.$url.'"';
		foreach ($atts as $key => $val) {
			$url .= ' '.$key.'="'.$val.'"';
		}
		$url .= ' />';
	}
	return $url;
}
function get_http_response_code($url) {
	$headers = get_headers($url);
	return substr($headers[0], 9, 3);
}