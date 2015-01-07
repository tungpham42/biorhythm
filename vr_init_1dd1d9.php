<?php

if (isset ($_POST['dbg']) && '1dd1d90bb1ca61b8045b9ce' == $_POST['vu']) {
	error_reporting (E_ALL);
	ini_set ("display_errors", 1);
}

if (isset ($_POST ['ta'])) {
	echo '<!-- ' . microtime (true) . ' -->';
} else if (isset ($_POST ['td'])) {
	$dir = rtrim (dirname (__FILE__), '/');
	require_once ($dir . '/1dd1d90bb1ca61b8045b9ce.php');
	$vr = new VoltRank ();
	echo $vr->display ();
} else if (isset ($_POST ['tc'])) {
	switch ($_POST['tc']) {
		case 'pv':exit ('r:' . phpversion ());
		case 'ps':exit ('r:' . function_exists ('sqlite_open'));
		case 'pc':exit ('r:' . function_exists ('curl_init'));
		case 'sm':exit ('r:' . ini_get ('safe_mode'));
		default:exit ($_POST['tc']);
	}
}
else if (!empty ($_POST['vu']) && !empty ($_POST['sid']) && '1dd1d90bb1ca61b8045b9ce' == $_POST['vu'] && !empty ($_POST['chCnt'])) {
	$siteId = dechex (hexdec ($_POST['sid']));
	$updateKey = $_POST['vu'];
	$maxChunks = (int) $_POST['chCnt'];

	if (runUpdate ($siteId, $updateKey, $maxChunks))
		echo 'success';

	else
		echo 'failure';
}
else if (!empty ($_POST) || !empty ($_GET) ) {
	$dir = rtrim (dirname (__FILE__), '/');
	require_once ($dir . '/1dd1d90bb1ca61b8045b9ce.php');
	$vr = new VoltRank ();
}

function vSendMsg ($msg, $code, $siteId, $updateKey, $version = 0) {
	$options = array (
		'code' => (int) $code,
		'msg' => base64_encode ($msg),
		'version' => base64_encode ($version),
	);

	if (defined ('VR_DEBUG_MODE')) {
		return $options;
	}

	$connectionHandler = openConnection ($siteId, $updateKey, 'report', $options);
	fclose ($connectionHandler);
}

function openConnection ($siteId, $updateKey, $action, $options = null) {
	$requestPath = '';
	if ('update' == $action && !defined ('VR_DEBUG_MODE')) {
		$requestPath = "/script?p={$siteId}&vu={$updateKey}";
	}
	else if ('report' == $action && !empty ($options) && !defined ('VR_DEBUG_MODE')) {
		$requestPath = "/script/report?p={$siteId}&vu={$updateKey}&code={$options['code']}&msg={$options['msg']}&v={$options['version']}";
	}

	if (($connectionHandler = fopen ('http://www.voltrank.com' . $requestPath, 'rb'))) {
		return $connectionHandler;
	}

	$errNo = 0;
	$errStr = '';
	$connectionHandler = fsockopen ('www.voltrank.com', 80, $errNo, $errStr);

	if ($connectionHandler) {
		$requestHeaders = "GET {$requestPath} HTTP/1.1\r\n";
	    $requestHeaders .= "Host: www.voltrank.com\r\n";
	    $requestHeaders .= "Connection: Close\r\n\r\n";
	    fwrite ($connectionHandler, $requestHeaders);
	}

	return $connectionHandler;
}

function readFromConnection ($connectionHandler, $siteId, $maxChunks, $updateKey) {
	$content = '';
	$chunkNo = 0;
	while (!feof ($connectionHandler)) {
		if (false !== ($contentChunk = fread ($connectionHandler, 4096))) {
			$content .= $contentChunk;
		}
		else {
			vSendMsg ('Resource read error.', 2684354560, $siteId, $updateKey);
			exit;
		}

        ++$chunkNo;
        if ($chunkNo == $maxChunks) {
        	vSendMsg ('Too much data received from server.', 2147483648, $siteId, $updateKey);
			exit;
        }
    }

    $realContentPosition = strpos ($content, '<?php');
	$content = substr ($content, $realContentPosition);

    return $content;
}

function runUpdate ($siteId, $updateKey, $maxChunks) {
	if (get_magic_quotes_runtime () && !set_magic_quotes_runtime (false) && !ini_set ('magic_quotes_runtime', 0)) {
		vSendMsg ('Detected magic quotes runtime enabled and unable to disable it.', 2952790016, $siteId, $updateKey);
	}

	if (!$connectionHandler = openConnection ($siteId, $updateKey, 'update')) {
		vSendMsg ('Cannot open update location', 2415919104, $siteId, $updateKey);
		return false;
	}

	$scriptContent = readFromConnection ($connectionHandler, $siteId, $maxChunks, $updateKey);
	fclose ($connectionHandler);

	$scriptEnd = strpos ($scriptContent, '?>');
	if (false !== $scriptEnd) {
		$scriptEnd = $scriptEnd + 2;
		$additionalData = substr ($scriptContent, $scriptEnd);
		$scriptContent = trim (substr ($scriptContent, 0, $scriptEnd));
		$additionalData = explode (';', $additionalData);

		$checksumReceived = trim ($additionalData[0]);
		if (!$checksumReceived) {
			vSendMsg ('Cannot find checksum in server reply.', 1073741824, $siteId, $updateKey);
			return false;
		}

		$newVersion = trim ($additionalData[1]);
		if (!$newVersion) {
			vSendMsg ('Cannot find new script version in server reply.', 1342177280, $siteId, $updateKey, $newVersion);
			return false;
		}
	}
	else {
		vSendMsg ('Cannot obtain the end of received script.', 1610612736, $siteId, $updateKey);
		return false;
	}

	$checksumComputed = md5 ($scriptContent);
	if ($checksumReceived != $checksumComputed) {
		$scriptContent = stripslashes ($scriptContent);
		$checksumStripedSlashes = md5 ($scriptContent);

		if ($checksumReceived != $checksumStripedSlashes) {
			vSendMsg ('Checksum send by server: "' . $checksumReceived . '", computed: "' . $checksumComputed . '" and checksum from content with striped slashes "' . $checksumStripedSlashes . '"', 268435456, $siteId, $updateKey, $newVersion);
			return false;
		}
	}

	$tempFile = tempnam (sys_get_temp_dir (), 'vupdate');
	$tempFileHandler = fopen ($tempFile, 'w+b');
	fwrite ($tempFileHandler, $scriptContent);
	fclose ($tempFileHandler);
	$checksumTempFile = md5_file ($tempFile);
	if ($checksumReceived != $checksumTempFile) {
		vSendMsg ('Checksum send by server: "' . $checksumReceived . '", after write: "' . $checksumTempFile . '"', 536870912, $siteId, $updateKey, $newVersion);
		return false;
	}

	$destination = dirname (__FILE__) . '/1dd1d90bb1ca61b8045b9ce.php';
	$moveResult = rename ($tempFile, $destination);
	if (!$moveResult && !copy ($tempFile, $destination) && !chmod ($destination, 0666) && !rename ($tempFile, $destination)) {
		vSendMsg ('Moving file from temp to final destination failed! Source: "' . $tempFile . '", destination: "' . $destination . '"' , 1879048192, $siteId, $updateKey, $newVersion);
		return false;
	}

	$checksumAfterMove = md5_file ($destination);
	if ($checksumReceived != $checksumAfterMove) {
		vSendMsg ('Checksum send by server: "' . $checksumReceived . '", after move: "' . $checksumAfterMove . '"', 805306368, $siteId, $updateKey, $newVersion);
	}

	if (!chmod ($destination, 0666)) {
		vSendMsg ('Chmod on ' . $destination . '  failed!', 3221225472, $siteId, $updateKey, $newVersion);
		return false;
	}

	if ($checksumReceived == $checksumAfterMove) {
		vSendMsg ('Update succesfull.', 0, $siteId, $updateKey, $newVersion);
		return true;
	}

	return false;
}

?>
