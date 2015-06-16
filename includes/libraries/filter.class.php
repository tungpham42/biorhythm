<?php
class filter {
	function __construct($num) {
			$this->num = $num;
	}
	function filter_keyword($a) { //Call back function to filter array by fullname
		if (isset($a['name']) && isset($a['dob'])) {
			if (preg_match('/'.preg_quote($this->num,'/').'/i',$a['name']) || preg_match('/'.preg_quote($this->num,'/').'/i',$a['dob'])) {
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