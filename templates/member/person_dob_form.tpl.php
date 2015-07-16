<span id="dob_form_status"></span>
<div id="dob_wrapper">
	<form id="dob_form" class="no-select-highlight" action="" method="POST">
		<div class="m-input-prepend" id="dob_bar">
			<input tabindex="1" data-lang-ja="<?php echo $input_interfaces['fullname']['ja']; ?>" data-lang-zh="<?php echo $input_interfaces['fullname']['zh']; ?>" data-lang-es="<?php echo $input_interfaces['fullname']['es']; ?>" data-lang-ru="<?php echo $input_interfaces['fullname']['ru']; ?>" data-lang-en="<?php echo $input_interfaces['fullname']['en']; ?>" data-lang-vi="<?php echo $input_interfaces['fullname']['vi']; ?>" placeholder='<?php echo $input_interfaces['fullname'][$lang_code]; ?>' id='fullname' type='text' name='person_fullname' size='24' maxlength='128' class='required m-wrap translate' value='<?php echo $fullname; ?>' />
			<div id="help_name" class="help"></div>
			<input pattern="\d*" tabindex="2" data-lang-ja="<?php echo $input_interfaces['dob']['ja']; ?>" data-lang-zh="<?php echo $input_interfaces['dob']['zh']; ?>" data-lang-es="<?php echo $input_interfaces['dob']['es']; ?>" data-lang-ru="<?php echo $input_interfaces['dob']['ru']; ?>" data-lang-en="<?php echo $input_interfaces['dob']['en']; ?>" data-lang-vi="<?php echo $input_interfaces['dob']['vi']; ?>" placeholder="<?php echo $input_interfaces['dob'][$lang_code]; ?>" id="dob" type="text" name="person_dob" size="10" maxlength="128" class="required m-wrap translate" autocomplete="off" spellcheck="false" value="<?php echo ($dob != '') ? date('Y-m-d',strtotime($dob)): ''; ?>" />
			<div id="help_dob" class="help">YYYY-MM-DD</div>
		</div>
		<div class="m-btn-group" id="dob_control_bar">
			<a tabindex="5" class="m-btn blue button_changeable" id="dob_list"><i class="icon-list icon-white"></i> <?php echo translate_button('dob_list'); ?></a>
			<a tabindex="4" class="m-btn blue button_changeable" id="dob_remove"><i class="icon-remove icon-white"></i> <?php echo translate_button('dob_remove'); ?></a>
			<a tabindex="3" class="m-btn green" id="dob_edit"><i class="icon-edit icon-white"></i> <?php echo translate_button('dob_edit'); ?></a>
		</div>
	</form>
	<div class="clear"></div>
</div>