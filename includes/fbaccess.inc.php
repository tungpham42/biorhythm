<?php
//Application Configurations
$app_id		= "150274188461345";
$app_secret	= "965952e3daba0c08597c73d94b894c3d";
$site_url	= "http://biorhythm.tungpham42.info/";
 
try{
	include_once "facebook/facebook.php";
}catch(Exception $e){
	error_log($e);
}
// Create our application instance
$facebook = new Facebook(array(
	'appId'		=> $app_id,
	'secret'	=> $app_secret,
	));
 
// Get User ID
$user = $facebook->getUser();
// We may or may not have this data based
// on whether the user is logged in.
// If we have a $user id here, it means we know
// the user is logged into
// Facebook, but we don’t know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.
 
if($user){
//==================== Single query method ======================================
	try{
		// Proceed knowing you have a logged in user who's authenticated.
		$user_profile = $facebook->api('/me');
	}catch(FacebookApiException $e){
		error_log($e);
		$user = NULL;
	}
//==================== Single query method ends =================================
}
 
if($user){
	// Get logout URL
	$logoutUrl = $facebook->getLogoutUrl();
}else{
	// Get login URL
	$loginUrl = $facebook->getLoginUrl(array(
		'scope'		=> 'read_stream, publish_stream, user_birthday, user_location, user_work_history, user_hometown, user_photos',
		'redirect_uri'	=> $site_url,
		));
}
 
if($user){
	// Proceed knowing you have a logged in user who has a valid session.
 
//========= Batch requests over the Facebook Graph API using the PHP-SDK ========
	// Save your method calls into an array
	$queries = array(
		array('method' => 'GET', 'relative_url' => '/'.$user),
		array('method' => 'GET', 'relative_url' => '/'.$user.'/home?limit=50'),
		array('method' => 'GET', 'relative_url' => '/'.$user.'/friends'),
		array('method' => 'GET', 'relative_url' => '/'.$user.'/photos?limit=6'),
		);
 
	// POST your queries to the batch endpoint on the graph.
	try{
		$batchResponse = $facebook->api('?batch='.json_encode($queries), 'POST');
	}catch(Exception $o){
		error_log($o);
	}
 
	//Return values are indexed in order of the original array, content is in ['body'] as a JSON
	//string. Decode for use as a PHP array.
	$user_info		= json_decode($batchResponse[0]['body'], TRUE);
	$feed			= json_decode($batchResponse[1]['body'], TRUE);
	$friends_list		= json_decode($batchResponse[2]['body'], TRUE);
	$photos			= json_decode($batchResponse[3]['body'], TRUE);
//========= Batch requests over the Facebook Graph API using the PHP-SDK ends =====
 
	// Update user's status using graph api
	if(isset($_POST['publish'])){
		try{
			$publishStream = $facebook->api("/$user/feed", 'post', array(
				'message'		=> 'Check out 25 labs',
				'link'			=> 'http://25labs.com',
				'picture'		=> 'http://25labs.com/images/25-labs-160-160.jpg',
				'name'			=> '25 labs',
				'caption'		=> '25labs.com',
				'description'		=> 'A Technology Laboratory. Highly Recomented technology blog.',
				));
		}catch(FacebookApiException $e){
			error_log($e);
		}
	}
 
	// Update user's status using graph api
	if(isset($_POST['status'])){
		try{
			$statusUpdate = $facebook->api("/$user/feed", 'post', array('message'=> $_POST['status']));
		}catch(FacebookApiException $e){
			error_log($e);
		}
	}
}