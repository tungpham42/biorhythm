<?php
$uid = (isset($_POST['uid'])) ? $_POST['uid']: '';
$old_name = (isset($_POST['old_name'])) ? $_POST['old_name']: '';
$old_dob = (isset($_POST['old_dob'])) ? $_POST['old_dob']: '';
$name = (isset($_POST['name'])) ? $_POST['name']: '';
$dob = (isset($_POST['dob'])) ? $_POST['dob']: '';
if (isset($_POST['submit'])):
	edit_user($uid,$name,$dob);
	sleep(3);
	header('Location: /user');
endif;
?>
<form id="form" method="post" action="">
	<input type="hidden" name="uid" value="<?php echo $uid; ?>"/>
	<table>
		<tr>
			<td><label for="name">Fullname:</label></td>
			<td><input id="name" type="text" name="name" size="60" maxlength="128" class="required" value="<?php echo $old_name; ?>" /></td>
		</tr>
		<tr>
			<td><label for="dob">Date of birth:</label></td>
			<td><input id="dob" type="text" name="dob" size="60" maxlength="128" class="required" value="<?php echo $old_dob; ?>" /></td>
		</tr>
		<tr>
			<td><input type="submit" name="submit" value="Edit" /></td>
			<td><a class="button" href="/user">Cancel</a></td>
		</tr>
	</table>
</form>
<script>
	$('#name').autocomplete({
		source: '/triggers/users.php',
		minLength: 2
	});
	$('#dob').datepicker({
		dateFormat:'yy-mm-dd',
		changeYear:true,
		changeMonth:true,
		yearRange:'0:2500'
	});
</script>