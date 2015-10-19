<?php
$member_profile_errors = array();
$inputted_email = isset($_POST['member_profile_email']) ? $_POST['member_profile_email']: load_member()['email'];
$inputted_fullname = isset($_POST['member_profile_fullname']) ? $_POST['member_profile_fullname']: load_member()['fullname'];
$inputted_dob = isset($_POST['member_profile_dob']) ? $_POST['member_profile_dob']: load_member()['dob'];
if (isset($_POST['member_profile_submit'])) {
	if (!$_POST['member_profile_email'] || !$_POST['member_profile_fullname'] || !$_POST['member_profile_dob']) {
		$member_profile_errors[] = translate_error('not_filled');
	} else {
		if (invalid_email($_POST['member_profile_email'])) {
			$member_profile_errors[] = translate_error('invalid_email');
		}
		if (invalid_dob($_POST['member_profile_dob'])) {
			$member_profile_errors[] = translate_error('invalid_dob');
		}
		if ($_POST['member_profile_password']) {
			if (short_pass($_POST['member_profile_password'])) {
				$member_profile_errors[] = translate_error('short_pass');
			}
			if (long_pass($_POST['member_profile_password'])) {
				$member_profile_errors[] = translate_error('long_pass');
			}
			if (no_number_pass($_POST['member_profile_password'])) {
				$member_profile_errors[] = translate_error('no_number_pass');
			}
			if (no_letter_pass($_POST['member_profile_password'])) {
				$member_profile_errors[] = translate_error('no_letter_pass');
			}
			/*
			if (no_caps_pass($_POST['member_profile_password'])) {
				$member_profile_errors[] = translate_error('no_caps_pass');
			}
			if (no_symbol_pass($_POST['member_profile_password'])) {
				$member_profile_errors[] = translate_error('no_symbol_pass');
			}
			*/
			if (not_match_pass($_POST['member_profile_password'], $_POST['member_profile_repeat_password'])) {
				$member_profile_errors[] = translate_error('not_match_pass');
			}
		}
	}
	if (!count($member_profile_errors)) {
		if ($_POST['member_profile_password']) {
			edit_member($_POST['member_profile_email'], $_POST['member_profile_fullname'], $_POST['member_profile_password'], $_POST['member_profile_dob'], $lang_code);
			email_edit_member($_POST['member_profile_email'], $_POST['member_profile_fullname'], $_POST['member_profile_password'], $_POST['member_profile_dob']);
		} else {
			edit_member($_POST['member_profile_email'], $_POST['member_profile_fullname'], load_member()['password'], $_POST['member_profile_dob'], $lang_code);
			email_edit_member($_POST['member_profile_email'], $_POST['member_profile_fullname'], $email_interfaces['not_changed'][$lang_code], $_POST['member_profile_dob']);
		}
		header('Location: '.$_SERVER['HTTP_REFERER'].'');
	}
}
?>
<form id="profile_form" method="POST" action="">
	<div class="m-input-prepend">
		<span class="add-on"><?php echo translate_span('email'); ?></span>
		<input type="hidden" name="member_profile_email" value="<?php echo $inputted_email; ?>">
		<input class="m-wrap translate disabled" size="20" type="text" data-lang-ja="<?php echo $input_interfaces['email']['ja']; ?>" data-lang-zh="<?php echo $input_interfaces['email']['zh']; ?>" data-lang-es="<?php echo $input_interfaces['email']['es']; ?>" data-lang-ru="<?php echo $input_interfaces['email']['ru']; ?>" data-lang-en="<?php echo $input_interfaces['email']['en']; ?>" data-lang-vi="<?php echo $input_interfaces['email']['vi']; ?>" placeholder="<?php echo $input_interfaces['email'][$lang_code]; ?>" value="<?php echo $inputted_email; ?>" disabled>
	</div>
	<div class="m-input-prepend">
		<span class="add-on"><?php echo translate_span('fullname'); ?></span>
		<input class="m-wrap translate required" size="20" type="text" name="member_profile_fullname" data-lang-ja="<?php echo $input_interfaces['fullname']['ja']; ?>" data-lang-zh="<?php echo $input_interfaces['fullname']['zh']; ?>" data-lang-es="<?php echo $input_interfaces['fullname']['es']; ?>" data-lang-ru="<?php echo $input_interfaces['fullname']['ru']; ?>" data-lang-en="<?php echo $input_interfaces['fullname']['en']; ?>" data-lang-vi="<?php echo $input_interfaces['fullname']['vi']; ?>" placeholder="<?php echo $input_interfaces['fullname'][$lang_code]; ?>" value="<?php echo $inputted_fullname; ?>" required>
	</div>
	<div class="m-input-prepend">
		<span class="add-on"><?php echo translate_span('dob'); ?></span>
		<input id="member_profile_dob" class="m-wrap required" size="20" type="text" name="member_profile_dob" pattern="\d{4}-\d{2}-\d{2}" placeholder="YYYY-MM-DD" value="<?php echo $inputted_dob; ?>" required>
	</div>
	<a id="change_pass" href="javascript:void(0);"><?php echo translate_button('change_pass'); ?></a>
	<div class="m-input-prepend hide pass">
		<span class="add-on"><?php echo translate_span('password'); ?></span>
		<input class="m-wrap translate" size="20" type="password" name="member_profile_password" data-lang-ja="<?php echo $input_interfaces['password']['ja']; ?>" data-lang-zh="<?php echo $input_interfaces['password']['zh']; ?>" data-lang-es="<?php echo $input_interfaces['password']['es']; ?>" data-lang-ru="<?php echo $input_interfaces['password']['ru']; ?>" data-lang-en="<?php echo $input_interfaces['password']['en']; ?>" data-lang-vi="<?php echo $input_interfaces['password']['vi']; ?>" placeholder="<?php echo $input_interfaces['password'][$lang_code]; ?>">
	</div>
	<div class="m-input-prepend hide pass">
		<span class="add-on"><?php echo translate_span('repeat_password'); ?></span>
		<input class="m-wrap translate" size="20" type="password" name="member_profile_repeat_password" data-lang-ja="<?php echo $input_interfaces['repeat_password']['ja']; ?>" data-lang-zh="<?php echo $input_interfaces['repeat_password']['zh']; ?>" data-lang-es="<?php echo $input_interfaces['repeat_password']['es']; ?>" data-lang-ru="<?php echo $input_interfaces['repeat_password']['ru']; ?>" data-lang-en="<?php echo $input_interfaces['repeat_password']['en']; ?>" data-lang-vi="<?php echo $input_interfaces['repeat_password']['vi']; ?>" placeholder="<?php echo $input_interfaces['repeat_password'][$lang_code]; ?>">
	</div>
	<input class="m-btn translate green" name="member_profile_submit" type="submit" data-lang-ja="<?php echo $button_interfaces['update']['ja']; ?>" data-lang-zh="<?php echo $button_interfaces['update']['zh']; ?>" data-lang-es="<?php echo $button_interfaces['update']['es']; ?>" data-lang-ru="<?php echo $button_interfaces['update']['ru']; ?>" data-lang-en="<?php echo $button_interfaces['update']['en']; ?>" data-lang-vi="<?php echo $button_interfaces['update']['vi']; ?>" value="<?php echo $button_interfaces['update'][$lang_code]; ?>" />
	<a id="member_logout" class="m-btn blue button_changeable" href="/triggers/member_logout.php"><i class="icon-log-out icon-white"></i> <?php echo translate_button('logout'); ?></a>
<?php
if (isset($_POST['member_profile_submit'])) {
	if ($member_profile_errors) {
		echo '<span class="error">'.implode('<br />',$member_profile_errors).'</span>';
	}
}
?>
</form>
<script>
maskField('#member_profile_dob');
disableHyphen('member_profile_dob');
$('#profile_form').on('click', '#change_pass', function(){
	$('.pass.hide').removeClass('hide');
	$('#change_pass').remove();
	animateScrollProverb();
});
$('#member_profile_dob').datepicker({
	dateFormat: 'yy-mm-dd',
	changeYear: true,
	changeMonth: true,
	yearRange: '0:<?php echo date('Y') ?>',
	defaultDate: '<?php echo ($inputted_dob != '') ? date('Y-m-d',strtotime($inputted_dob)): '1961-09-26'; ?>',
	maxDate: '<?php echo date('Y-m-d'); ?>',
	showButtonPanel: true,
	showAnim: ''
});
</script>