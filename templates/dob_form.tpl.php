<span id="dob_form_status"></span>
<div id="dob_wrapper">
	<form id="dob_form" class="no-select-highlight" action="/<?php echo (isset($hide_lang_bar) && isset($hide_nav)) ? $lang_code.'/': ''; ?>" method="GET">
		<div class="m-input-prepend" id="dob_bar">
<?php
if ($fullname != ''):
?>
			<a tabindex="4" id="name_remove" class="m-btn green icn-only"><i class="icon-remove icon-white"></i></a><input tabindex="2" data-lang-ja="<?php echo $input_interfaces['fullname']['ja']; ?>" data-lang-zh="<?php echo $input_interfaces['fullname']['zh']; ?>" data-lang-es="<?php echo $input_interfaces['fullname']['es']; ?>" data-lang-ru="<?php echo $input_interfaces['fullname']['ru']; ?>" data-lang-en="<?php echo $input_interfaces['fullname']['en']; ?>" data-lang-vi="<?php echo $input_interfaces['fullname']['vi']; ?>" placeholder='<?php echo $input_interfaces['fullname'][$lang_code]; ?>' id='fullname' type='text' name='fullname' size='24' maxlength='128' class='required m-wrap translate' readonly disabled value='<?php echo $fullname; ?>' />
<?php
else:
?>
			<a tabindex="2" class="m-btn" id="name_toggle"><?php echo translate_button('name_toggle'); ?></a>
<?php
endif;
?>
			<div id="help_name" class="help"></div>
			<input pattern="\d*" tabindex="1" data-lang-ja="<?php echo $input_interfaces['dob']['ja']; ?>" data-lang-zh="<?php echo $input_interfaces['dob']['zh']; ?>" data-lang-es="<?php echo $input_interfaces['dob']['es']; ?>" data-lang-ru="<?php echo $input_interfaces['dob']['ru']; ?>" data-lang-en="<?php echo $input_interfaces['dob']['en']; ?>" data-lang-vi="<?php echo $input_interfaces['dob']['vi']; ?>" placeholder="<?php echo $input_interfaces['dob'][$lang_code]; ?>" id="dob" type="text" name="dob" size="10" maxlength="128" class="required m-wrap translate" <?php echo ($dob != '') ? 'readonly disabled': ''; ?> value="<?php echo ($dob != '') ? date('Y-m-d',strtotime($dob)): ''; ?>" autocomplete="off" spellcheck="false" />
			<div id="help_dob" class="help">YYYY-MM-DD</div>
		</div>
		<div class="m-btn-group" id="dob_control_bar">
			<a tabindex="6" class="m-btn blue button_changeable" id="home_page" href="/<?php echo (isset($hide_lang_bar) && isset($hide_nav)) ? $lang_code.'/': ''; ?>"><i class="icon-home icon-white"></i> <?php echo translate_button('home_page'); ?></a>
			<a tabindex="5" class="m-btn blue button_changeable" id="dob_erase"><i class="icon-remove icon-white"></i> <?php echo translate_button('dob_erase'); ?></a>
			<a tabindex="3" class="m-btn green" id="dob_submit"><i class="icon-play icon-white"></i> <?php echo translate_button('dob_submit'); ?></a>
		</div>
	</form>
	<div class="clear"></div>
</div>
<!--
<div id="help_dob_form" class="help"><i class="m-icon-white"></i></div>
-->