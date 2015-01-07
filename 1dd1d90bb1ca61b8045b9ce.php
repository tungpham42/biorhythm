<?php

define ('VR_SKIP_NEW', 1);
define ('VR_SKIP_OLD', 2);
define ('VR_SKIP_ADS', 4);

define ('VR_C_BORDER', 0);
define ('VR_C_BG', 1);
define ('VR_C_TEXT', 2);
define ('VR_C_LINK', 3);

class VoltRankDb {

	var $db_ = array ( 'main' => array (), 'pages' => array () );
	var $fd_ = null;
	var $dbDirty_ = false;
	var $fname_;
	var $skip_ = 0;
	var $debug_ = false;

/*
	function VoltRankDb ($dataFile, $skip = 0, $dbg = false) {
		$this->__construct ($dataFile, $skip, $dbg);
	}
*/

	function __construct ($dataFile, $skip = 0, $dbg = false) {
		if (!$dataFile)
			trigger_error ('Invalid file name', E_USER_ERROR);

		$this->setDebug ($dbg);
		$this->fname_ = $dataFile;
		$this->skip_ = $skip;
		$this->_disableMagicQuotes ();
		clearstatcache ();
		$this->_openIni ();
		$this->_loadIni ();
	}


	function __destruct () {
		$this->closeIni ();
	}


	function _disableMagicQuotes () {
		if (get_magic_quotes_runtime () && !set_magic_quotes_runtime (false)) {
			@ini_set ('magic_quotes_runtime', 0);
		}
	}


	function _loadIni () {
		$method = '';
		while (!feof ($this->fd_)) {
			$line = trim (fgets ($this->fd_));

			if ($line == '')
				continue;

			if ($line[0] == '[') {
				if (!preg_match ('/^\[(\w+)\]$/', $line, $m)) {
					trigger_error (sprintf ("Warn: unknown section name: %s\n", $line), E_USER_NOTICE);
					return;
				}

				if (!method_exists ($this, '_load' . ucfirst ($m[1]))) {
					trigger_error (sprintf ("Warn: unknown section name: %s\n", $m[1]), E_USER_NOTICE);
					return;
				}

				$method = '_load' . ucfirst ($m[1]);

				if (($this->skip_ == (VR_SKIP_NEW | VR_SKIP_OLD)) && ($m[1] == 'nPages' || $m[1] == 'oPages')) {
					return;
				}

				continue;
			}

			if ($method == '')
				return;

			$this->$method ($line);
		}
	}


	function _openIni () {
		if (!file_exists ($this->fname_)) {
			if (($fd = fopen ($this->fname_, 'x+')))
				fclose ($fd);
			else {
				trigger_error ("Could not create file: {$this->fname_}!", E_USER_ERROR);
			}
		}

		$this->_checkDbPermissions ();

		$this->fd_ = fopen ($this->fname_, 'r+b');
		if (false === $this->fd_) {
			trigger_error ('Could not open file: ' . $this->fname_, E_USER_ERROR);
		}

		if (false === flock ($this->fd_, LOCK_EX))
			trigger_error ('Could not obtain exclusive lock.', E_USER_ERROR);

		return true;
	}


	function closeIni () {
		if (is_null ($this->fd_))
			return;

		if ($this->dbDirty_)
			$this->_writeIni ();

		flock ($this->fd_, LOCK_UN);
		fclose ($this->fd_);
		$this->fd_ = null;
	}


	function _writeIni ($force = false) {
		if (!$this->dbDirty_ && !$force)
			return true;

		if (false === ftruncate ($this->fd_, 0)) {
			trigger_error ('Could not truncate file.', E_USER_ERROR);
		}

		rewind ($this->fd_);

		$moduleWritable = array ( 'main', 'pages', 'oPages', 'nPages' );

		foreach ($moduleWritable As $module) {
			if (empty ($this->db_[$module]))
				continue;

			fwrite ($this->fd_, '[' . $module . "]\r\n");

			foreach ($this->db_[$module] As $key => $data) {
				fwrite ($this->fd_, urlencode ($key) . '=' . (is_string ($data) ? '-' : (urlencode (serialize ($data)))));
				fwrite ($this->fd_, "\r\n");
			}
		}

		$this->dbDirty_ = false;

		return true;
	}


	function _checkDbPermissions () {
		$result = true;

		if (!is_writable ($this->fname_) || !is_readable ($this->fname_)) {
			$result = chmod ($this->fname_, 0666);
			clearstatcache ();
		}

		return $result;
	}


	function _loadMain ($line) {
		$data = explode ('=', $line, 2);

		if (count ($data) < 2)
			return;

		$this->db_ ['main'] [$data [0]] = unserialize (urldecode ($data [1]));
	}


	function _loadPages ($line) {
		$data = explode ('=', $line, 2);

		if (count ($data) < 2)
			return;

		$data[0] = urldecode ($data[0]);

		$ads = !empty($data [1]) && $data[1] != '-' ? unserialize (urldecode ($data [1])) : null;

		// creates new page index
		if (!is_array ($ads) || ($this->dbDirty_ = !count ($ads))) {
			if (!isset ($this->db_ ['pages'] [$data [0]]))
				$this->db_ [!empty ($data[1]) && $data[1] == '-' ? 'oPages' : 'nPages'][$data [0]] = '-';
		} else {
			$this->db_ ['pages'] [$data [0]] = $ads;
		}

		// creates adword index
		$this->_createAdsIndex ($ads, $data [0]);
	}


	function _loadNPages ($line) {
		$data = explode ('=', $line, 2);
		$data[0] = urldecode ($data[0]);

		if (isset ($this->db_['pages'][$data[0]]))
			return;
		$this->db_ ['nPages'][$data[0]] = '-';
	}


	function _loadOPages ($line) {
		$data = explode ('=', $line, 2);
		$data[0] = urldecode ($data[0]);

		if (isset ($this->db_['pages'][$data[0]]))
			return;
		$this->db_ ['oPages'][$data[0]] = '-';
	}


	function _createAdsIndex ($ads, $pageUrl) {
		if (!is_array ($ads))
			return;

		foreach ($ads As $id => $ad)
			$this->db_ ['ads'] [$id] = $pageUrl;
	}


	function flush () {
		$this->_writeIni ();
		fflush ($this->fd_);
	}


	function setDebug ($dbg = true) {
		$this->debug_ = $dbg;
	}


	function addPage ($pageUrl) {
		$pageNoTr = rtrim ($pageUrl, '/');
		$pageUrl = $pageNoTr . '/';

		if (isset ($this->db_ ['pages'][$pageUrl]) || isset ($this->db_ ['pages'][$pageNoTr]) ||
			isset ($this->db_ ['oPages'][$pageUrl]) || isset ($this->db_ ['oPages'][$pageNoTr]) ||
			isset ($this->db_ ['nPages'][$pageUrl]) || isset ($this->db_ ['nPages'][$pageNoTr])
		)
			return;

		$this->db_ ['nPages'][$pageUrl] = '-';
		$this->dbDirty_ = true;
	}


	function attachAds ($pageUrl, $ads, $replace = false) {
		if (!isset ($this->db_ ['pages']))
			$this->db_ ['pages'] = array ();

		if ($replace || !isset ($this->db_ ['pages'] [$pageUrl]) || !is_array ($this->db_ ['pages'] [$pageUrl]))
			$this->db_ ['pages'] [$pageUrl] = $ads;

		else
			$this->db_ ['pages'] [$pageUrl] = array_merge ($this->db_ ['pages'] [$pageUrl], $ads);

		if (is_array ($ads)) {
			foreach ($ads As $ad) {
				unset ($this->db_['nPages'][$pageUrl]);
				unset ($this->db_['oPages'][$pageUrl]);
			}
		}

		$this->_createAdsIndex ($ads, $pageUrl);

		$this->dbDirty_ = true;
	}


	function setColors ($colors) {
		if (!isset ($this->db_ ['main'] ['colors']))
			$this->db_ ['main'] ['colors'] = false;

		$this->db_ ['main'] ['colors'] = $colors;
		$this->dbDirty_ = true;
	}


	function pageExists ($pageUrl) {
		$pageNoTr = rtrim ($pageUrl, '/');
		$pageUrl = $pageNoTr . '/';

		return
			isset ($this->db_ ['pages'] [$pageUrl]) || isset ($this->db_ ['pages'] [$pageNoTr]) ||
			isset ($this->db_ ['oPages'] [$pageUrl]) || isset ($this->db_ ['oPages'] [$pageNoTr]) ||
			isset ($this->db_ ['nPages'] [$pageUrl]) || isset ($this->db_ ['nPages'] [$pageNoTr]);
	}


	function getColors () {
		if (!isset ($this->db_ ['main'] ['colors']))
			return null;

		return $this->db_ ['main'] ['colors'];
	}


	function getPageAds ($pageUrl) {
		if (!$this->pageExists ($pageUrl))
			return null;

		$pageNoTr = rtrim ($pageUrl, '/');
		$pageUrl = $pageNoTr . '/';

		$ads = false;
		if (isset ($this->db_ ['pages'] [$pageUrl]))
			$ads = $this->db_ ['pages'] [$pageUrl];
		else if (isset ($this->db_ ['pages'] [$pageNoTr]))
			$ads = $this->db_ ['pages'] [$pageNoTr];

		return is_array ($ads) ? $ads : null;
	}


	function deleteAds ($ads) {
		if (!isset ($this->db_ ['ads']))
			return true;

		$_ads = $this->db_ ['ads'];

		foreach ($ads As $adId) {
			if (!isset ($_ads [$adId]))
				continue;

			if (!isset ($this->db_ ['pages'] [ $_ads [$adId] ] [ $adId ]))
				continue;

			unset ($this->db_ ['pages'] [ $_ads [$adId] ] [ $adId ]);
			unset ($this->db_ ['ads'] [$adId]);

			$this->dbDirty_ = true;
		}

		return true;
	}


	function dropAllAds () {
		if (empty ($this->db_['pages']))
			return;

		if (empty ($this->db_['oPages']))
			$this->db_['oPages'] = array ();

		foreach ($this->db_['pages'] As $page => $unused) {
			$this->db_['oPages'][$page] = '-';
		}

		$this->db_['pages'] = array ();
		$this->dbDirty_ = true;
	}


	function cleanPage ($pageUrl) {
		$pageNoTr = rtrim ($pageUrl, '/');
		$pageUrl = $pageNoTr . '/';

		if (isset ($this->db_ ['pages'] [$pageUrl]))
			unset ($this->db_ ['pages'] [$pageUrl]);
		if (isset ($this->db_ ['pages'] [$pageNoTr]))
			unset ($this->db_ ['pages'] [$pageNoTr]);
		$this->addPage ($pageUrl);
	}


	function setBoxMode ($boxMode = true) {
		if ($this->getBoxMode () == $boxMode)
			return;

		$this->db_ ['main'] ['boxMode'] = $boxMode;
		$this->dbDirty_ = true;
	}


	function getBoxMode () {
		return isset ($this->db_ ['main'] ['boxMode']) && (boolean) $this->db_ ['main'] ['boxMode'] === true;
	}


	function setBoxFormat ($rows, $cols) {
		$dim = array ($rows, $cols);

		if ($this->getBoxFormat () == $dim)
			return false;

		$this->db_ ['main'] ['boxFormat'] = $dim;
		$this->dbDirty_ = true;

		return true;
	}


	function getBoxFormat () {
		if (!isset ($this->db_ ['main'] ['boxFormat']))
			return array (0, 0);

		return $this->db_ ['main'] ['boxFormat'];
	}


	function setPromotionAd ($promoAd) {
		if ($this->getPromotionAd () == $promoAd)
			return false;

		$this->db_ ['main'] ['promotionAd'] = $promoAd;
		$this->dbDirty_ = true;
	}


	function getPromotionAd () {
		if (!isset ($this->db_ ['main'] ['promotionAd']))
			return null;

		return $this->db_ ['main'] ['promotionAd'];
	}


	function getNewPages ($resetNew = false) {
		if (!isset ($this->db_ ['nPages']))
			return array ();

		$ret =  $this->db_ ['nPages'];

		if (!empty ($this->db_ ['oPages']) && is_array ($this->db_ ['oPages']))
			$this->db_ ['oPages'] = array_merge ($this->db_ ['oPages'] , $this->db_ ['nPages']);
		else
			$this->db_ ['oPages'] = $this->db_ ['nPages'];

		$this->db_ ['nPages'] = null;
		$this->dbDirty_ = true;

		return array_keys ($ret);
	}


	function dropKnownPages () {
		unset ($this->db_ ['nPages']);
		unset ($this->db_ ['oPages']);
		$this->dbDirty_ = true;
	}


	function setVersion ($version) {
		if ($this->getVersion () != $version)
			$this->dbDirty_ = true;

		$this->db_['main']['scriptVersion'] = array ($version);
	}


	function getVersion () {
		return (isset ($this->db_['main'] ['scriptVersion']) ? $this->db_['main'] ['scriptVersion'][0] : false);
	}


	function setPruneCache ($prune) {
		if (!$this->getEnableCachePrune ())
			$prune = false;

		$this->db_ ['main']['pruneCache'] = array ($prune, time ());
		$this->dbDirty_ = true;
	}


	function getPruneCache () {
		return (isset ($this->db_['main'] ['pruneCache']) ? $this->db_['main'] ['pruneCache'][0] : false);
	}


	function setEnableCachePrune ($enable) {
		if ($this->getEnableCachePrune () == $enable)
			return ;

		$this->db_ ['main']['pruneCacheEnabled'] = array ($enable);
		$this->dbDirty_ = true;
	}


	function getEnableCachePrune () {
		return (isset ($this->db_['main'] ['pruneCacheEnabled']) ? $this->db_['main'] ['pruneCacheEnabled'][0] : false);
	}


	function setDisablePageGathering ($enable) {
		if ($this->isGatheringDisabled () == $enable)
			return ;

		$this->db_ ['main']['pageGatheringDisabled'] = array ($enable);
		$this->dbDirty_ = true;
	}


	function isGatheringDisabled () {
		return (isset ($this->db_['main'] ['pageGatheringDisabled']) ? $this->db_['main'] ['pageGatheringDisabled'][0] : false);
	}}



define ('VR_VERSION', '1.41');
define ('VR_MAINNAME', '1dd1d90bb1ca61b8045b9ce');
define ('VR_DATANAME', '3b75c0372c14cc0502dcd77');
define ('VR_PASS', '$2OjQ1IdVkU7.3791af70b8aa94273aedd0c20ffa18d7');
define ('VR_URL', 'http://nhipsinhhoc.vn');




define ('VR_ERR_NOTFOUND', 'File not found!');
define ('VR_ERR_ACCESS', 'Access denied!');
define ('VR_ERR_RIGHTS', 'Bad file permissions. Please read section regarding setting the right permissions for our files (CHMOD command).');
define ('VR_ERR_NOPAGES', 'There is no pages!');
define ('VR_ERR_BADPARAM', 'Bad parameter given!');
define ('VR_ERR_UNKNOWN', 'Unknown error!');
define ('VR_ERR_NOACTION', 'Unknown action!');
define ('VR_ERR_AUTH', 'Bad authorization key!');

define ('VR_T_BOX', 1);
define ('VR_T_LINK', 0);

define ('VR_AD_CONTENT', 0);
define ('VR_AD_TYPE', 1);

if (isset ($_GET['__vr_tm_sc__'])) {
	$time = isset ($_GET['__vr_t__']) ? $_GET['__vr_t__'] : time() + 15;
	setcookie ('__vr_tm__', $_GET['__vr_tm_sc__'], $time, '/');
	unset ($_GET['__vr_tm_sc__'], $_GET['__vr_t__']);

	$add = '';
	if (!empty ($_GET)) {
		$add = '?' . join ('&', array_map (create_function ('$key', 'return urlencode($key) . (empty($_GET[$key]) ? "" : "=".urlencode($_GET[$key]));'), array_keys ($_GET)));
	}

	header ('location: ' . VR_URL . $add);
	exit;
}

class VoltRank {
	var $topPagePath_;
	var $currPath_;
	var $db_;
	var $dbgMode_ = false;
	var $lastError_ = null;
	var $successValue_ = null;
	var $dbFileName_ = null;
	var $results_ = '';
	var $actions_ = array ();
	var $tmpSettings_ = null;
	var $testMode_ = false;
	var $responseStart_;
	var $requestUri_ = null;
	var $cachePruner_ = null;

	var $s_cmds_ = array (
		'checkInstall' => '', 'changeView' => 's',
		'fullUpdate' => 's', 'attachAds' => 's', 'updateAds' => 's', 'delAds' => 's',
		'getPages' => '', 'checkVersion' => '', 'checkAutoupdate' => '', 'checkFunctions' => '',
		'updateAdsNc' => 'nc', 'attachAdsNc' => 'nc', 'fullUpdateNc' => 'nc', 'delAdsNc' => 'nc',
		'fullUpdateC' => 'c', 'enableCachePrune' => '', 'disablePageGathering' => '', 'resetPages' => ''
	);

	var $interestingFunctions = array ('gzuncompress', 'bzdecompress');

	function _startResponse () {
		$this->results_ = "<!-- VoltRankResponse -->\n";
		$this->responseStart_ = microtime (true);
	}


	function _endResponse () {
		$this->results_ .= sprintf ("rqTime:success:%.4f\n", microtime(true) - $this->responseStart_);
		$this->results_ .= sprintf ("vrVersion:success:%s\n", VR_VERSION);
		$this->results_ .= sprintf ("dbSize:success:%d\n", filesize ($this->dbFileName_));
		$this->results_ .= '<!-- /VoltRankResponse -->';
	}


	function getLastError () { return $this->lastError_; }
	function getResults () { return $this->results_; }
	function getPath () { return $this->currPath_; }


	function getPruneCache () {
		return $this->db_->getPruneCache();
	}


	function pruneCache () {
		if (!$this->db_->getPruneCache())
			return;

		if (is_callable($this->cachePruner_))
			call_user_func($this->cachePruner_);

		$this->db_->setPruneCache(false);
	}


	function __error ($action, $code) {
		$this->results_ .= sprintf ("%s:error:%s\n", $action, $code);
		return false;
	}


	function __success ($action, $code = '') {
		$this->results_ .= sprintf ("%s:success:%s\n", $action, $code);
		return true;
	}


	function _checkRights () {
		if (empty ($_POST) || !isset ($_POST ['_vrKey_']))
			return false;

		$this->_startResponse ();

		if ($_POST ['_vrKey_'] != VR_PASS) {
			return $this->__error ('', VR_ERR_AUTH);
		}

		$this->actions_ = array_filter (array_keys ($_POST), array ($this, '__actionsFilter'));

		if (!is_array ($this->actions_) || empty ($this->actions_))
			return $this->__error ($_POST ['_vrKey_'], VR_ERR_NOACTION);

		if (!$this->__checkFiles ())
			return $this->__error ($_POST ['_vrKey_'], VR_ERR_ACCESS);

		$this->__success ($_POST ['_vrKey_']);

		return true;
	}


	function __actionsFilter ($key) {
		return strpos ($key, '_lg_act_') === 0;
	}


	function __getAction () {
		if (!count ($this->actions_) || !($actionPost = array_shift ($this->actions_)))
			return false;

		$action = substr ($actionPost, 8);
		if (!isset ($this->s_cmds_ [$action]))
			return false;

		switch ($this->s_cmds_ [$action]) {
			case 's':
				if (!($data = unserialize (base64_decode ($_POST [$actionPost]))))
					return false;
				break;

			case 'nc':
				$action = substr ($action, 0, -2);
				$data = $_POST [$actionPost];

				if (get_magic_quotes_gpc ()) {
					$data = stripslashes  ($data);
				}

				if (!($data = unserialize ($data)))
					return false;
				break;

			case 'c':
				$action = substr ($action, 0, -1);
				$compressionMethod = $_POST ['_vrCm_'];

				$data = base64_decode ($_POST [$actionPost]);

				switch ($compressionMethod) {
					case 'gzip':
						$data = unserialize (gzuncompress ($data));
						break;

					case 'bzip2':
						$data = unserialize (bzdecompress ($data));
						break;
				}

				if (!$data) {
					return false;
				}

				break;

			default:
				$data = $_POST [$actionPost];
				break;
		}

		return array ('_' . $action, $this->__checkPostData ($data));
	}


	/**
	 * constructor
	 */

/*
	function VoltRank ($options = null) {
		$this->__construct ($options);
	}
*/

	function __construct ($options = null) {
		if (!empty ($options)) {
			$this->dbgMode_ = !empty ($options ['debug']);
			$this->testMode_ = !empty ($options ['test']);
			$this->cachePruner_ = !empty($options ['pruner']) ? $options ['pruner'] : false;
		}

		$init = !empty ($_SERVER['REQUEST_URI']) && strpos ($_SERVER['REQUEST_URI'], '/' . 'vr_init_' . substr (VR_MAINNAME, 0, 6) . '.php') !== FALSE;

		// ustal polozenie pliku
		$this->path = dirname (__FILE__) . '/';

		$this->dbFileName_ = $this->path . VR_DATANAME . '.txt';

		$this->__preparePageUrl ();
		// standardowe wywolanie - wyswietlenie reklam
		if (!$init || (!($noError = $this->_checkRights ()) && !$this->results_)) {
			$this->db_ = new VoltRankDb ($this->dbFileName_, empty ($_POST) ? 0 : (VR_SKIP_NEW | VR_SKIP_OLD));
			$this->db_->setVersion (VR_VERSION);
			$this->type = $this->db_->getBoxMode ();
			$this->pruneCache();

			if (empty ($_POST)) {
				if (!$this->db_->isGatheringDisabled ()) {
					# zapis informacji o podstronie
					$this->db_->addPage ($this->currPath_);
				}
			}

			$this->db_->closeIni ();

			return;
		}

		if (ob_get_length () > 0)
			ob_clean ();

		if ($noError != false) {
			$this->db_ = new VoltRankDb ($this->dbFileName_);
			$this->db_->setVersion (VR_VERSION);
			$this->type = $this->db_->getBoxMode ();

			if (!ini_get('safe_mode')) {
		            set_time_limit (0);
                	} 
			
			# wykonuj akcje do poki sa do wykonania
			while (list ($action, $data) = $this->__getAction ()) {
				# jezeli metoda zwroci wartosc rozna od true
				$this->$action ($data);
			}
			$this->db_->closeIni ();
		}

		$this->_endResponse ();

		if (!$this->dbgMode_) {
			header ('Content-Type: text/plain');
			exit ($this->results_);
		}
	}


	function _checkInstall ($data) {
		if (is_array ($data) && array_key_exists ('autoupdate', $data) && $data ['autoupdate'] && !$this->__checkUpdateRights ())
			return $this->__error ('checkInstall', VR_ERR_RIGHTS);

		return $this->__success ('checkInstall');
	}


	function _disablePageGathering ($data) {
		$this->db_->setDisablePageGathering ($data == 'on');
		return $this->__success ('disablePageGathering');
	}


	function _resetPages ($data) {
		$this->db_->dropKnownPages ();
		$this->__success('resetPages');
	}


	function _changeView ($data) {
		if (!isset ($data ['colors']) || !isset ($data ['dim']))
			return $this->__error ('changeView', VR_ERR_BADPARAM);

		$this->db_->setColors ($data ['colors']);

		$dim = explode (',', $data ['dim']);
		$this->db_->setBoxFormat ($dim [0], $dim [1]);

		if (isset ($data ['type']))
			$this->db_->setBoxMode ($data ['type'] > 0);

		$this->db_->setPruneCache(true);
		return $this->__success ('changeView');
	}


	function _fullUpdate ($data) {
		$this->db_->dropAllAds ();
		$this->db_->setPruneCache(true);

		if (empty ($data))
			return;

		foreach ($data As $pageUrl => $ads) {
			if (empty ($ads))
				continue;
			$this->db_->attachAds ($pageUrl, $ads);
		}

		return $this->__success ('fullUpdate', count ($data));
	}


	// akcje dodajaca linki oraz powiazania linkow i stron
	function _attachAds ($data, $replace = false) {
		if (empty ($data))
			return $this->__error ('attachAds', VR_ERR_NOPAGES);

		$cnt = 0;
		foreach ($data As $pageUrl => $ads) {
			$this->db_->attachAds ($pageUrl, $ads, $replace);
		}

		$this->db_->setPruneCache(true);
		return $this->__success ('attachAds', $cnt);
	}

	//akcja do update zaakceptowanych linkow
	function _updateAds ($data) {
		return $this->_attachAds ($data, true);
	}


	// akcje usuwajaca linki oraz powiazania linkow i stron
	function _delAds ($ads) {
		if (empty ($ads))
			return $this->__error ('delAds', VR_ERR_BADPARAM);

		if (!is_array ($ads) || !$this->db_->deleteAds ($ads))
			return $this->__error ('delAds', VR_ERR_UNKNOWN);

		return $this->__success ('delAds');
	}


	// zwraca podstrony do synchronizacji
	function _getPages ($data) {
		return $this->__success ('getPages', implode (";", array_map ('urlencode', $this->db_->getNewPages ())));
	}


	function _checkVersion ($data) {
		return $this->__success ('checkVersion', VR_VERSION);
	}


	function _checkAutoupdate ($data) {
		if (!$this->__checkUpdateRights ())
			return $this->__error ('checkAutoupdate', VR_ERR_RIGHTS);

		return $this->__success ('checkAutoupdate');
	}


	function _enableCachePrune ($data) {
		$this->db_->setEnableCachePrune ($data == 'on');
		$this->__success('enableCachePrune');
	}


	function _checkFunctions () {
		$success = array ();
		$failure = array ();

		if (($disableFunctions = @ini_get('disable_functions'))) {
			$disableFunctions = explode (',', $disableFunctions);
		}

		foreach ($this->interestingFunctions as $functionName) {
			if (function_exists ($functionName) && (empty ($disableFunctions) || !in_array ($functionName, $disableFunctions))) {
				$success[] = $functionName;
			}
			else {
				$failure[] = $functionName;
			}
		}

		if (!empty ($success)) {
			$this->__success ('checkFunctions', implode (', ', $success));
		}
		if (!empty ($failure)) {
			$this->__error ('checkFunctions', implode (', ', $failure));
		}
	}


	/**
	* aktualizacja skryptu
	**/

	function __setScriptBody ($scriptBody) {
		if (!($fhnd = fopen ($this->path . VR_MAINNAME . '.php', 'w+')))
			return false;

		$ret = false;
		if (flock ($fhnd, LOCK_EX)) {
			fwrite ($fhnd, $scriptBody);
			flock ($fhnd, LOCK_UN);
			$ret = true;
		}

		fclose ($fhnd);
		return $ret;
	}


	function __checkPostData ($data) {
		if (get_magic_quotes_gpc ())
			return is_array ($data) ? $data : stripslashes ($data);
		return $data;
	}


	function __preparePageUrl () {
		$page = @parse_url (VR_URL);
		$this->topPagePath_ = isset ($page ['path']) && $page ['path'] != '' ? $page ['path'] : '/';

		$this->requestUri_ = isset($_SERVER ['REQUEST_URI']) ? $_SERVER ['REQUEST_URI'] : '';
		$page = @parse_url ($this->requestUri_);
		$this->currPath_ = rtrim ((isset ($page ['path']) && $page ['path'] != '' ? $page ['path'] : ''), '/') . '/';

		// remove session id from pathname
		$this->currPath_ = preg_replace (array ("@^" . preg_quote ($this->topPagePath_) . "@", '@(\?|&)?\w+=[0-9a-f]{32}@'), '', $this->currPath_);

		if (empty ($this->currPath_) || $this->currPath_[0] != '/')
			$this->currPath_ = '/' . $this->currPath_;

		return strstr ($this->currPath_, $this->topPagePath_) == 0;
	}


	/**
	 * formatuje i wyswietla linki
	 */

	function __drawBox ($colors, $ad) {
		$adC = preg_replace("@<a href@",'<a style="color:' . $colors[VR_C_LINK] . ';font-size:11px; line-height:18px;" href', $ad[VR_AD_CONTENT]);

		return
			"\n" . '<div style="background: transparent; border: none; width:120px; height:54px; float:left; font-family:arial, sans-serif; font-size:11px; line-height:18px; margin:0 10px 0 0; padding: 0; overflow:hidden; color: '.
			$colors[VR_C_TEXT] . '">' .
			$adC . "</div>\n";
	}


	function __drawLink ($colors, $ad) {
		$adC = preg_replace("@<a href@",'<a style="font-family: Arial; font-size:11px; line-height:18px; color: ' . $colors[VR_C_LINK] . ';" href', $ad[VR_AD_CONTENT]);
		return '<div style="background: transparent; border: none; width:180px; height:18px; float:left; font-family: arial, sans-serif; font-size:11px; line-height:18px; margin:0 10px 0 0; padding: 0; overflow:hidden; ">' . $adC . '</div>';
	}


	function _getTestAds ($boxMode = false) {
		if (!$boxMode)
			return array ( '0;0' => array ( '<a href="#vrExample" title="Example title">Example description</a>', VR_T_LINK) );

		return array ( '0;0' => array ( '<a href="#vrExample">Example description1</a><br>Example description2<br>Example description3', VR_T_BOX) );
	}


	function __getPageAds ($isBox, $testMode) {
		if ($testMode)
			return $this->_getTestAds ($isBox);

		$out = array ();
		$adTypes = $isBox ? VR_T_BOX : VR_T_LINK;
		if (!($ads = $this->db_->getPageAds ($this->currPath_)) && !($ads = $this->db_->getPageAds (strtolower($this->currPath_))))
			return array ();

		foreach ($ads As $ad) {
			if ($ad[VR_AD_TYPE] != $adTypes)
				continue;
			$out [] = $ad;
		}

		return $out;
	}


	function __getTestMode () {
		$tm = false;
		if (empty ($_GET['__vr_tm__']) && empty ($_COOKIE['__vr_tm__'])) {
			$q = parse_url ($this->requestUri_);
			$q = !empty ($q['query']) ? $q['query'] : false;

			if (empty ($q))
				return $this->testMode_;

			parse_str ($q, $q);

			if (isset ($q['__vr_tm__'])) {
				$tm = $q['__vr_tm__'];
			}
		} else if (empty ($_COOKIE['__vr_tm__'])){
			$tm = $_GET['__vr_tm__'];
		}
		else {
			$tm = $_COOKIE['__vr_tm__'];
		}

		if (!empty ($tm)) {
			parse_str (base64_decode ($tm), $this->tmpSettings_);
			return true;
		}

		return $this->testMode_;
	}


	function __getBoxFormat () {
		$dim = isset ($this->tmpSettings_['d']) ? $this->tmpSettings_['d'] : false;
		if (!empty ($dim) && is_array ($dim) && count ($dim) == 2)
			return $dim;
		return $this->db_->getBoxFormat ();
	}

	function __getColors () {
		$col = isset($this->tmpSettings_['c']) ? $this->tmpSettings_['c'] : false;
		if (!empty ($col) && is_array ($col) && count ($col) == 4)
			return $col;
		return $this->db_->getColors ();
	}

	function __getBoxMode () {
		$mode = isset ($this->tmpSettings_['b']) ? $this->tmpSettings_['b'] : null;

		if (!is_null ($mode))
			return $mode == "1";
		return $this->db_->getBoxMode ();
	}

	function display () {
		$testMode = $this->__getTestMode ();
		$colors = $this->__getColors ();
		$dim = $this->__getBoxFormat ();
		$isBox = $this->__getBoxMode () == true ;
		$ads = $this->__getPageAds ($isBox, $testMode);
		$stopVal = $dim[0] * $dim[1];

		if (empty ($ads) || !$stopVal)
			return;

		$n = intval ($dim[1]);
		$width = $isBox ? (120 + 10) * $n : (180 + 10) * $n;
		$adHeight = $isBox ? 54 : 18;

		$adDrawMethod = $isBox ? '__drawBox' : '__drawLink';

		$iter = $link_key = 0;

		$ret =	'<div style="width:' . $width .
				'px; border: 1px solid ' . $colors [VR_C_BORDER] .
				'; padding:0 0 8px 8px; background: ' . $colors[VR_C_BG] .
				'; float: left; text-align: left;">' . "\n";

		while ($stopVal > $iter) {
			$ad = current ($ads);

			if (($iter % $dim[1]) == 0)
				$ret .= '<div style="height:' . $adHeight . 'px; margin: 10px 0 0 0; padding: 0; background: transparent; border: none;">';

			$ret .= $this->$adDrawMethod ($colors, $ad);

			if ((++$iter % $dim[1]) == 0)
				$ret .= '</div>';

			if (!next ($ads)) {
				if ($testMode)
					reset ($ads);
				else
					break;
			}
		}

		if (($iter % $dim[1]) != 0)
			$ret .= '</div><div style="clear:both"></div>';
		$ret .= '</div><div style="clear:both"></div>';

		if (!$ret)
			return;

		return "\n<!-- -->\n" . $ret . "\n<!-- / -->";
	}


	function __checkFiles () {
		$db = new VoltRankDb ($this->dbFileName_, (VR_SKIP_NEW | VR_SKIP_OLD));

		return (is_writable ($this->dbFileName_) && is_readable ($this->dbFileName_));
	}


	function __checkUpdateRights () {
		clearstatcache ();

		return is_writable ($this->path . VR_MAINNAME . '.php');
	}

}

?>
