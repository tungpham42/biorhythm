<script src="/min/b=js&amp;f=angular/angular.js,bmi.js&amp;40"></script>
<div data-ng-app="bmiApp" data-ng-controller="bmiController">
	<div class="m-input-prepend m-input-append">
		<span class="add-on label">Cân nặng:</span>
		<input pattern="\d*" id="weight" type="number" min="25" max="200" step="1" class="m-wrap" placeholder="ví dụ: 82" data-ng-model="weight" required="required">
		<span class="add-on unit">ký</span>
	</div>
	<div class="m-input-prepend m-input-append">
		<span class="add-on label">Chiều cao:</span>
		<input id="height" type="number" min="1" max="2.5" step="0.01" class="m-wrap" placeholder="ví dụ: 1.77" data-ng-model="height" required="required">
		<span class="add-on unit">mét</span>
	</div>
	<div class="m-input-prepend">
		<span class="add-on label">Chỉ số BMI:</span>
		<input type="text" class="m-wrap panel" disabled value="{{bmiValue()}}">
	</div>
	<div class="m-input-prepend">
		<span class="add-on label">Đánh giá:</span>
		<input type="text" class="m-wrap panel" disabled value="{{bmiExplanation()}}">
	</div>
	<div class="m-input-prepend">
		<span class="add-on label">Cân nặng lý tưởng:</span>
		<input type="text" class="m-wrap panel" disabled value="{{idealWeight()}}">
	</div>
	<div class="m-input-prepend">
		<span class="add-on label">Chiều cao lý tưởng:</span>
		<input type="text" class="m-wrap panel" disabled value="{{idealHeight()}}">
	</div>
	<div class="m-input-prepend">
		<span class="add-on label">Lời khuyên:</span>
		<input type="text" class="m-wrap panel" disabled value="{{recommendation()}}">
	</div>
</div>