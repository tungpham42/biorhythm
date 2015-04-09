<span id="dob_form_status"></span>
<div id="dob_wrapper">
	<form id="dob_form" class="no-select-highlight" action="/<?php echo (isset($hide_lang_bar) && isset($hide_nav)) ? $lang_code.'/': ''; ?>" method="GET">
		<div class="m-input-prepend" id="dob_bar">
<?php
if ($fullname != ''):
?>
			<a tabindex="4" id="name_remove" class="m-btn green icn-only"><i class="icon-remove icon-white"></i></a><input tabindex="1" data-lang-ja="<?php echo $input_interfaces['fullname']['ja']; ?>" data-lang-zh="<?php echo $input_interfaces['fullname']['zh']; ?>" data-lang-es="<?php echo $input_interfaces['fullname']['es']; ?>" data-lang-ru="<?php echo $input_interfaces['fullname']['ru']; ?>" data-lang-en="<?php echo $input_interfaces['fullname']['en']; ?>" data-lang-vi="<?php echo $input_interfaces['fullname']['vi']; ?>" placeholder='<?php echo $input_interfaces['fullname'][$lang_code]; ?>' id='fullname' type='text' name='fullname' size='24' maxlength='128' class='required m-wrap translate' readonly disabled value='<?php echo $_GET['fullname']; ?>' />
<?php
else:
?>
			<a tabindex="1" class="m-btn" id="name_toggle"><span class="translate" data-lang-ja="<?php echo $button_interfaces['name_toggle']['ja']; ?>" data-lang-zh="<?php echo $button_interfaces['name_toggle']['zh']; ?>" data-lang-es="<?php echo $button_interfaces['name_toggle']['es']; ?>" data-lang-ru="<?php echo $button_interfaces['name_toggle']['ru']; ?>" data-lang-en="<?php echo $button_interfaces['name_toggle']['en']; ?>" data-lang-vi="<?php echo $button_interfaces['name_toggle']['vi']; ?>"><?php echo $button_interfaces['name_toggle'][$lang_code]; ?></span></a>
<?php
endif;
?>
			<div id="help_name" class="help"></div>
			<input pattern="\d*" tabindex="2" data-lang-ja="<?php echo $input_interfaces['dob']['ja']; ?>" data-lang-zh="<?php echo $input_interfaces['dob']['zh']; ?>" data-lang-es="<?php echo $input_interfaces['dob']['es']; ?>" data-lang-ru="<?php echo $input_interfaces['dob']['ru']; ?>" data-lang-en="<?php echo $input_interfaces['dob']['en']; ?>" data-lang-vi="<?php echo $input_interfaces['dob']['vi']; ?>" placeholder="<?php echo $input_interfaces['dob'][$lang_code]; ?>" id="dob" type="text" name="dob" size="10" maxlength="128" class="required m-wrap translate" <?php echo (isset($_GET['dob']) && $_GET['dob'] != '') ? 'readonly disabled': ''; ?> value="<?php echo (isset($_GET['dob']) && $_GET['dob'] != '') ? date('Y-m-d',strtotime($_GET['dob'])): ''; ?>" autocomplete="off" spellcheck="false" />
			<div id="help_dob" class="help">YYYY-MM-DD</div>
		</div>
		<div class="m-btn-group" id="dob_control_bar">
			<a tabindex="6" class="m-btn blue" id="home_page" href="/<?php echo (isset($hide_lang_bar) && isset($hide_nav)) ? $lang_code.'/': ''; ?>"><i class="icon-home icon-white"></i> <span class="translate" data-lang-ja="<?php echo $button_interfaces['home_page']['ja']; ?>" data-lang-zh="<?php echo $button_interfaces['home_page']['zh']; ?>" data-lang-es="<?php echo $button_interfaces['home_page']['es']; ?>" data-lang-ru="<?php echo $button_interfaces['home_page']['ru']; ?>" data-lang-en="<?php echo $button_interfaces['home_page']['en']; ?>" data-lang-vi="<?php echo $button_interfaces['home_page']['vi']; ?>"><?php echo $button_interfaces['home_page'][$lang_code]; ?></span></a>
			<a tabindex="5" class="m-btn blue" id="dob_erase"><i class="icon-remove icon-white"></i> <span class="translate" data-lang-ja="<?php echo $button_interfaces['dob_erase']['ja']; ?>" data-lang-zh="<?php echo $button_interfaces['dob_erase']['zh']; ?>" data-lang-es="<?php echo $button_interfaces['dob_erase']['es']; ?>" data-lang-ru="<?php echo $button_interfaces['dob_erase']['ru']; ?>" data-lang-en="<?php echo $button_interfaces['dob_erase']['en']; ?>" data-lang-vi="<?php echo $button_interfaces['dob_erase']['vi']; ?>"><?php echo $button_interfaces['dob_erase'][$lang_code]; ?></span></a>
			<a tabindex="3" class="m-btn green" id="dob_submit"><i class="icon-play icon-white"></i> <span class="translate" data-lang-ja="<?php echo $button_interfaces['dob_submit']['ja']; ?>" data-lang-zh="<?php echo $button_interfaces['dob_submit']['zh']; ?>" data-lang-es="<?php echo $button_interfaces['dob_submit']['es']; ?>" data-lang-ru="<?php echo $button_interfaces['dob_submit']['ru']; ?>" data-lang-en="<?php echo $button_interfaces['dob_submit']['en']; ?>" data-lang-vi="<?php echo $button_interfaces['dob_submit']['vi']; ?>"><?php echo $button_interfaces['dob_submit'][$lang_code]; ?></span></a>
		</div>
	</form>
	<div class="clear"></div>
</div>
<!--
<div id="help_dob_form" class="help"><i class="m-icon-white"></i></div>
-->