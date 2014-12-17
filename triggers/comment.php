<?php
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/init_trigger.inc.php';
$comment_cava = new Comment();
//Get comments
if (isset($_GET['a']) && $_GET['a'] == 'g') {
	if (isset($_GET['url'])) {
		try {
			header('Cache-Control: no-cache, must-revalidate');
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
			header('Content-type: application/json');
			header("HTTP/1.1 200 OK");
			$comments = $comment_cava->get_comments($_GET['url']);
			if (empty($comments)) $comments = array();
			echo json_encode($comments);
		}
		catch(PDOException $e) {
			//output an empty JSON array
			echo json_encode(array());
		}
	}
}
//Captcha
if (isset($_GET['a']) && $_GET['a'] == 'c') {
	echo $comment_cava->generate_captcha();
}
//POST a comment
if (isset($_GET['a']) && $_GET['a'] == 'p') {

	//Add the comment
	$comment_cava->add_comment($_POST['url'], $_POST['name'], $_POST['comment'], $_POST['captcha'] );

	//redirect to the url
	header('Location: '.$_POST['url']);
}
?>