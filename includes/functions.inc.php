<?php
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/variables.inc.php';

/* General Functions */
function load_all_array($table_name) { //Put all table records into an array
	global $pdo;
	$array = array();
	$result = $pdo->prepare('SELECT * FROM "'.$table_name.'"');
	$result->execute();
	if ($result) {
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$array[] = $row;
		}
	}
	return $array;
}
function load_array_with_operator($table_name,$identifier,$value,$operator) { //Put specific table records according to condition into an array
	global $pdo;
	$array = array();
	$result = $pdo->prepare('SELECT * FROM "'.$table_name.'" WHERE '.$identifier.$operator.':value');
	$result->execute(array(':value' => $value));
	if ($result) {
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$array[] = $row;
		}
	}
	return $array;
}
function load_array_with_two_identifiers($table_name,$identifier1,$value1,$identifier2,$value2) { //Load array from database with 2 identifiers
	global $pdo;
	$array = array();	
	$result = $pdo->prepare('SELECT * FROM "'.$table_name.'" WHERE '.$identifier1.'=:value1 AND '.$identifier2.'=:value2');
	$result->execute(array(':value1' => $value1, ':value2' => $value2));
	if ($result) {
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$array[] = $row;
		}
	}
	return $array;
}
function load_array_with_two_values($table_name,$identifier,$value1,$value2) { //Load array from database with 1 identifier and 2 values
	global $pdo;
	$array = array();	
	$result = $pdo->prepare('SELECT * FROM "'.$table_name.'" WHERE '.$identifier.'=:value1 OR '.$identifier.'=:value2');
	$result->execute(array(':value1' => $value1, ':value2' => $value2));
	if ($result) {
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$array[] = $row;
		}
	}
	return $array;
}
function load_array($table_name,$identifier,$value) { //Load array from database with 1 identifier and 1 value
	$array = load_array_with_operator($table_name,$identifier,$value,'=');
	return $array;
}
function search_array($table_name,$identifier,$value) {
	global $pdo;
	$array = array();
	$result = $pdo->prepare('SELECT * FROM "'.$table_name.'" WHERE '.$identifier.' LIKE :value');
	$result->execute(array(':value' => "%$value%"));
	if ($result) {
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$array[] = $row;
		}
	}
	return $array;
}
function insert_record($array = array(), $table_name) { //Insert table record
	global $pdo;
	$keys = array_keys($array);
	$values = array_values($array);
	$execute_array = array();
	$count = count($array);
	$query = '';
	$query .= 'INSERT INTO "'.$table_name.'"(';
	for ($k = 0; $k < $count; ++$k) {
		$query .= $keys[$k].(($k < ($count - 1)) ? ',': '');
	}
	$query .= ') VALUES(';
	for ($i = 0; $i < $count; ++$i) {
		$query .= '?'.(($i < ($count - 1)) ? ',': '');
	}
	$query .= ')';
	for ($e = 0; $e < $count; ++$e) {
		$execute_array[$e] = $values[$e];
	}
	$result = $pdo->prepare($query);
	$result->execute($execute_array);
}
function update_record_with_operator($array = array(), $identifier, $value, $table_name, $operator) { //Update table record
	global $pdo;
	$keys = array_keys($array);
	$values = array_values($array);
	$execute_array = array();
	$count = count($array);
	$query = '';
	$query .= 'UPDATE "'.$table_name.'" SET ';
	for ($i = 0; $i < $count; ++$i) {
		$query .= $keys[$i].'=?'.(($i < ($count - 1)) ? ',': '');
	}
	$query .= ' WHERE '.$identifier.$operator.'?';
	for ($e = 0; $e < $count; ++$e) {
		$execute_array[$e] = $values[$e];
	}
	$execute_array[$count] = $value;
	$result = $pdo->prepare($query);
	$result->execute($execute_array);
}
function update_record($array = array(), $identifier, $value, $table_name) { //Update table record
	update_record_with_operator($array, $identifier, $value, $table_name, '=');
}
function delete_record($identifier, $value, $table_name) { //Delete table records with 1 identifier
	global $pdo;
	$result = $pdo->prepare('DELETE FROM "'.$table_name.'" WHERE '.$identifier.'=:value');
	$result->execute(array(':value' => $value));
}
function delete_record_with_two_identifier($identifier1, $value1, $identifier2, $value2, $table_name) { //Delete table records with 2 identifiers
	global $pdo;
	$result = $pdo->prepare('DELETE FROM "'.$table_name.'" WHERE '.$identifier1.'=:value1 AND '.$identifier2.'=:value2');
	$result->execute(array(':value1' => $value1, ':value2' => $value2));
}
function table_row_class($id) { //Identify the table row class based on counter
	$output = '';
	if ((($id+1) % 2) == 1) {
		$output .= ' odd';
	} else {
		$output .= ' even';
	}
	return $output;
}
function pluralize($count, $singular, $plural = false)
{
	if (!$plural) $plural = $singular . 's';
	return (($count == 0 || $count == 1) ? $singular : $plural) ;
}
function substr_word($str,$start,$end) { //Substract words from content
	$end_pos = strpos($str,' ',$end);
	if ($pos !== false) {
		return substr($str,$start,$end_pos);
	}
}
function load_user($uid) { //Load user array from user ID
	$users = load_array('nsh_users','uid',$uid);
	sort($users);
	return $users[0];
}
function load_user_from_name($name) { //Load user array from username
	$users = load_array('nsh_users','name',$name);
	sort($users);
	return $users[0];
}
function load_rhythm($rid) { //Load rhythm array from rhythm ID
	$rhythms = load_array('nsh_rhythms','rid',$rid);
	sort($rhythms);
	return $rhythms[0];
}
function load_credential($id) { //Load credential array from ID
	$credentials = load_array('nsh_@dm!n','id',$id);
	sort($credentials);
	return $credentials[0];
}
function get_rhythm_title($rid,$lang) {
	$rhythm = load_rhythm($rid);
	switch ($lang) {
		case 'vi':
			return $rhythm['name'];
			break;
		case 'en':
			return $rhythm['description_en'];
			break;
		case 'ru':
			return $rhythm['description_ru'];
			break;
		case 'es':
			return $rhythm['description_es'];
			break;
		case 'zh':
			return $rhythm['description_zh'];
			break;
		case 'ja':
			return $rhythm['description_ja'];
			break;
	}
}
function error($msg) { //Show popup meesage
    echo '
    <html>
    <head>
    <script language="JavaScript">
    <!--
        alert("'.$msg.'");
        history.back();
    //-->
    </script>
    </head>
    <body>
    </body>
    </html>
    ';
    exit;
}
function has_dob() {
	global $dob;
	if ($dob != '') {
		return true;
	} else {
		return false;
	}
}
/* User Functions */
function has_birthday($dob,$time) {
	if (date('m-d',strtotime($dob)) == date('m-d',$time)) {
		return true;
	} else {
		return false;
	}
}
function is_birthday() {
	global $dob;
	return has_birthday($dob, time());
}
function can_wish() {
	if (has_dob() && is_birthday()) {
		return true;
	} else {
		return false;
	}
}
function list_user_same_birthday_links($name) {
	global $dob;
	global $lang_code;
	global $span_interfaces;
	$output = '';
	$users = array_filter(load_all_array('nsh_users'), array(new filter(true), 'filter_has_same_birthday'));
	usort($users,'sort_name_ascend');
	if (!empty($users) && $dob != '') {
		$output .= '<div class="dates-box">';
		$output .= '<h2 class="dates-header"><span class="translate" data-lang-ja="'.$span_interfaces['list_user_same_birthday_links']['ja'].'" data-lang-zh="'.$span_interfaces['list_user_same_birthday_links']['zh'].'" data-lang-es="'.$span_interfaces['list_user_same_birthday_links']['es'].'" data-lang-ru="'.$span_interfaces['list_user_same_birthday_links']['ru'].'" data-lang-en="'.$span_interfaces['list_user_same_birthday_links']['en'].'" data-lang-vi="'.$span_interfaces['list_user_same_birthday_links']['vi'].'">'.$span_interfaces['list_user_same_birthday_links'][$lang_code].'</span></h2>';
		$output .= '<ul class="dates" id="'.$name.'">';
		$count = count($users);
		for ($i = 0; $i < $count; ++$i) {
			$output .= '<li><a title="'.$users[$i]['name'].'" class="m-btn" href="/?fullname='.str_replace(' ','+',$users[$i]['name']).'&amp;dob='.$users[$i]['dob'].'"><span>'.$users[$i]['name'].' - '.$users[$i]['dob'].'</span></a></li>';
		}
		$output .= '</ul>';
		$output .= '<div class="clear"></div>';
		$output .= '</div>';
	}
	return $output;
}
function list_user_birthday_links($name) {
	global $lang_code;
	global $span_interfaces;
	$output = '';
	$users = array_filter(load_all_array('nsh_users'), array(new filter(true), 'filter_has_birthday'));
	usort($users,'sort_name_ascend');
	if (!empty($users)) {
		$output .= '<div class="dates-box">';
		$output .= '<h2 class="dates-header"><span class="translate" data-lang-ja="'.$span_interfaces['list_user_birthday_links']['ja'].'" data-lang-zh="'.$span_interfaces['list_user_birthday_links']['zh'].'" data-lang-es="'.$span_interfaces['list_user_birthday_links']['es'].'" data-lang-ru="'.$span_interfaces['list_user_birthday_links']['ru'].'" data-lang-en="'.$span_interfaces['list_user_birthday_links']['en'].'" data-lang-vi="'.$span_interfaces['list_user_birthday_links']['vi'].'">'.$span_interfaces['list_user_birthday_links'][$lang_code].'</span></h2>';
		$output .= '<ul class="dates" id="'.$name.'">';
		$count = count($users);
		for ($i = 0; $i < $count; ++$i) {
			$output .= '<li><a title="'.$users[$i]['name'].'" class="m-btn" href="/?fullname='.str_replace(' ','+',$users[$i]['name']).'&amp;dob='.$users[$i]['dob'].'"><span>'.$users[$i]['name'].' - '.$users[$i]['dob'].'</span></a></li>';
		}
		$output .= '</ul>';
		$output .= '<div class="clear"></div>';
		$output .= '</div>';
	}
	return $output;
}
function list_user_links($name) {
	global $lang_code;
	global $span_interfaces;
	$output = '';
	$output .= '<a id="birthdates_toggle" class="button"><span class="translate" data-lang-ja="'.$span_interfaces['list_user_links']['ja'].'" data-lang-zh="'.$span_interfaces['list_user_links']['zh'].'" data-lang-es="'.$span_interfaces['list_user_links']['es'].'" data-lang-ru="'.$span_interfaces['list_user_links']['ru'].'" data-lang-en="'.$span_interfaces['list_user_links']['en'].'" data-lang-vi="'.$span_interfaces['list_user_links']['vi'].'">'.$span_interfaces['list_user_links'][$lang_code].'</span></a>';
	$output .= '<div class="clear"></div>';
	$output .= '<div id="birthdates">';
	$output .= '</div>';
	$output .= '<script>
				var dobListStatus;
				if (!$.cookie("NSH:list-'.$name.'-status")) {
					dobListStatus = "hide";
				} else {
					dobListStatus = $.cookie("NSH:list-'.$name.'-status");
				}
				if (dobListStatus == "hide") {
					$("#birthdates_toggle").removeClass("clicked");
					hideBirthdates();
				} else if (dobListStatus == "show") {
					$("#birthdates_toggle").addClass("clicked");
					showBirthdates();
				}
				$("#birthdates_toggle").click(function(){
					if ($(this).hasClass("clicked") && dobListStatus == "show") {
						$.cookie("NSH:list-'.$name.'-status", "hide")
						dobListStatus = "hide";
						$(this).removeClass("clicked");
						hideBirthdates();
					} else if (!$(this).hasClass("clicked") && dobListStatus == "hide") {
						$.cookie("NSH:list-'.$name.'-status", "show")
						dobListStatus = "show";
						$(this).addClass("clicked");
						showBirthdates();
					}
				});
				</script>';
	return $output;
}
function list_ajax_user_links($name) {
	$output = '';
	$users = load_all_array('nsh_users');
	usort($users,'sort_name_ascend');
	$output .= '<div class="dates-box">';
	$output .= '<div class="dates-nav" id="'.$name.'-nav"></div>';
	$output .= '<ul class="dates" id="'.$name.'">';
	$count = count($users);
	for ($i = 0; $i < $count; ++$i) {
		$output .= '<li><a title="'.$users[$i]['name'].'" class="m-btn" href="/?fullname='.str_replace(' ','+',$users[$i]['name']).'&amp;dob='.$users[$i]['dob'].'"><span>'.$users[$i]['name'].' - '.$users[$i]['dob'].'</span></a></li>';
	}
	$output .= '</ul>';
	$output .= '<div class="clear"></div>';
	$output .= '<script>
				lang = $.cookie("NSH:lang");
				$("#'.$name.'").listnav({
					includeOther: true,
					cookieName: "NSH:list-'.$name.'"
				});
				$("a.all > span.translate").text($("a.all > span.translate").attr("data-lang-"+lang));
				$("#birthdates .m-btn, .ln-letters a").ripple();
				</script>';
	$output .= '</div>';
	return $output;
}
function list_users($page=1,$keyword='') { //Return users list, for admin use
	$output = '';
	$count = 10;
	$users = ($keyword != '') ? array_filter(load_all_array('nsh_users'), array(new filter($keyword), 'filter_keyword')): load_all_array('nsh_users');
	usort($users,'sort_name_ascend');
	$users_count = count($users);
	$pagination = new Pagination($users,$page,$count,20);
	$pagination->setShowFirstAndLast(true);
	$pagination->setMainSeperator('');
	$users = $pagination->getResults();
	$output .= '<a class="button right" href="/user/create/">Create user</a>';
	$output .= '<span class="count">'.$users_count.' user'.(($users_count > 1) ? 's': '').'.</span>';
	$output .= '<div class="paging">'.$pagination->getLinks().'</div>';
	$output .= '<table class="admin">';
	$output .= '<tr><th>ID</th><th>User ID</th><th>Username</th><th>DOB</th><th colspan="2">Operations</th></tr>';
	for ($i = 0; $i < $count; ++$i) {
		if (isset($users[$i])) {
			$class = 'class="'.table_row_class($i).'"';
			$output .= '<tr '.$class.'>';
			$output .= '<td>'.(($page-1)*$count+($i+1)).'</td>';
			$output .= '<td>'.$users[$i]['uid'].'</td>';
			$output .= '<td><a style="color: black" target="_blank" href="/?fullname='.str_replace(' ','+',$users[$i]['name']).'&dob='.$users[$i]['dob'].'">'.$users[$i]['name'].'</a></td>';
			$output .= '<td>'.$users[$i]['dob'].'</td>';
			$output .= '<td><form method="POST" action="/user/edit/"><input type="hidden" name="uid" value="'.$users[$i]['uid'].'" /><input type="hidden" name="old_name" value="'.$users[$i]['name'].'" /><input type="hidden" name="old_dob" value="'.$users[$i]['dob'].'" /><input name="user_edit" type="submit" value="Edit"/></form></td>';
			$output .= '<td><form method="POST" action="/user/delete/"><input type="hidden" name="uid" value="'.$users[$i]['uid'].'" /><input name="user_delete" type="submit" value="Delete"/></form></td>';
			$output .= '</tr>';
		}
	}
	$output .= '</table>';
	$output .= '<div class="paging">'.$pagination->getLinks().'</div>';
	$output .= '<script>
				function turnPage(page) {
					$("#admin_user").load("/triggers/admin_user.php",{page:page,keyword:"'.$keyword.'"});
				}
				</script>';
	return $output;
}
function create_user($name,$dob) { //Create new user
	$array = array(
				'name' => $name,
				'dob' => $dob
			);
	insert_record($array,'nsh_users');
}
function edit_user($uid,$name,$dob) { //Edit user details
	$array = array(
				'name' => $name,
				'dob' => $dob
			);
	update_record($array,'uid',$uid,'nsh_users');
}
function delete_user($uid) { //Delete user with user ID
	delete_record('uid',$uid,'nsh_users');
}
/* Rhythm Functions */
function list_rhythms() { //Return list of rhythms, for admin use
	$output = '';
	$rhythms = load_all_array('nsh_rhythms');
	$output .= '<a class="button" href="/rhythm/create/">Create rhythm</a>';
	$output .= '<table class="admin">';
	$output .= '<tr><th>Rhythm ID</th><th>Rhythm name</th><th colspan="3">Operations</th></tr>';
	$count = count($rhythms);
	$output .= '<tr><td class="count" colspan="6">'.$count.' item'.(($count > 1) ? 's': '').' to display.</td></tr>';
	for ($i = 0; $i < $count; ++$i) {
		$class = 'class="'.table_row_class($i).'"';
		$output .= '<tr '.$class.'>';
		$output .= '<td>'.$rhythms[$i]['rid'].'</td>';
		$output .= '<td>'.$rhythms[$i]['name'].'</td>';
		$output .= '<td><form method="POST" action="/rhythm/edit/"><input type="hidden" name="rid" value="'.$rhythms[$i]['rid'].'" /><input type="hidden" name="old_name" value="'.$rhythms[$i]['name'].'" /><input type="hidden" name="old_scale" value="'.$rhythms[$i]['scale'].'" /><input type="hidden" name="old_description_en" value="'.str_replace('"',"'",$rhythms[$i]['description_en']).'" /><input type="hidden" name="old_description_ru" value="'.str_replace('"',"'",$rhythms[$i]['description_ru']).'" /><input type="hidden" name="old_description_es" value="'.str_replace('"',"'",$rhythms[$i]['description_es']).'" /><input type="hidden" name="old_description_zh" value="'.str_replace('"',"'",$rhythms[$i]['description_zh']).'" /><input type="hidden" name="old_description_ja" value="'.str_replace('"',"'",$rhythms[$i]['description_ja']).'" /><input name="rhythm_edit" type="submit" value="Edit"/></form></td>';
		$output .= '<td><form method="POST" action="/triggers/change_rhythm_type.php"><input type="hidden" name="rid" value="'.$rhythms[$i]['rid'].'" /><input name="rhythm_chang_type" type="submit" title="Make rhythm '.(($rhythms[$i]['is_secondary'] == 0) ? 'secondary': 'primary').'" value="'.(($rhythms[$i]['is_secondary'] == 0) ? 'Primary': 'Secondary').'"/></form></td>';
		$output .= '<td><form method="POST" action="/rhythm/delete/"><input type="hidden" name="rid" value="'.$rhythms[$i]['rid'].'" /><input name="rhythm_delete" type="submit" value="Delete"/></form></td>';
		$output .= '</tr>';
	}
	$output .= '</table>';
	return $output;
}
function create_rhythm($name,$scale,$description_en,$description_ru,$description_es,$description_zh,$description_ja) { //Create new rhythm
	$array = array(
				'name' => $name,
				'scale' => $scale,
				'description_en' => $description_en,
				'description_ru' => $description_ru,
				'description_es' => $description_es,
				'description_zh' => $description_zh,
				'description_ja' => $description_ja
			);
	insert_record($array,'nsh_rhythms');
}
function edit_rhythm($rid,$name,$scale,$description_en,$description_ru,$description_es,$description_zh,$description_ja) { //Edit rhythm details
	$array = array(
				'name' => $name,
				'scale' => $scale,
				'description_en' => $description_en,
				'description_ru' => $description_ru,
				'description_es' => $description_es,
				'description_zh' => $description_zh,
				'description_ja' => $description_ja
			);
	update_record($array,'rid',$rid,'nsh_rhythms');
}
function delete_rhythm($rid) { //Delete rhythm
	delete_record('rid',$rid,'nsh_rhythms');
}
function make_rhythm_secondary($rid) {
	$array = array(
				'is_secondary' => '1'
			);
	update_record($array,'rid',$rid,'nsh_rhythms');
}
function make_rhythm_primary($rid) {
	$array = array(
				'is_secondary' => '0'
			);
	update_record($array,'rid',$rid,'nsh_rhythms');
}
/* Graph Functions */
function differ_date($start, $end) {
	$start_ts = strtotime($start);
	$end_ts = strtotime($end);
	$diff = $end_ts - $start_ts;
	return round($diff/86400);
}
function bio_count($dob,$date,$scale) { //http://en.wikipedia.org/wiki/Biorhythm
	$x = differ_date($dob,$date);
	//return (number_format((sin(2*pi()*$x/$scale)*100),2) != '-0.00') ? number_format((sin(2*pi()*$x/$scale)*100),2): '0.00';
	return number_format(((sin(2*pi()*$x/$scale)*100)+100)/2,2);
}
function percent_bio_count($dob,$date,$scale) {
	return bio_count($dob,$date,$scale).' %';
}
function average_bio_count($dob,$date,$rhythms) {
	$total = 0;
	$count = (count($rhythms) > 0) ? count($rhythms): 1;
	$i = 0;
	foreach ($rhythms as $rhythm) {
		$total += bio_count($dob,$date,$rhythm['scale']);
		++$i;
	}
	return number_format($total/$count,2);
}
function percent_average_bio_count($dob,$date,$rhythms) {
	return average_bio_count($dob,$date,$rhythms).' %';
}
// https://github.com/rmanasyan/compatzz/blob/master/js/main.js
function compatible_count($this_dob,$that_dob,$scale) {
	$x = abs(differ_date($this_dob,$that_dob));
	return number_format(100*abs(cos(pi()*$x/$scale)),2);
}
function percent_compatible_count($this_dob,$that_dob,$scale) {
	return ($this_dob == $that_dob) ? 'N/A': compatible_count($this_dob,$that_dob,$scale).' %';
}
function average_compatible_count($this_dob,$that_dob,$rhythms) {
	$total = 0;
	$count = (count($rhythms) > 0) ? count($rhythms): 1;
	$i = 0;
	foreach ($rhythms as $rhythm) {
		$total += compatible_count($this_dob,$that_dob,$rhythm['scale']);
		++$i;
	}
	return number_format($total/$count,2);
}
function percent_average_compatible_count($this_dob,$that_dob,$rhythms) {
	return ($this_dob == $that_dob) ? 'N/A': average_compatible_count($this_dob,$that_dob,$rhythms).' %';
}
/* Zodiac Sign */
function get_zodiac_sign($dob) {
	$person = new astro($dob);
	return $person->chaldeanSign;
}
/* Zodiac Feeds */
function get_daily_horoscope($dob) {
	$sign = get_zodiac_sign($dob);
	$rss = new RSSReader('http://findyourfate.com/rss/dailyhoroscope-feed.asp?sign='.$sign);
	$nn = $rss->getNumberOfNews();
	$output = '';
	$output .= '<table width="40%"  border="0" cellspacing="0" cellpadding="5" class="box">';
	$output .= '<tr><td>'.$rss->getImage().'</td></tr>';
	$output .= '<tr><td>'.$rss->getChannelTitle('rsstitle').'</td></tr>';
	for ($i = 0; $i <$nn; ++$i){
		$output .= '<tr><td>'.$rss->getItemTitle('rsslink',$i).'</td></tr>';
		$output .= '<tr><td>'.$rss->getItemDescription('rsstext',$i).'</td></tr>';
		$output .= '<tr><td>'.$rss->getItemPubdate('rssdate',$i).'</td></tr>';
		$output .= '<tr><td height="10"></td></tr>';
	}
	$output .= '</table>';
	return $output;
}
function get_zodiac_from_dob($birthdate,$lang='vi') {
	list($year, $month, $day) = array_pad(explode('-', $birthdate, 3), 3, null);
	if (($month == 3 && $day > 20) || ($month == 4 && $day < 20)) {
		switch ($lang) {
			case 'vi': return 'Bạch Dương'; break;
			case 'en': return 'Aries'; break;
			case 'ru': return 'Овен'; break;
			case 'es': return 'Aries'; break;
			case 'zh': return '白羊宮'; break;
			case 'ja': return 'おひつじ座'; break;
		}
	} else if (($month == 4 && $day > 19) || ($month == 5 && $day < 21)) {
		switch ($lang) {
			case 'vi': return 'Kim Ngưu'; break;
			case 'en': return 'Taurus'; break;
			case 'ru': return 'Телец'; break;
			case 'es': return 'Tauro'; break;
			case 'zh': return '金牛宮'; break;
			case 'ja': return 'おうし座'; break;
		}
	} else if (($month == 5 && $day > 20) || ($month == 6 && $day < 21)) {
		switch ($lang) {
			case 'vi': return 'Song Tử'; break;
			case 'en': return 'Gemini'; break;
			case 'ru': return 'Близнецы'; break;
			case 'es': return 'Géminis'; break;
			case 'zh': return '雙子宮'; break;
			case 'ja': return 'ふたご座'; break;
		}
	} else if (($month == 6 && $day > 20) || ($month == 7 && $day < 23)) {
		switch ($lang) {
			case 'vi': return 'Cự Giải'; break;
			case 'en': return 'Cancer'; break;
			case 'ru': return 'Рак'; break;
			case 'es': return 'Cáncer'; break;
			case 'zh': return '巨蟹宮'; break;
			case 'ja': return 'かに座'; break;
		}
	} else if (($month == 7 && $day > 22) || ($month == 8 && $day < 23)) {
		switch ($lang) {
			case 'vi': return 'Sư Tử'; break;
			case 'en': return 'Leo'; break;
			case 'ru': return 'Лев'; break;
			case 'es': return 'Leo'; break;
			case 'zh': return '獅子宮'; break;
			case 'ja': return 'しし座'; break;
		}
	} else if (($month == 8 && $day > 22) || ($month == 9 && $day < 23)) {
		switch ($lang) {
			case 'vi': return 'Xử Nữ'; break;
			case 'en': return 'Virgo'; break;
			case 'ru': return 'Дева'; break;
			case 'es': return 'Virgo'; break;
			case 'zh': return '室女宮'; break;
			case 'ja': return 'おとめ座'; break;
		}
	} else if (($month == 9 && $day > 22) || ($month == 10 && $day < 23)) {
		switch ($lang) {
			case 'vi': return 'Thiên Bình'; break;
			case 'en': return 'Libra'; break;
			case 'ru': return 'Весы'; break;
			case 'es': return 'Libra'; break;
			case 'zh': return '天秤宮'; break;
			case 'ja': return 'てんびん座'; break;
		}
	} else if (($month == 10 && $day > 22) || ($month == 11 && $day < 22)) {
		switch ($lang) {
			case 'vi': return 'Thiên Yết'; break;
			case 'en': return 'Scorpio'; break;
			case 'ru': return 'Скорпион'; break;
			case 'es': return 'Escorpio'; break;
			case 'zh': return '天蠍宮'; break;
			case 'ja': return 'さそり座'; break;
		}
	} else if (($month == 11 && $day > 21) || ($month == 12 && $day < 22)) {
		switch ($lang) {
			case 'vi': return 'Nhân Mã'; break;
			case 'en': return 'Sagittarius'; break;
			case 'ru': return 'Стрелец'; break;
			case 'es': return 'Sagitario'; break;
			case 'zh': return '人馬宮'; break;
			case 'ja': return 'いて座'; break;
		}
	} else if (($month == 12 && $day > 21) || ($month == 1 && $day < 20)) {
		switch ($lang) {
			case 'vi': return 'Ma Kết'; break;
			case 'en': return 'Capricorn'; break;
			case 'ru': return 'Козерог'; break;
			case 'es': return 'Capricornio'; break;
			case 'zh': return '摩羯宮'; break;
			case 'ja': return 'やぎ座'; break;
		}
	} else if (($month == 1 && $day > 19) || ($month == 2 && $day < 19)) {
		switch ($lang) {
			case 'vi': return 'Bảo Bình'; break;
			case 'en': return 'Aquarius'; break;
			case 'ru': return 'Водолей'; break;
			case 'es': return 'Acuario'; break;
			case 'zh': return '寶瓶宮'; break;
			case 'ja': return 'みずがめ座'; break;
		}
	} else if (($month == 2 && $day > 18) || ($month == 3 && $day < 21)) {
		switch ($lang) {
			case 'vi': return 'Song Ngư'; break;
			case 'en': return 'Pisces'; break;
			case 'ru': return 'Рыбы'; break;
			case 'es': return 'Piscis'; break;
			case 'zh': return '雙魚宮'; break;
			case 'ja': return 'うお座'; break;
		}
	}
}
function get_zodiac_csv_char($id) {
	$zodiac_csv = new parseCSV(realpath($_SERVER['DOCUMENT_ROOT']).'/hoangdao/'.$id.'.csv');
	$count = count($zodiac_csv->data);
	$index = rand(0, $count-1);
	return $zodiac_csv->data[$index]['char'];
}
function get_zodiac_chars($id) {
	return get_zodiac_csv_char('ngoaihinh_'.$id).', '.get_zodiac_csv_char('tinhcach_'.$id).', '.get_zodiac_csv_char('tinhcam_'.$id);
}
function get_zodiac_character($birthdate) {
	$char = '';
	list($year, $month, $day) = array_pad(explode('-', $birthdate, 3), 3, null);
	if (($month == 3 && $day > 20) || ($month == 4 && $day < 20)) { // Bạch Dương
		$char = get_zodiac_chars('01');
	} else if (($month == 4 && $day > 19) || ($month == 5 && $day < 21)) { // Kim Ngưu
		$char = get_zodiac_chars('02');
	} else if (($month == 5 && $day > 20) || ($month == 6 && $day < 21)) { // Song Tử
		$char = get_zodiac_chars('03');
	} else if (($month == 6 && $day > 20) || ($month == 7 && $day < 23)) { // Cự Giải
		$char = get_zodiac_chars('04');
	} else if (($month == 7 && $day > 22) || ($month == 8 && $day < 23)) { // Sư Tử
		$char = get_zodiac_chars('05');
	} else if (($month == 8 && $day > 22) || ($month == 9 && $day < 23)) { // Xử Nữ
		$char = get_zodiac_chars('06');
	} else if (($month == 9 && $day > 22) || ($month == 10 && $day < 23)) { // Thiên Bình
		$char = get_zodiac_chars('07');
	} else if (($month == 10 && $day > 22) || ($month == 11 && $day < 22)) { // Thiên Yết
		$char = get_zodiac_chars('08');
	} else if (($month == 11 && $day > 21) || ($month == 12 && $day < 22)) { // Nhân Mã
		$char = get_zodiac_chars('09');
	} else if (($month == 12 && $day > 21) || ($month == 1 && $day < 20)) { // Ma Kết
		$char = get_zodiac_chars('10');
	} else if (($month == 1 && $day > 19) || ($month == 2 && $day < 19)) { // Bảo Bình
		$char = get_zodiac_chars('11');
	} else if (($month == 2 && $day > 18) || ($month == 3 && $day < 21)) { // Song Ngư
		$char = get_zodiac_chars('12');
	}
	return $char;
}
function countdown_birthday($dob, $date = 'today') {
	$countdown = 0;
	$birthday = date('m-d', strtotime($dob));
	$diff = differ_date($date, date('Y', strtotime($date)).'-'.$birthday);
	if ($diff <= 0) {
		$countdown = differ_date($date, (date('Y', strtotime($date)) + 1).'-'.$birthday);
	} else if ($diff > 0) {
		$countdown = $diff;
	}
	return $countdown;
}
/* RACING Functions */
function player_input($count) {
	$output = '';
	for ($i = 0; $i < $count; ++$i) {
		$output .= '<div class="m-input-prepend"><span class="add-on">Tên người chơi thứ '.($i+1).':</span><input data-position="'.($i+1).'" type="text" name="player'.($i+1).'" size="42" maxlength="128" class="player-name m-wrap required"></div>';
	}
	return $output;
}
/**
 * Get random color hex value
 *
 * @param integer $max_r Maximum value for the red color
 * @param integer $max_g Maximum value for the green color
 * @param integer $max_b Maximum value for the blue color
 * @return string
 */
function get_random_color_hex($max_r = 255, $max_g = 255, $max_b = 255)
{
    // ensure that values are in the range between 0 and 255
    if ($max_r > 255) { $max_r = 255; }
    if ($max_g > 255) { $max_g = 255; }
    if ($max_b > 255) { $max_b = 255; }
    if ($max_r < 0) { $max_r = 0; }
    if ($max_g < 0) { $max_g = 0; }
    if ($max_b < 0) { $max_b = 0; }
   
    // generate and return the random color
    return str_pad(dechex(rand(0, $max_r)), 2, '0', STR_PAD_LEFT) .
           str_pad(dechex(rand(0, $max_g)), 2, '0', STR_PAD_LEFT) .
           str_pad(dechex(rand(0, $max_b)), 2, '0', STR_PAD_LEFT);
}
/* Sort Functions */
function sort_descend($a,$b){ //Call back function to sort descendently
	if (isset($a['sort']) && isset($b['sort'])) {
		if ((int)$a['sort'] == (int)$b['sort']) {
			return 0;
		}
		return ((int)$b['sort'] < (int)$a['sort']) ? -1 : 1;
	}
}
function sort_ascend($a,$b){ //Call back function to sort ascendently
	if (isset($a['sort']) && isset($b['sort'])) {
		if ((int)$a['sort'] == (int)$b['sort']) {
			return 0;
		}
		return ((int)$a['sort'] < (int)$b['sort']) ? -1 : 1;
	}
}
function sort_name_descend($a,$b){ //Call back function to sort date descendently
	if (isset($a['name']) && isset($b['name'])) {
		return strcmp($b['name'],$a['name']);
	}
}
function sort_name_ascend($a,$b){ //Call back function to sort date ascendently
	if (isset($a['name']) && isset($b['name'])) {
		return strcmp($a['name'],$b['name']);
	}
}
function sort_date_descend($a,$b){ //Call back function to sort date descendently
	if (isset($a['created']) && isset($b['created'])) {
		return strcmp($b['created'],$a['created']);
	}
}
function sort_date_ascend($a,$b){ //Call back function to sort date ascendently
	if (isset($a['created']) && isset($b['created'])) {
		return strcmp($a['created'],$b['created']);
	}
}
/* Filter Class */
class filter {
	function __construct($num) {
			$this->num = $num;
	}
	function filter_keyword($a) { //Call back function to filter array by fullname
		if (isset($a['name']) && isset($a['dob'])) {
			if (preg_match("/$this->num/i",$a['name']) || preg_match("/$this->num/i",$a['dob'])) {
				return true;
			} else {
				return false;
			}
		}
	}
	function filter_rid($a) { //Call back function to filter array by role ID
		if (isset($a['rid'])) {
			if ($a['rid'] == $this->num) {
				return true;
			} else {
				return false;
			}
		}
	}
	function filter_secondary($a) { //Call back function to filter array by role ID
		if (isset($a['is_secondary'])) {
			if ($a['is_secondary'] == $this->num) {
				return true;
			} else {
				return false;
			}
		}
	}
	function filter_has_birthday($a) { //Call back function to filter array by role ID
		if (isset($a['dob'])) {
			if (has_birthday($a['dob'],time()) == $this->num) {
				return true;
			} else {
				return false;
			}
		}
	}
	function filter_has_same_birthday($a) { //Call back function to filter array by role ID
		global $dob, $fullname;
		if (isset($a['dob']) && $dob != '' && isset($a['name'])) {
			if (has_birthday($a['dob'],strtotime($dob)) == $this->num && prevent_xss($a['name']) != $fullname) {
				return true;
			} else {
				return false;
			}
		}
	}
}
function site_name() {
	global $lang_code;
	switch ($lang_code) {
		case 'vi': return 'Biểu đồ nhịp sinh học'; break;
		case 'en': return 'Biorhythm chart'; break;
		case 'ru': return 'Биоритм диаграммы'; break;
		case 'es': return 'Biorritmo carta'; break;
		case 'zh': return '生理节律图'; break;
		case 'ja': return 'バイオリズムチャート'; break;
	}
}
function intro_title() {
	global $lang_code;
	switch ($lang_code) {
		case 'vi': return 'Giới thiệu'; break;
		case 'en': return 'Introduction'; break;
		case 'ru': return 'Введение'; break;
		case 'es': return 'Introducción'; break;
		case 'zh': return '介绍'; break;
		case 'ja': return 'はじめに'; break;
	}
}
function home_title() {
	global $lang_code;
	global $fullname;
	switch ($lang_code) {
		case 'vi': return 'Tính nhịp sinh học'.(($fullname != '') ? ' cho '.$fullname: ''); break;
		case 'en': return 'Calculate biorhythm'.(($fullname != '') ? ' for '.$fullname: ''); break;
		case 'ru': return 'Рассчитать биоритм'.(($fullname != '') ? ' для '.$fullname: ''); break;
		case 'es': return 'Calcular biorritmo'.(($fullname != '') ? ' para '.$fullname: ''); break;
		case 'zh': return '计算生理节律'.(($fullname != '') ? '供'.$fullname: ''); break;
		case 'ja': return 'を計算バイオリズム'.(($fullname != '') ? 'のために'.$fullname: ''); break;
	}
}
function birthday_title() {
	global $lang_code;
	global $fullname;
	switch ($lang_code) {
		case 'vi': return 'Chúc mừng sinh nhật'.(($fullname != '') ? ' '.$fullname: ''); break;
		case 'en': return 'Happy birthday'.(($fullname != '') ? ' '.$fullname: ' to you'); break;
		case 'ru': return 'Днем Рождения'.(($fullname != '') ? ' '.$fullname: ''); break;
		case 'es': return 'Feliz cumpleaños'.(($fullname != '') ? ' '.$fullname: ''); break;
		case 'zh': return '生日快乐'.(($fullname != '') ? $fullname: ''); break;
		case 'ja': return 'お誕生日おめでとうございます'.(($fullname != '') ? $fullname: ''); break;
	}
}
function get_wish($lang) {
	$wishes = new parseCSV();
	$wishes->parse(realpath($_SERVER['DOCUMENT_ROOT']).'/wishes/'.$lang.'.csv');
	$count = count($wishes->data);
	$index = rand(0, $count-1);
	return $wishes->data[$index]['wish'];
}
function birthday_wish() {
	global $lang_code;
	global $fullname;
	switch ($lang_code) {
		case 'vi': return get_wish('vi'); break;
		case 'en': return get_wish('en'); break;
		case 'ru': return get_wish('ru'); break;
		case 'es': return get_wish('es'); break;
		case 'zh': return get_wish('zh'); break;
		case 'ja': return get_wish('ja'); break;
	}
}
function search_title() {
	global $lang_code;
	global $q;
	switch ($lang_code) {
		case 'vi': return 'Kết quả tìm kiếm cho "'.$q.'"'; break;
		case 'en': return 'Search results for "'.$q.'"'; break;
		case 'ru': return 'Результаты поиска для "'.$q.'"'; break;
		case 'es': return 'Resultados de búsqueda para "'.$q.'"'; break;
		case 'zh': return '搜索结果"'.$q.'"'; break;
		case 'ja': return 'の検索結果"'.$q.'"'; break;
	}
}
function head_description() {
	global $lang_code;
	switch ($lang_code) {
		case 'vi': return 'Biểu đồ Nhịp sinh học hiển thị dự đoán Sức khỏe, Tình cảm, Trí tuệ của bạn'; break;
		case 'en': return 'Biorhythm chart tells your physical, emotional, intellectual values'; break;
		case 'ru': return 'Биоритм диаграммы рассказывает ваш физические, эмоциональные, интеллектуальные ценности'; break;
		case 'es': return 'Biorritmo Carta le dice tu valores físicos, intelectuales y emocionales'; break;
		case 'zh': return '生物节律图表告诉你的身体，情绪，智力值'; break;
		case 'ja': return 'バイオリズムチャートは、物理的、感情的、知的なあなたの値を伝えます'; break;
	}
}
function chrome_webstore_item() {
	global $lang_code;
	$item_link = 'https://chrome.google.com/webstore/detail/';
	switch ($lang_code) {
		case 'vi': $item_link .= 'piomnolafccfmmingfmkffakbkdndngm'; break;
		case 'en': $item_link .= 'ddejngbhchmilhefdhejblgclkjjhada'; break;
		case 'ru': $item_link .= 'gbkgpnnjegmankjficecafbhogpeghlp'; break;
		case 'es': $item_link .= 'fcmpoljpimefbadihigjecfadohnmngb'; break;
		case 'zh': $item_link .= 'ihahiddfifjhomhiggelpecglncdcjbm'; break;
		case 'ja': $item_link .= 'afpahinfkpefgbfnlcogfdjokhgeolhm'; break;
	}
	return $item_link;
}
//array_filter($posts, array(new filter($cid), 'filter_cid'))
function change_url_lang($url, $lang) {
	global $lang_codes;
	$changed_url = '';
	if (in_array($lang, $lang_codes)) {
		if (strpos($url,'lang=') !== false) {
			$lang_pos = strpos($url,'lang=')+5;
			$lang_code = substr($url,$lang_pos,2);
			$changed_url = str_replace('lang='.$lang_code, 'lang='.$lang, $url);
		} else if (strpos($url,'?') !== false) {
			$changed_url = $url.'&lang='.$lang;
		} else {
			$changed_url = $url.'?lang='.$lang;
		}
	}
	return str_replace('&', '&amp;', $changed_url);
}
function default_url($url) {
	$lang_pos = strpos($url,'lang=');
	$lang_str = substr($url,$lang_pos,7);
	if (strpos($url,'?'.$lang_str.'&') !== false) {
		$default_url = str_replace($lang_str.'&', '', $url);
	} else if (strpos($url,'?lang=') !== false) {
		$default_url = str_replace('?'.$lang_str, '', $url);
	} else if (strpos($url,'&lang=') !== false) {
		$default_url = str_replace('&'.$lang_str, '', $url);
	} else {
		$default_url = $url;
	}
	return str_replace('&', '&amp;', $default_url);
}
function current_url() { //Get current page URL
	$page_url = 'http';
	if (isset($_SERVER['HTTPS'])){
		if ($_SERVER['HTTPS'] == 'on') {$page_url .= 's';}
	}
	$page_url .= '://';
	if ($_SERVER['SERVER_PORT'] != '80') {
		$page_url .= $_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
	} else {
		$page_url .= $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	}
	return $page_url;
}
function current_url_lang($lang) {
	global $p;
	global $navs;
	$current_url = current_url();
	return !in_array($p, $navs) ? change_url_lang($current_url, $lang): $current_url;
}
function current_default_url() {
	$current_url = current_url();
	return default_url($current_url);
}
function base_url() {
	$page_url = 'http';
	if (isset($_SERVER['HTTPS'])){
		if ($_SERVER['HTTPS'] == 'on') {$page_url .= 's';}
	}
	$page_url .= '://';
	if ($_SERVER['SERVER_PORT'] != '80') {
		$page_url .= $_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'];
	} else {
		$page_url .= $_SERVER['SERVER_NAME'];
	}
	return $page_url;
}
function is_mobile() {
	$useragent = $_SERVER['HTTP_USER_AGENT'];
	if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od|ad)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt|kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
		return true;
	} else {
		return false;
	}
}
function class_mobile() {
	return is_mobile() ? 'class="mobile"': '';
}
function style_mobile() {
	return is_mobile() ? 'style="width: 100%; background: none; margin: 0px auto;"': '';
}

/**
 * Grab Images from Wikipedia via thier API
 *
 * @author     http://techslides.com
 * @link       http://techslides.com/grab-wikipedia-pictures-by-api-with-php
 */
 
//curl request returns json output via json_decode php function
function curl($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}
 
//parse the json output
function get_results($json){
	$results = array();
	$json_array = json_decode($json, true);
	foreach($json_array['query']['pages'] as $page){
		$count = count($page['images']);
		if($count > 0){
		    foreach($page['images'] as $image){
		    	$title = str_replace(' ', '_', $image['title']);
		    	$imageinfourl = 'http://en.wikipedia.org/w/api.php?action=query&titles='.$title.'&prop=imageinfo&iiprop=url&format=json';
		    	$imageinfo = curl($imageinfourl);
		    	$iamge_array = json_decode($imageinfo, true);
		    	$image_pages = $iamge_array['query']['pages'];
				foreach($image_pages as $a){
					$results[] = $a['imageinfo'][0]['url'];
				}
			}
		}
	}
	return $results;
}
function get_wiki_image($keyword,$limit) {
	$output = '';
	$term = str_replace(' ', '_', $keyword);
    $url = 'http://en.wikipedia.org/w/api.php?action=query&titles='.$term.'&prop=images&format=json&imlimit='.$limit;
 
    $json = curl($url);
    $results = get_results($json);
 
	//print the results using an unordered list
	$output .= '<table style="border: 0px;" border="0" cellpadding="2" width="100%"><tr>';
	foreach ($results as $a) {
	     $output .= '<td><a class="zoom" data-gall="wiki" href="'.$a.'"><img width="210" alt="'.$keyword.'" src="'.$a.'"></a></td>';
	}
	$output .= '</tr></table>';
	return $output;
}
function render_ad($name) {
	$ads = new parseCSV(realpath($_SERVER['DOCUMENT_ROOT']).'/ads/'.$name.'.csv');
	$count = count($ads->data);
	$index = rand(0, $count-1);
	switch ($name) {
		case 'itunes_160x600':
			echo '<iframe src="//banners.itunes.apple.com/banner.html?partnerId=&amp;aId=10lpuQ&amp;bt=genre&amp;t=genre_matrix_'.$ads->data[$index]['style'].'&amp;ft='.$ads->data[$index]['feed_type'].'&amp;st='.$ads->data[$index]['media_type'].'&amp;c='.$ads->data[$index]['country_code'].'&amp;l=en-US&amp;s='.$ads->data[$index]['s'].'&amp;p='.$ads->data[$index]['p'].'&amp;w=160&amp;h=600"></iframe>';
			break;
		case 'itunes_300x250':
			echo '<iframe src="//banners.itunes.apple.com/banner.html?partnerId=&amp;aId=10lpuQ&amp;bt=genre&amp;t=genre_matrix_'.$ads->data[$index]['style'].'&amp;ft='.$ads->data[$index]['feed_type'].'&amp;st='.$ads->data[$index]['media_type'].'&amp;c='.$ads->data[$index]['country_code'].'&amp;l=en-US&amp;s='.$ads->data[$index]['s'].'&amp;p='.$ads->data[$index]['p'].'&amp;w=300&amp;h=250"></iframe>';
			break;
		case 'amazon_160x600':
			echo '<iframe src="//rcm-na.amazon-adsystem.com/e/cm?t=tungpham42-20&amp;o=1&amp;p=14&amp;l=ur1&amp;category='.$ads->data[$index]['cat'].'&amp;f=ifr&amp;linkID='.$ads->data[$index]['link_id'].'"></iframe>';
			break;
		case 'amazon_300x250':
			echo '<iframe src="//rcm-na.amazon-adsystem.com/e/cm?t=tungpham42-20&amp;o=1&amp;p=12&amp;l=ur1&amp;category='.$ads->data[$index]['cat'].'&amp;f=ifr&amp;linkID='.$ads->data[$index]['link_id'].'"></iframe>';
			break;
		default:
			echo '<a target="_blank" href="'.$ads->data[$index]['link_href'].'"><img alt="'.$name.'" src="'.$ads->data[$index]['img_src'].'" /></a>'.((isset($ads->data[$index]['other_img_src'])) ? '<img class="other_img" style="border:0" src="'.$ads->data[$index]['other_img_src'].'" width="1" height="1" alt="" />': '');
	}
}
function render_proverb($name) {
	$proverbs = new parseCSV();
	$proverbs->delimiter = '|';
	$proverbs->parse(realpath($_SERVER['DOCUMENT_ROOT']).'/proverbs/'.$name.'.csv');
	$count = count($proverbs->data);
	$index = rand(0, $count-1);
	echo '<blockquote id="proverb_content"><i id="proverb_refresh" class="icon-white icon-refresh"></i><div id="proverb_text" onClick="selectText(\'proverb_text\')">'.$proverbs->data[$index]['content'].'</div></blockquote ><span class="arrow_down"></span><p id="proverb_author">'.$proverbs->data[$index]['author'].'</p>';
}
function render_country_json() {
	global $geoip_record;
	global $time_zone;
	init_timezone();
	$json_array = array(
		'country' => $geoip_record->country_code,
		'utc_offset' => $time_zone,
		'timezone' => date_default_timezone_get()
	);
	echo json_encode($json_array);
}
/* ass */
function credential($type) {
	global $credential_id;
	$credential = load_credential($credential_id);
	switch($type) {
		case 0;
			return $credential['user'];
			break;
		case 1;
			return $credential['pass'];
			break;
	}
}
function hash_pass($password) {
	$hasher = new PasswordHash(8, true);
	return $hasher->HashPassword(trim($password));
}
function check_pass($password, $hash) {
	$hasher = new PasswordHash(8, true);
	return $hasher->CheckPassword(trim($password), $hash);
}
/* http://www.informatik.uni-leipzig.de/~duc/amlich/calrules.html */
function jd_from_date($dd, $mm, $yy) {
	$a = floor((14 - $mm) / 12);
	$y = $yy + 4800 - $a;
	$m = $mm + 12 * $a - 3;
	$jd = $dd + floor((153 * $m + 2) / 5) + 365 * $y + floor($y / 4) - floor($y / 100) + floor($y / 400) - 32045;
	if ($jd < 2299161) {
		$jd = $dd + floor((153* $m + 2)/5) + 365 * $y + floor($y / 4) - 32083;
	}
	return $jd;
}
function jd_to_date($jd) {
	if ($jd > 2299160) { // After 5/10/1582, Gregorian calendar
		$a = $jd + 32044;
		$b = floor((4*$a+3)/146097);
		$c = $a - floor(($b*146097)/4);
	} else {
		$b = 0;
		$c = $jd + 32082;
	}
	$d = floor((4*$c+3)/1461);
	$e = $c - floor((1461*$d)/4);
	$m = floor((5*$e+2)/153);
	$day = $e - floor((153*$m+2)/5) + 1;
	$month = $m + 3 - 12*floor($m/10);
	$year = $b*100 + $d - 4800 + floor($m/10);
	//echo "day = $day, month = $month, year = $year\n";
	return array($day, $month, $year);
}
function get_new_moon_day($k, $time_zone) {
	$T = $k/1236.85; // Time in Julian centuries from 1900 January 0.5
	$T2 = $T * $T;
	$T3 = $T2 * $T;
	$dr = M_PI/180;
	$Jd1 = 2415020.75933 + 29.53058868*$k + 0.0001178*$T2 - 0.000000155*$T3;
	$Jd1 = $Jd1 + 0.00033*sin((166.56 + 132.87*$T - 0.009173*$T2)*$dr); // Mean new moon
	$M = 359.2242 + 29.10535608*$k - 0.0000333*$T2 - 0.00000347*$T3; // Sun's mean anomaly
	$Mpr = 306.0253 + 385.81691806*$k + 0.0107306*$T2 + 0.00001236*$T3; // Moon's mean anomaly
	$F = 21.2964 + 390.67050646*$k - 0.0016528*$T2 - 0.00000239*$T3; // Moon's argument of latitude
	$C1=(0.1734 - 0.000393*$T)*sin($M*$dr) + 0.0021*sin(2*$dr*$M);
	$C1 = $C1 - 0.4068*sin($Mpr*$dr) + 0.0161*sin($dr*2*$Mpr);
	$C1 = $C1 - 0.0004*sin($dr*3*$Mpr);
	$C1 = $C1 + 0.0104*sin($dr*2*$F) - 0.0051*sin($dr*($M+$Mpr));
	$C1 = $C1 - 0.0074*sin($dr*($M-$Mpr)) + 0.0004*sin($dr*(2*$F+$M));
	$C1 = $C1 - 0.0004*sin($dr*(2*$F-$M)) - 0.0006*sin($dr*(2*$F+$Mpr));
	$C1 = $C1 + 0.0010*sin($dr*(2*$F-$Mpr)) + 0.0005*sin($dr*(2*$Mpr+$M));
	if ($T < -11) {
		$deltat= 0.001 + 0.000839*$T + 0.0002261*$T2 - 0.00000845*$T3 - 0.000000081*$T*$T3;
	} else {
		$deltat= -0.000278 + 0.000265*$T + 0.000262*$T2;
	};
	$Jd_new = $Jd1 + $C1 - $deltat;
	//echo "Jd_new = $Jd_new\n";
	return floor($Jd_new + 0.5 + $time_zone/24);
}
function get_sun_longitude($jdn, $time_zone) {
	$T = ($jdn - 2451545.5 - $time_zone/24) / 36525; // Time in Julian centuries from 2000-01-01 12:00:00 GMT
	$T2 = $T * $T;
	$dr = M_PI/180; // degree to radian
	$M = 357.52910 + 35999.05030*$T - 0.0001559*$T2 - 0.00000048*$T*$T2; // mean anomaly, degree
	$L0 = 280.46645 + 36000.76983*$T + 0.0003032*$T2; // mean longitude, degree
	$DL = (1.914600 - 0.004817*$T - 0.000014*$T2)*sin($dr*$M);
	$DL = $DL + (0.019993 - 0.000101*$T)*sin($dr*2*$M) + 0.000290*sin($dr*3*$M);
	$L = $L0 + $DL; // true longitude, degree
	//echo "\ndr = $dr, M = $M, T = $T, DL = $DL, L = $L, L0 = $L0\n";
    // obtain apparent longitude by correcting for nutation and aberration
    $omega = 125.04 - 1934.136 * $T;
    $L = $L - 0.00569 - 0.00478 * sin($omega * $dr);
	$L = $L*$dr;
	$L = $L - M_PI*2*(floor($L/(M_PI*2))); // Normalize to (0, 2*PI)
	return floor($L/M_PI*6);
}
function get_lunar_month_11($yy, $time_zone) {
	$off = jd_from_date(31, 12, $yy) - 2415021;
	$k = floor($off / 29.530588853);
	$nm = get_new_moon_day($k, $time_zone);
	$sun_long = get_sun_longitude($nm, $time_zone); // sun longitude at local midnight
	if ($sun_long >= 9) {
		$nm = get_new_moon_day($k-1, $time_zone);
	}
	return $nm;
}
function get_leap_month_offset($a11, $time_zone) {
	$k = floor(($a11 - 2415021.076998695) / 29.530588853 + 0.5);
	$last = 0;
	$i = 1; // We start with the month following lunar month 11
	$arc = get_sun_longitude(get_new_moon_day($k + $i, $time_zone), $time_zone);
	do {
		$last = $arc;
		$i = $i + 1;
		$arc = get_sun_longitude(get_new_moon_day($k + $i, $time_zone), $time_zone);
	} while ($arc != $last && $i < 14);
	return $i - 1;
}
/* Comvert solar date dd/mm/yyyy to the corresponding lunar date */
function convert_solar_to_lunar($dd, $mm, $yy, $time_zone) {
	$day_number = jd_from_date($dd, $mm, $yy);
	$k = floor(($day_number - 2415021.076998695) / 29.530588853);
	$month_start = get_new_moon_day($k+1, $time_zone);
	if ($month_start > $day_number) {
		$month_start = get_new_moon_day($k, $time_zone);
	}
	$a11 = get_lunar_month_11($yy, $time_zone);
	$b11 = $a11;
	if ($a11 >= $month_start) {
		$lunar_year = $yy;
		$a11 = get_lunar_month_11($yy-1, $time_zone);
	} else {
		$lunar_year = $yy+1;
		$b11 = get_lunar_month_11($yy+1, $time_zone);
	}
	$lunar_day = $day_number - $month_start + 1;
	$diff = floor(($month_start - $a11)/29);
	$lunar_leap = 0;
	$lunar_month = $diff + 11;
	if ($b11 - $a11 > 365) {
		$leap_month_diff = get_leap_month_offset($a11, $time_zone);
		if ($diff >= $leap_month_diff) {
			$lunar_month = $diff + 10;
			if ($diff == $leap_month_diff) {
				$lunar_leap = 1;
			}
		}
	}
	if ($lunar_month > 12) {
		$lunar_month = $lunar_month - 12;
	}
	if ($lunar_month >= 11 && $diff < 4) {
		$lunar_year -= 1;
	}
	return array($lunar_day, $lunar_month, $lunar_year, $lunar_leap);
}
/* Convert a lunar date to the corresponding solar date */
function convert_lunar_to_solar($lunar_day, $lunar_month, $lunar_year, $lunar_leap, $time_zone) {
	if ($lunar_month < 11) {
		$a11 = get_lunar_month_11($lunar_year-1, $time_zone);
		$b11 = get_lunar_month_11($lunar_year, $time_zone);
	} else {
		$a11 = get_lunar_month_11($lunar_year, $time_zone);
		$b11 = get_lunar_month_11($lunar_year+1, $time_zone);
	}
	$k = floor(0.5 + ($a11 - 2415021.076998695) / 29.530588853);
	$off = $lunar_month - 11;
	if ($off < 0) {
		$off += 12;
	}
	if ($b11 - $a11 > 365) {
		$leap_off = get_leap_month_offset($a11, $time_zone);
		$leap_month = $leap_off - 2;
		if ($leap_month < 0) {
			$leap_month += 12;
		}
		if ($lunar_leap != 0 && $lunar_month != $leap_month) {
			return array(0, 0, 0);
		} else if ($lunar_leap != 0 || $off >= $leap_off) {
			$off += 1;
		}
	}
	$month_start = get_new_moon_day($k + $off, $time_zone);
	return jd_to_date($month_start + $lunar_day - 1);
}
function get_lunar_date($date = 'today', $formatted = false) {
	global $time_zone;
	$solar_year = date('Y', strtotime($date));
	$solar_month = date('m', strtotime($date));
	$solar_day = date('d', strtotime($date));
	$lunar_date = convert_solar_to_lunar($solar_day, $solar_month, $solar_year, $time_zone);
	return ($formatted == true) ? str_pad($lunar_date[2], 4, '0', STR_PAD_LEFT).'-'.str_pad($lunar_date[1], 2, '0', STR_PAD_LEFT).'-'.str_pad($lunar_date[0], 2, '0', STR_PAD_LEFT): $lunar_date;
}
function get_lunar_values($lunar_index, $lang = 'vi') {
	$stem_index = $lunar_index[0];
	$branch_index = $lunar_index[1];
	$stem = '';
	$branch = '';
	switch($lang) {
		case 'vi':
			switch($stem_index) {
				case 0:	$stem = 'Giáp'; break;
				case 1:	$stem = 'Ất'; break;
				case 2:	$stem = 'Bính'; break;
				case 3:	$stem = 'Đinh'; break;
				case 4:	$stem = 'Mậu'; break;
				case 5:	$stem = 'Kỷ'; break;
				case 6:	$stem = 'Canh'; break;
				case 7:	$stem = 'Tân'; break;
				case 8:	$stem = 'Nhâm'; break;
				case 9:	$stem = 'Quý'; break;
			}
			switch($branch_index) {
				case 0:	$branch = 'Tý';	break;
				case 1:	$branch = 'Sửu'; break;
				case 2:	$branch = 'Dần'; break;
				case 3:	$branch = 'Mẹo'; break;
				case 4:	$branch = 'Thìn'; break;
				case 5:	$branch = 'Tỵ';	break;
				case 6:	$branch = 'Ngọ'; break;
				case 7:	$branch = 'Mùi'; break;
				case 8:	$branch = 'Thân'; break;
				case 9:	$branch = 'Dậu'; break;
				case 10: $branch = 'Tuất'; break;
				case 11: $branch = 'Hợi'; break;
			}
			break;
		case 'en':
			switch($stem_index) {
				case 0:	$stem = 'Yang Wood'; break;
				case 1:	$stem = 'Yin Wood'; break;
				case 2:	$stem = 'Yang Fire'; break;
				case 3:	$stem = 'Yin Fire'; break;
				case 4:	$stem = 'Yang Earth'; break;
				case 5:	$stem = 'Yin Earth'; break;
				case 6:	$stem = 'Yang Metal'; break;
				case 7:	$stem = 'Yin Metal'; break;
				case 8:	$stem = 'Yang Water'; break;
				case 9:	$stem = 'Yin Water'; break;
			}
			switch($branch_index) {
				case 0:	$branch = 'Rat'; break;
				case 1:	$branch = 'Ox'; break;
				case 2:	$branch = 'Tiger'; break;
				case 3:	$branch = 'Cat'; break;
				case 4:	$branch = 'Dragon'; break;
				case 5:	$branch = 'Snake'; break;
				case 6:	$branch = 'Horse'; break;
				case 7:	$branch = 'Goat'; break;
				case 8:	$branch = 'Monkey'; break;
				case 9:	$branch = 'Rooster'; break;
				case 10: $branch = 'Dog'; break;
				case 11: $branch = 'Pig'; break;
			}
			break;
		case 'ru':
			switch($stem_index) {
				case 0:	$stem = 'Ян Дерево'; break;
				case 1:	$stem = 'Инь Дерево'; break;
				case 2:	$stem = 'Ян Огонь'; break;
				case 3:	$stem = 'Инь Огонь'; break;
				case 4:	$stem = 'Ян Земля'; break;
				case 5:	$stem = 'Инь Земля'; break;
				case 6:	$stem = 'Ян Металл'; break;
				case 7:	$stem = 'Инь Металл'; break;
				case 8:	$stem = 'Ян Вода'; break;
				case 9:	$stem = 'Инь Вода'; break;
			}
			switch($branch_index) {
				case 0:	$branch = 'Мышь'; break;
				case 1:	$branch = 'Корова'; break;
				case 2:	$branch = 'Тигр'; break;
				case 3:	$branch = 'Кролик'; break;
				case 4:	$branch = 'Дракон'; break;
				case 5:	$branch = 'Змея'; break;
				case 6:	$branch = 'Конь'; break;
				case 7:	$branch = 'Овца'; break;
				case 8:	$branch = 'Обезьяна'; break;
				case 9:	$branch = 'Петух'; break;
				case 10: $branch = 'Собака'; break;
				case 11: $branch = 'Свинья'; break;
			}
			break;
		case 'es':
			switch($stem_index) {
				case 0:	$stem = 'Yang Madera'; break;
				case 1:	$stem = 'Yin Madera'; break;
				case 2:	$stem = 'Yang Fuego'; break;
				case 3:	$stem = 'Yin Fuego'; break;
				case 4:	$stem = 'Yang Tierra'; break;
				case 5:	$stem = 'Yin Tierra'; break;
				case 6:	$stem = 'Yang Metal'; break;
				case 7:	$stem = 'Yin Metal'; break;
				case 8:	$stem = 'Yang Agua'; break;
				case 9:	$stem = 'Yin Agua'; break;
			}
			switch($branch_index) {
				case 0:	$branch = 'Rata'; break;
				case 1:	$branch = 'Buey'; break;
				case 2:	$branch = 'Tigre'; break;
				case 3:	$branch = 'Conejo'; break;
				case 4:	$branch = 'Dragón'; break;
				case 5:	$branch = 'Serpiente'; break;
				case 6:	$branch = 'Caballo'; break;
				case 7:	$branch = 'Oveja'; break;
				case 8:	$branch = 'Mono'; break;
				case 9:	$branch = 'Gallo'; break;
				case 10: $branch = 'Perro'; break;
				case 11: $branch = 'Cerdo'; break;
			}
			break;
		case 'zh':
			switch($stem_index) {
				case 0:	$stem = '甲'; break;
				case 1:	$stem = '乙'; break;
				case 2:	$stem = '丙'; break;
				case 3:	$stem = '丁'; break;
				case 4:	$stem = '戊'; break;
				case 5:	$stem = '己'; break;
				case 6:	$stem = '庚'; break;
				case 7:	$stem = '辛'; break;
				case 8:	$stem = '壬'; break;
				case 9:	$stem = '癸'; break;
			}
			switch($branch_index) {
				case 0:	$branch = '子';	break;
				case 1:	$branch = '丑';	break;
				case 2:	$branch = '寅';	break;
				case 3:	$branch = '卯';	break;
				case 4:	$branch = '辰';	break;
				case 5:	$branch = '巳';	break;
				case 6:	$branch = '午';	break;
				case 7:	$branch = '未';	break;
				case 8:	$branch = '申';	break;
				case 9:	$branch = '酉';	break;
				case 10: $branch = '戌'; break;
				case 11: $branch = '亥'; break;
			}
			break;
		case 'ja':
			switch($stem_index) {
				case 0:	$stem = 'こう'; break;
				case 1:	$stem = 'いつ'; break;
				case 2:	$stem = 'へい'; break;
				case 3:	$stem = 'てい'; break;
				case 4:	$stem = 'ぼ'; break;
				case 5:	$stem = 'き'; break;
				case 6:	$stem = 'こう'; break;
				case 7:	$stem = 'しん'; break;
				case 8:	$stem = 'じん'; break;
				case 9:	$stem = 'き'; break;
			}
			switch($branch_index) {
				case 0:	$branch = 'ね'; break;
				case 1:	$branch = 'うし'; break;
				case 2:	$branch = 'とら'; break;
				case 3:	$branch = 'う'; break;
				case 4:	$branch = 'たつ'; break;
				case 5:	$branch = 'み';	break;
				case 6:	$branch = 'うま'; break;
				case 7:	$branch = 'ひつじ'; break;
				case 8:	$branch = 'さる'; break;
				case 9:	$branch = 'とり'; break;
				case 10: $branch = 'いぬ'; break;
				case 11: $branch = 'い'; break;
			}
			break;
	}
	return array($stem, $branch);
}
function get_leap_value($lang = 'vi') {
	$leap_value = '';
	switch($lang) {
		case 'vi': $leap_value = 'nhuận'; break;
		case 'en': $leap_value = 'leap'; break;
		case 'ru': $leap_value = 'високосный'; break;
		case 'es': $leap_value = 'bisiesto'; break;
		case 'zh': $leap_value = '闰'; break;
		case 'ja': $leap_value = '閏'; break;
	}
	return $leap_value;
}
function get_lunar_year($date = 'today', $lang = 'vi') {
	$lunar_date = get_lunar_date($date);
	$lunar_year = $lunar_date[2];
	$stem_index = ($lunar_year+6)%10;
	$branch_index = ($lunar_year+8)%12;
	$lunar_values = get_lunar_values(array($stem_index, $branch_index), $lang);
	$stem = $lunar_values[0];
	$branch = $lunar_values[1];
	return (($stem != '' && $branch != '') ? $stem.' '.$branch.' - ': '').$lunar_year;
}
function get_lunar_month($date = 'today', $lang = 'vi') {
	$lunar_date = get_lunar_date($date);
	$lunar_year = $lunar_date[2];
	$lunar_month = $lunar_date[1];
	$lunar_leap = $lunar_date[3];
	$stem_index = ($lunar_year*12+$lunar_month+3)%10;
	$branch_index = ($lunar_month+1)%12;
	$lunar_values = get_lunar_values(array($stem_index, $branch_index), $lang);
	$stem = $lunar_values[0];
	$branch = $lunar_values[1];
	return (($stem != '' && $branch != '') ? $stem.' '.$branch.' - ': '').$lunar_month.(($lunar_leap == 1) ? ' '.get_leap_value($lang): '');
}
function get_lunar_day($date = 'today', $lang = 'vi') {
	$lunar_date = get_lunar_date($date);
	$lunar_day = $lunar_date[0];
	$solar_year = date('Y', strtotime($date));
	$solar_month = date('m', strtotime($date));
	$solar_day = date('d', strtotime($date));
	$jd = jd_from_date($solar_day, $solar_month, $solar_year);
	$stem_index = ($jd+9)%10;
	$branch_index = ($jd+1)%12;
	$lunar_values = get_lunar_values(array($stem_index, $branch_index), $lang);
	$stem = $lunar_values[0];
	$branch = $lunar_values[1];
	return (($stem != '' && $branch != '') ? $stem.' '.$branch.' - ': '').$lunar_day;
}
function get_lunar_years_old($dob, $date = 'today') {
	$lunar_date = get_lunar_date($date);
	$lunar_year = $lunar_date[2];
	$lunar_birth_date = get_lunar_date($dob);
	$lunar_birth_year = $lunar_birth_date[2];
	return $lunar_year-$lunar_birth_year;
}
function render_rss_feed($rss_url,$feed_header,$feed_id) {
	$result = '<section id="'.$feed_id.'" class="rss_feed">';
	$result .= '<h2>'.$feed_header.'</h2>';
	$result .= '<div class="help help_rss_feed"><i class="m-icon-white"></i></div>';
	$result .= '<div class="feed"></div>';
	$result .= '</section>';
	$result .= '<span id="'.$feed_id.'_end"></span>';
	$result .= '<script>
				loadFeed("'.$rss_url.'","'.$feed_id.'");
				$("#'.$feed_id.' > h2").on("click", function(){
					$("body, html").animate({scrollTop: $("#'.$feed_id.'_end").offset().top}, 700);
				});
				</script>';
	echo $result;
}
function load_rss_feed($rss_url) {
	$rss = new Rss;
	$feed = $rss->getFeed($rss_url, Rss::XML);
	$result = '';
	foreach($feed as $item) {
		$result .= '<div class="feed_item">';
		$result .= '<a target="_blank" class="item_title rotate" href="'.$item['link'].'"><span data-title="'.$item['title'].'">'.$item['title'].'</span></a>';
		$result .= '<p class="item_date">'.$item['date'].'</p>';
		$result .= '<div class="item_desc">'.$item['description'].'</div>';
		$result .= '</div>';
	}
	echo $result;
}