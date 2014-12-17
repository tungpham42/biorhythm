<script src="/min/b=js&amp;f=angular/angular.js,lunar.js&amp;4"></script>
<div data-ng-app="lunarApp" data-ng-controller="lunarController">
	<div class="m-input-prepend">
		<span class="add-on label">Ngày tháng năm:</span>
		<input id="solarDate" type="text" class="m-wrap" placeholder="ví dụ: 1961-09-26" data-ng-model="solarDate" required="required" value="<?php echo date('Y-m-d'); ?>">
	</div>
	<div class="m-input-prepend">
		<span class="add-on label">Năm Âm:</span>
		<input type="text" class="m-wrap panel" disabled value="{{lunarYear()}}">
	</div>
	<div class="m-input-prepend">
		<span class="add-on label">Tháng Âm:</span>
		<input type="text" class="m-wrap panel" disabled value="{{lunarMonth()}}">
	</div>
	<div class="m-input-prepend">
		<span class="add-on label">Ngày Âm:</span>
		<input type="text" class="m-wrap panel" disabled value="{{lunarDay()}}">
	</div>
</div>
<script>
$(document).ready(function(){
	$('#solarDate').datepicker({
		dateFormat: 'yy-mm-dd',
		changeYear: true,
		changeMonth: true,
		yearRange: '0:3000',
		defaultDate: '<?php echo date('Y-m-d'); ?>',
		showButtonPanel: true,
		showAnim: ''
	});
	$.datepicker.setDefaults($.datepicker.regional['vi']);
});
</script>