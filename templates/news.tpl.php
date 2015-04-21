<section id="news">
	<h5><span class="translate" data-lang-ja="<?php echo $span_interfaces['news']['ja']; ?>" data-lang-zh="<?php echo $span_interfaces['news']['zh']; ?>" data-lang-es="<?php echo $span_interfaces['news']['es']; ?>" data-lang-ru="<?php echo $span_interfaces['news']['ru']; ?>" data-lang-en="<?php echo $span_interfaces['news']['en']; ?>" data-lang-vi="<?php echo $span_interfaces['news']['vi']; ?>"><?php echo $span_interfaces['news'][$lang_code]; ?></span></h5>
	<ul>
<?php
load_news_feed(get_zodiac_from_dob($dob,$lang_code).' '.date('Y'));
load_news_feed(get_zodiac_from_dob($dob,$lang_code));
load_news_feed(get_lunar_year($dob,$lang_code).' '.date('Y'));
load_news_feed(get_lunar_year($dob,$lang_code));
?>
	</ul>
</section>