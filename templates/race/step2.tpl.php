<?php
$count = (isset($_POST['count'])) ? $_POST['count']: 0;
$time = (isset($_POST['time'])) ? $_POST['time']: 0;
?>
<h2>Điền tên người chơi:</h2>
<form id="form" action="?p=race/3" method="post">
	<input type="hidden" name="count" value="<?php echo $count; ?>">
	<input type="hidden" name="time" value="<?php echo $time; ?>">
	<?php echo player_input($count); ?>
	<input class="button" type="button" onclick="window.location.href='/?p=race';" value="Quay về bước 1">
	<input class="button" type="submit" name="step2_submit" value="Chơi">
	<div class="clear"></div>
</form>
<div class="error_msg"></div>
<script>
$('#form').submit(function(){
	var error_msg = '';
	$('input.player-name').each(function(){
		var position = $(this).attr('data-position');
		if ($.trim($(this).val()).length == 0) {
			error_msg += '- Tên người chơi thứ '+position+' rỗng.</br>';
		}
	});
	if (error_msg != '') {
		$('.error_msg').html(error_msg).dialog({position:{my: 'center', at: 'center', of: 'main'}});
		return false;
	}
});
</script>