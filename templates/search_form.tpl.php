<span id="search_form_status"></span>
<div id="search_wrapper">
	<form id="search_form" class="no-select-highlight" action="/<?php echo (isset($hide_lang_bar) && isset($hide_nav)) ? $lang_code.'/': ''; ?>" method="GET">
		<div class="m-input-append">
			<input id="search" type="text" name="q" data-lang-ja="<?php echo $input_interfaces['search']['ja']; ?>" data-lang-zh="<?php echo $input_interfaces['search']['zh']; ?>" data-lang-es="<?php echo $input_interfaces['search']['es']; ?>" data-lang-ru="<?php echo $input_interfaces['search']['ru']; ?>" data-lang-en="<?php echo $input_interfaces['search']['en']; ?>" data-lang-vi="<?php echo $input_interfaces['search']['vi']; ?>" placeholder="<?php echo $input_interfaces['search'][$lang_code]; ?>" class="m-wrap translate" value="<?php echo (isset($_GET['q'])) ? $_GET['q'] : ''; ?>" />
			<a id="search_submit" class="m-btn green icn-only"><i class="icon-search icon-white"></i></a>
		</div>
	</form>
</div>