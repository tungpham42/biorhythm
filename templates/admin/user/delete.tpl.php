<?php
$uid = isset($_POST['uid']) ? $_POST['uid']: '';
$user = load_user($uid);
if (isset($_POST['submit'])):
	delete_user($_POST['id']);
	sleep(3);
	header('location: /user');
endif;
?>
<h3>Do you want to delete the user "<?php print $user['name']; ?>"?</h3>
<form method="post" action="">
	<input type="hidden" name="id" value="<?php print $uid; ?>"/>
	<input type="submit" name="submit" value="Delete" />
	<a class="button" href="/user">Cancel</a>
</form>