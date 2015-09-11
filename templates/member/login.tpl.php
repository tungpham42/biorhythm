<?php
if (isset($_COOKIE['NSH:member']) && !invalid_email($_COOKIE['NSH:member'])) {
	header('Location: http'.(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 's':'').'://nhipsinhhoc.vn/member/'.$_COOKIE['NSH:member'].'/');
}
$member_login_errors = array();
$inputted_email = isset($_POST['member_login_email']) ? $_POST['member_login_email']: '';
if (isset($_POST['member_login_submit'])) {
	if (!$_POST['member_login_email'] || !$_POST['member_login_password']) {
		$member_login_errors[] = translate_error('not_filled');
	} else if (invalid_member($_POST['member_login_email'],$_POST['member_login_password'])) {
		$member_login_errors[] = translate_error('invalid_member');
	}
	if (!count($member_login_errors)) {
		setrawcookie('NSH:member',$_POST['member_login_email'],time()+(10*365*24*60*60),'/');
		header('Location: http'.(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 's':'').'://nhipsinhhoc.vn/member/'.$_POST['member_login_email'].'/');
	}
}
?>
<form id="login_form" method="POST" action="">
	<div class="m-input-prepend">
		<span class="add-on"><?php echo translate_span('email'); ?></span>
		<input class="m-wrap translate required" size="20" type="text" name="member_login_email" data-lang-ja="<?php echo $input_interfaces['email']['ja']; ?>" data-lang-zh="<?php echo $input_interfaces['email']['zh']; ?>" data-lang-es="<?php echo $input_interfaces['email']['es']; ?>" data-lang-ru="<?php echo $input_interfaces['email']['ru']; ?>" data-lang-en="<?php echo $input_interfaces['email']['en']; ?>" data-lang-vi="<?php echo $input_interfaces['email']['vi']; ?>" placeholder="<?php echo $input_interfaces['email'][$lang_code]; ?>" value="<?php echo $inputted_email; ?>" tabindex="1" required>
	</div>
	<div class="m-input-prepend">
		<span class="add-on"><?php echo translate_span('password'); ?></span>
		<input class="m-wrap translate required" size="20" type="password" name="member_login_password" data-lang-ja="<?php echo $input_interfaces['password']['ja']; ?>" data-lang-zh="<?php echo $input_interfaces['password']['zh']; ?>" data-lang-es="<?php echo $input_interfaces['password']['es']; ?>" data-lang-ru="<?php echo $input_interfaces['password']['ru']; ?>" data-lang-en="<?php echo $input_interfaces['password']['en']; ?>" data-lang-vi="<?php echo $input_interfaces['password']['vi']; ?>" placeholder="<?php echo $input_interfaces['password'][$lang_code]; ?>" tabindex="2" required>
	</div>
	<input class="m-btn translate green" name="member_login_submit" type="submit" data-lang-ja="<?php echo $button_interfaces['login']['ja']; ?>" data-lang-zh="<?php echo $button_interfaces['login']['zh']; ?>" data-lang-es="<?php echo $button_interfaces['login']['es']; ?>" data-lang-ru="<?php echo $button_interfaces['login']['ru']; ?>" data-lang-en="<?php echo $button_interfaces['login']['en']; ?>" data-lang-vi="<?php echo $button_interfaces['login']['vi']; ?>" value="<?php echo $button_interfaces['login'][$lang_code]; ?>" tabindex="3" />
	<h5><?php echo translate_span('not_yet_registered'); ?></h5>
	<a id="member_register" class="m-btn blue button_changeable" href="/member/register/" tabindex="4"><?php echo translate_button('register'); ?></a>
</form>
<?php
if (isset($_POST['member_login_submit'])):
	if ($member_login_errors):
		echo '<span class="error">'.implode('<br />',$member_login_errors).'</span>';
	endif;
endif;
if (isset($_GET['registered']) && $_GET['registered'] == '✓'):
?>
<script>fbq('track', 'CompleteRegistration');</script>
<?php
endif;
?>