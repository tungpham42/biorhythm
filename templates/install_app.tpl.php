<?php
$ad_position = rand(1,3);
?>
<div id="installation">
	<h2 id="apps"><?php echo translate_span('apps'); ?></h2>
<?php
if ($ad_position == 1):
	include template('banner_336x280');
endif;
?>
	<section class="apps">
		<h3 class="apps">Android</h3>
		<section class="app">
			<h4 class="apps lite"><?php echo translate_span('apps_six_lang'); ?></h4>
			<a target="_blank" id="android" href="https://play.google.com/store/apps/details?id=vn.nhipsinhhoc"></a>
		</section>
		<section class="app">
			<h4 class="apps one_lang"><?php echo translate_span('apps_one_lang'); ?></h4>
			<a target="_blank" id="android_vi" href="https://play.google.com/store/apps/details?id=vn.nhipsinhhoc.vi"></a>
			<a target="_blank" id="android_en" href="https://play.google.com/store/apps/details?id=vn.nhipsinhhoc.en"></a>
			<a target="_blank" id="android_ru" href="https://play.google.com/store/apps/details?id=vn.nhipsinhhoc.ru"></a>
			<a target="_blank" id="android_es" href="https://play.google.com/store/apps/details?id=vn.nhipsinhhoc.es"></a>
			<a target="_blank" id="android_zh" href="https://play.google.com/store/apps/details?id=vn.nhipsinhhoc.zh"></a>
			<a target="_blank" id="android_ja" href="https://play.google.com/store/apps/details?id=vn.nhipsinhhoc.ja"></a>
		</section>
		<section class="app">
			<h4 class="apps lunar">Xem ngày tốt xấu</h4>
			<a target="_blank" id="android_lunar" href="https://play.google.com/store/apps/details?id=vn.nhipsinhhoc.xemngay"></a>
		</section>
	</section>
	<section class="apps">
		<h3 class="apps">Windows Phone</h3>
		<a target="_blank" id="windows_phone" href="http://www.windowsphone.com/s?appid=c1cbcc2d-0565-41dd-956e-28e48406e401"></a>
	</section>
<?php
if ($ad_position == 2):
	include template('banner_336x280');
endif;
?>
	<button class="install-btn" onclick="chrome.webstore.install()" id="chrome_install"><?php echo translate_button('install_chrome'); ?></button>
	<button class="install-btn" id="firefox_install"><?php echo translate_button('install_firefox'); ?></button>
	<script src="/min/f=js/install.js&amp;7"></script>
<?php
include template('alexa');
if ($ad_position == 3):
	include template('banner_336x280');
endif;
?>
</div>