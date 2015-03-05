<?php
$rid = isset($_POST['rid']) ? $_POST['rid']: '';
$old_name = isset($_POST['old_name']) ? $_POST['old_name']: '';
$old_scale = isset($_POST['old_scale']) ? $_POST['old_scale']: '';
$old_description_en = isset($_POST['old_description_en']) ? $_POST['old_description_en']: '';
$old_description_ru = isset($_POST['old_description_ru']) ? $_POST['old_description_ru']: '';
$old_description_es = isset($_POST['old_description_es']) ? $_POST['old_description_es']: '';
$old_description_zh = isset($_POST['old_description_zh']) ? $_POST['old_description_zh']: '';
$old_description_ja = isset($_POST['old_description_ja']) ? $_POST['old_description_ja']: '';
$name = isset($_POST['name']) ? $_POST['name']: '';
$scale = isset($_POST['scale']) ? $_POST['scale']: '';
$description_en = isset($_POST['description_en']) ? $_POST['description_en']: '';
$description_ru = isset($_POST['description_ru']) ? $_POST['description_ru']: '';
$description_es = isset($_POST['description_es']) ? $_POST['description_es']: '';
$description_zh = isset($_POST['description_zh']) ? $_POST['description_zh']: '';
$description_ja = isset($_POST['description_ja']) ? $_POST['description_ja']: '';
if (isset($_POST['submit'])):
	edit_rhythm($_POST['rid'],$name,$scale,$description_en,$description_ru,$description_es,$description_zh,$description_ja);
	sleep(3);
	header('Location: /rhythm');
endif;
?>
<form id="form" method="post" action="">
	<input type="hidden" name="rid" value="<?php echo $rid; ?>"/>
	<table>
		<tr>
			<td><label for="name">New rhythm's name:</label></td>
			<td><input type="text" name="name" value="<?php echo $old_name; ?>" size="60" maxlength="128" class="required" /></td>
		</tr>
		<tr>
			<td><label for="scale">New rhythm's scale:</label></td>
			<td><input type="text" name="scale" value="<?php echo $old_scale; ?>" size="60" maxlength="128" class="required" /></td>
		</tr>
		<tr>
			<td><label for="description_en">New rhythm's description en:</label></td>
			<td><input type="text" name="description_en" value="<?php echo $old_description_en; ?>" size="60" maxlength="128" class="required" /></td>
		</tr>
		<tr>
			<td><label for="description_ru">New rhythm's description ru:</label></td>
			<td><input type="text" name="description_ru" value="<?php echo $old_description_ru; ?>" size="60" maxlength="128" class="required" /></td>
		</tr>
		<tr>
			<td><label for="description_es">New rhythm's description es:</label></td>
			<td><input type="text" name="description_es" value="<?php echo $old_description_es; ?>" size="60" maxlength="128" class="required" /></td>
		</tr>
		<tr>
			<td><label for="description_zh">New rhythm's description zh:</label></td>
			<td><input type="text" name="description_zh" value="<?php echo $old_description_zh; ?>" size="60" maxlength="128" class="required" /></td>
		</tr>
		<tr>
			<td><label for="description_ja">New rhythm's description ja:</label></td>
			<td><input type="text" name="description_ja" value="<?php echo $old_description_ja; ?>" size="60" maxlength="128" class="required" /></td>
		</tr>
		<tr>
			<td><input type="submit" name="submit" value="Edit" /></td>
			<td><a class="button" href="/rhythm">Cancel</a></td>
		</tr>
	</table>
</form>