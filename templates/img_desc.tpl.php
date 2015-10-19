<div id="img_desc">
<?php
if (has_dob() && is_birthday()):
?>
	<img src="<?php echo $cdn_url; ?>/img/img_desc_birthday.png" alt="<?php echo birthday_wish(); ?>" />
<?php
else:
?>
	<img src="<?php echo $cdn_url; ?>/img/img_desc_logo.png" alt="<?php echo head_description(); ?>" />
<?php
endif;
?>
</div>