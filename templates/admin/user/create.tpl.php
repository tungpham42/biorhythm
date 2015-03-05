<?php
$name = (isset($_POST['name'])) ? $_POST['name']: '';
$dob = (isset($_POST['dob'])) ? $_POST['dob']: '';
if (isset($_POST['submit'])):
	create_user($name,$dob);
	sleep(3);
	header('Location: /user');
endif;
?>
<form id="form" method="post" action="">
	<table>
		<tr class="ui-widget">
			<td><label for="name">Fullname:</label></td>
			<td><input id="name" type="text" name="name" size="60" maxlength="128" class="required" /></td>
		</tr>
		<tr>
			<td><label for="dob">Date of birth:</label></td>
			<td><input id="dob" type="text" name="dob" size="60" maxlength="128" class="required" /></td>
		</tr>
		<tr>
			<td><input type="submit" name="submit" value="Create" /></td>
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