<section id="news">
	<h5><?php echo translate_span('news'); ?></h5>
	<ul>
<?php
load_news_feed(get_zodiac_from_dob($dob,$lang_code).' '.date('Y'));
load_news_feed(get_zodiac_from_dob($dob,$lang_code));
load_news_feed(get_lunar_year($dob,$lang_code).' '.date('Y'));
load_news_feed(get_lunar_year($dob,$lang_code));
?>
	</ul>
</section>