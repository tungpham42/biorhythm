<?php
$lang_bar_strings = array(
	array(
		'order' => '6',
		'code' => 'ja',
		'span' => '日本語'
	),
	array(
		'order' => '5',
		'code' => 'zh',
		'span' => '中文'
	),
	array(
		'order' => '4',
		'code' => 'es',
		'span' => 'Español'
	),
	array(
		'order' => '3',
		'code' => 'ru',
		'span' => 'Русский'
	),
	array(
		'order' => '2',
		'code' => 'en',
		'span' => 'English'
	),
	array(
		'order' => '1',
		'code' => 'vi',
		'span' => 'Tiếng Việt'
	)
);
$current_lang_strings = array();
$current_lang_bar_strings = array();
foreach ($lang_bar_strings as $key => $value) {
	if ($value['code'] == $lang_code) {
		$current_lang_strings[$key] = $value;
	}
}
$current_lang_bar_strings = array_diff_key($lang_bar_strings,$current_lang_strings);
sort($current_lang_strings);
rsort($current_lang_bar_strings);
//echo '<!--';
//print_r($current_lang_strings);
//print_r($current_lang_bar_strings);
//echo '-->';
$lang_bar_count = count($current_lang_bar_strings);
?>
<div id="lang_bar">
<?php
for ($i = 0; $i < $lang_bar_count; ++$i):
?>
	<a class="lang_toggle button" data-order="<?php echo $current_lang_bar_strings[$i]['order']; ?>" lang="<?php echo $current_lang_bar_strings[$i]['code']; ?>" id="<?php echo $current_lang_bar_strings[$i]['code']; ?>_toggle"><i class="flag"></i><span class="lang"><?php echo $current_lang_bar_strings[$i]['span']; ?></span></a>
<?php
endfor;
?>
	<a class="lang_toggle button" data-order="<?php echo $current_lang_strings[0]['order']; ?>" lang="<?php echo $current_lang_strings[0]['code']; ?>" id="<?php echo $current_lang_strings[0]['code']; ?>_toggle"><i class="flag"></i><span class="lang"><?php echo $current_lang_strings[0]['span']; ?></span></a>
</div>