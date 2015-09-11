<div id="fb-root"></div>
<script>
$(document).ready(function() {
	$.getScript('//connect.facebook.net/<?php echo $lang_fb_apis[$lang_code]; ?>/sdk.js', function(){
		FB.init({
			appId: '249403611864812',
			cookie : true,
			xfbml : true,
			version : 'v2.4'
		});
	});
});
</script>