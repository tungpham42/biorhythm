<script src="/min/b=js&amp;f=angular/angular.js,lunar.js&amp;64"></script>
<div data-ng-app="lunarApp" data-ng-controller="lunarController">
	<span data-ng-model="today" data-ng-init="today='<?php echo date('Y-m-d'); ?>'"></span>
	<div class="m-btn-group">
		<a class="m-btn green" id="today"><i class="icon-calendar icon-white"></i> Hôm nay</a>
		<a class="m-btn blue" id="prev"><i class="icon-backward icon-white"></i> Trước</a>
		<a class="m-btn blue" id="next">Sau <i class="icon-forward icon-white"></i></a>
	</div>
	<div class="m-input-prepend">
		<span class="add-on label">Xem ngày:</span>
		<input id="solarDate" type="text" class="m-wrap" placeholder="ví dụ: 1961-09-26" data-ng-model="solarDate" data-ng-init="solarDate='<?php echo date('Y-m-d'); ?>'" data-ng-change="changeSolarDate()" required="required" value="<?php echo date('Y-m-d'); ?>">
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
	<div class="m-input-prepend">
		<span class="add-on label">Là ngày:</span>
		<input type="text" class="m-wrap panel" disabled value="{{lunarTheDate()}}">
	</div>
	<div class="m-input-prepend">
		<span class="add-on label">Trực:</span>
		<input type="text" class="m-wrap panel" disabled value="{{lunarPeriod()}}">
	</div>
	<div class="m-input-prepend">
		<span class="add-on label">Tiết khí:</span>
		<input type="text" class="m-wrap panel" disabled value="{{lunarPeriodDate()}}">
	</div>
	<div class="m-input-prepend">
		<span class="add-on label">Sao tốt:</span>
		<textarea class="m-wrap panel" disabled>{{lunarGoodStars()}}</textarea>
	</div>
	<div class="m-input-prepend">
		<span class="add-on label">Sao xấu:</span>
		<textarea class="m-wrap panel" disabled>{{lunarBadStars()}}</textarea>
	</div>
	<div class="m-input-prepend">
		<span class="add-on label">Giờ tốt:</span>
		<textarea class="m-wrap panel" disabled>{{lunarGoodHours()}}</textarea>
	</div>
</div>
<script>
disableInput('solarDate');
$(document).ready(function(){
	$('textarea').autosize();
	$.datepicker.setDefaults($.datepicker.regional['vi']);
});
$('#solarDate').datepicker({
	dateFormat: 'yy-mm-dd',
	changeYear: true,
	changeMonth: true,
	yearRange: '0:3000',
	defaultDate: '<?php echo date('Y-m-d'); ?>',
	showButtonPanel: true,
	showAnim: '',
	onSelect: function(date){
		$(this).trigger('input');
		$('textarea').trigger('autosize.resize');
	}
});
$('#prev').on('click', function(){
	var date = new Date($('#solarDate').val());
	date.setDate(date.getDate()-1);
	date = date.toDateString();
	date = new Date(Date.parse(date));
	$('#solarDate').datepicker('setDate',date).trigger('input');
	$('textarea').trigger('autosize.resize');
});
$('#today').on('click', function(){
	var date = new Date(Date.parse('<?php echo date('Y-m-d'); ?>'));
	$('#solarDate').datepicker('setDate',date).trigger('input');
	$('textarea').trigger('autosize.resize');
});
$('#next').on('click', function(){
	var date = new Date($('#solarDate').val());
	date.setDate(date.getDate()+1);
	date = date.toDateString();
	date = new Date(Date.parse(date));
	$('#solarDate').datepicker('setDate',date).trigger('input');
	$('textarea').trigger('autosize.resize');
});
</script>
<p>Nguồn:</p>
<ul>
	<li><a target="_blank" class="rotate" href="http://www.informatik.uni-leipzig.de/~duc/sach/phongtuc/muc_vii.html"><span data-title="Vấn đề chọn ngày, giờ">Vấn đề chọn ngày, giờ</span></a></li>
	<li><a target="_blank" class="rotate" href="http://cuasomoi.vn/trang-nhat--12-con-giap/0/276.ttn"><span data-title="12 Con Giáp">12 Con Giáp</span></a></li>
</ul>