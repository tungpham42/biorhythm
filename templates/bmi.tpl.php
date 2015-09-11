<script src="/min/b=js&amp;f=angular/angular.min.js,bmi.js&amp;16"></script>
<div id="bmi_app" data-ng-app="bmiApp" data-ng-controller="bmiController">
	<input id="bmi_lang" type="hidden" data-ng-model="language" value="<?php echo $lang_code; ?>">
	<div class="m-input-prepend m-input-append">
		<?php echo translate_span('bmi_weight','bmi_weight class: add-on label'); ?>
		<input pattern="\d*" id="weight" type="number" min="25" max="200" step="1" class="m-wrap" placeholder="84" data-ng-model="weight" required="required">
		<?php echo translate_span('bmi_weight_unit','bmi_weight_unit class: add-on unit'); ?>
	</div>
	<div class="m-input-prepend m-input-append">
		<?php echo translate_span('bmi_height','bmi_height class: add-on label'); ?>
		<input id="height" type="number" min="1" max="2.5" step="0.01" class="m-wrap" placeholder="1.84" data-ng-model="height" required="required">
		<?php echo translate_span('bmi_height_unit','bmi_height_unit class: add-on unit'); ?>
	</div>
	<div class="m-input-prepend">
		<?php echo translate_span('bmi_value','bmi_value class: add-on label'); ?>
		<input type="text" class="m-wrap panel" disabled value="{{bmiValue()}}">
	</div>
	<div class="m-input-prepend">
		<?php echo translate_span('bmi_explanation','bmi_explanation class: add-on label'); ?>
		<input type="text" class="m-wrap panel" disabled value="{{bmiExplanation()}}">
	</div>
	<div class="m-input-prepend">
		<?php echo translate_span('bmi_ideal_weight','bmi_ideal_weight class: add-on label'); ?>
		<input type="text" class="m-wrap panel" disabled value="{{idealWeight()}}">
	</div>
	<div class="m-input-prepend">
		<?php echo translate_span('bmi_ideal_height','bmi_ideal_height class: add-on label'); ?>
		<input type="text" class="m-wrap panel" disabled value="{{idealHeight()}}">
	</div>
	<div class="m-input-prepend">
		<?php echo translate_span('bmi_recommendation','bmi_recommendation class: add-on label'); ?>
		<input type="text" class="m-wrap panel" disabled value="{{recommendation()}}">
	</div>
</div>