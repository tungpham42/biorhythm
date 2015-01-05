<?php
$name = (isset($_POST['name'])) ? $_POST['name']: '';
$scale = (isset($_POST['scale'])) ? $_POST['scale']: '';
$description_en = (isset($_POST['description_en'])) ? $_POST['description_en']: '';
$description_ru = (isset($_POST['description_ru'])) ? $_POST['description_ru']: '';
$description_es = (isset($_POST['description_es'])) ? $_POST['description_es']: '';
$description_zh = (isset($_POST['description_zh'])) ? $_POST['description_zh']: '';
$description_ja = (isset($_POST['description_ja'])) ? $_POST['description_ja']: '';
if (isset($_POST['submit'])):
	create_rhythm($name,$scale,$description_en,$description_ru,$description_es,$description_zh,$description_ja);
	sleep(3);
	header('location: /rhythm');
endif;
?>
<form id="form" method="post" action="">
	<table>
		<tr>
			<td><label for="name">Rhythm name:</label></td>
			<td><input type="text" name="name" size="60" maxlength="128" class="required" /></td>
		</tr>
		<tr>
			<td><label for="scale">Rhythm scale:</label></td>
			<td><input type="text" name="scale" size="60" maxlength="128" class="required" /></td>
		</tr>
		<tr>
			<td><label for="description_en">Rhythm description en:</label></td>
			<td><input type="text" name="description_en" size="60" maxlength="128" class="required" /></td>
		</tr>
		<tr>
			<td><label for="description_ru">Rhythm description ru:</label></td>
			<td><input type="text" name="description_ru" size="60" maxlength="128" class="required" /></td>
		</tr>
		<tr>
			<td><label for="description_es">Rhythm description es:</label></td>
			<td><input type="text" name="description_es" size="60" maxlength="128" class="required" /></td>
		</tr>
		<tr>
			<td><label for="description_zh">Rhythm description zh:</label></td>
			<td><input type="text" name="description_zh" size="60" maxlength="128" class="required" /></td>
		</tr>
		<tr>
			<td><label for="description_ja">Rhythm description ja:</label></td>
			<td><input type="text" name="description_ja" size="60" maxlength="128" class="required" /></td>
		</tr>
		<tr>
			<td><input type="submit" name="submit" value="Create" /></td>
			<td><a class="button" href="/rhythm">Cancel</a></td>
		</tr>
	</table>
</form>