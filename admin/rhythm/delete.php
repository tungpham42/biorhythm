<?php
$rid = isset($_POST['rid']) ? $_POST['rid']: '';
$rhythm = load_rhythm($rid);
if (isset($_POST['submit'])):
	delete_rhythm($_POST['id']);
	sleep(3);
	header('location: /rhythm');
endif;
?>
<h3>Do you want to delete the rhythm "<?php print $rhythm['name']; ?>"?</h3>
<form method="post" action="">
	<input type="hidden" name="id" value="<?php print $rid; ?>"/>
	<input type="submit" name="submit" value="Delete" />
	<a class="button" href="/rhythm">Cancel</a>
</form>