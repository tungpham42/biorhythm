<?
// Class 'astro' v1.0 - Calculate the chaldean and chinese signs of a given date.
// Based upon a formula written by Paul Schlyter (.se)
// (c) Paris. 06 oct 2005. Pierre FAUQUE, pierre@fauque.net
// Released under the terms of the GNU Public License

class astro {

	//var $chaldeanZodiac = array("aries","taurus","gemini","cancer","leo","virgo","libra","scorpio","sagittarius","capricorn","aquarius","pisces");
	var $chaldeanZodiac = array("Aries","Taurus","Gemini","Cancer","Leo","Virgo","Libra","Scorpio","Sagittarius","Capricorn","Aquarius","Pisces");
	var $chineseZodiac  = array("monkey","rooster","dog","pig","rat","ox","tiger","rabbit","dragon","serpent","horse","goat");
	var $chaldeanSign   = "";
	var $chineseSign    = "";

	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	// Format date : AAAA-MM-JJ. (format not tested)
	function astro($date) {
		$idcha = $this->chaldeanSign($date);
		$idchi = $this->chineseSign($date);
		$this->chaldeanSign = $this->chaldeanZodiac[$idcha];
		$this->chineseSign  = $this->chineseZodiac[$idchi];
	}

	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	// Return an index for the given date in the chinese zodiac array.
	function chineseSign($date) { $td = explode("-",$date); return $td[0] % 12; }

	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	// Calculate the sun position.
	// Return an index for the given date in the chaldean zodiac array.
	function rev($x) { return $x-floor($x/360.0)*360.0; }
	function chaldeanSign($date) {
		$t = explode("-",$date);
		$d = (367*$t[0]-floor((7*($t[0]+floor(($t[1]+9)/12)))/4)
		     +floor((275*$t[1])/9)+$t[2]-730530);
		$w = $this->rev(282.9404+4.70935E-5*$d); $M=$this->rev(356.0470+0.9856002585*$d);
		return floor($this->rev($w+$M)/30.0);
	}
}
?>