<div id="fb-root"></div>
<script>
$(document).ready(function() {
	$.ajax({
		url: '//connect.facebook.net/<?php echo $lang_fb_apis[$lang_code]; ?>/sdk.js',
		type: 'GET',
		cache: true,
		global: false,
		dataType: 'script',
		async: true
	}).done(function(){
		FB.init({
			appId: '249403611864812',
			cookie : true,
			xfbml : true,
			version : 'v2.4'
		});
	});
});
</script>