<h2>Cá độ đua hộp (2 - 16 người chơi)</h2>
<form id="form" action="?p=race/2" method="post">
	<div class="m-input-prepend m-input-append">
		<span class="add-on">Bao nhiêu người chơi:</span>
		<input id="count" type="number" min="2" max="16" step="1" name="count" size="30" maxlength="128" class="required m-wrap">
		<a id="submit" class="m-btn blue"><span>Bước 2</span></a>
	</div>
</form>
<div class="error_msg"></div>
<script>
$('#submit').click(function(){
	var count = $.trim($('#count').val());
	var error_msg = '';
	if (count.length == 0) {
		error_msg += '- Chưa nhập số người chơi.</br>';
	}
	if (!$.isNumeric(count)) {
		error_msg += '- Nhập không đúng định dạng số.</br>';
	}
	if (count < 2 || count > 16) {
		error_msg += '- Số người chơi nhập vào phải từ 2 đến 16.</br>';
	}
	if (error_msg != '') {
		$('.error_msg').html(error_msg).dialog({position:{my: 'center', at: 'center', of: 'main'}});
		return false;
	} else {
		$('#form').submit();
	}
});
</script>