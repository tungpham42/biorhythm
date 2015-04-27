<div id="fb-root"></div>
<script>
window.fbAsyncInit = function() {
	FB.init({
	appId : '249403611864812',
	cookie : true,
	xfbml : true,
	version : 'v2.3'
	});
};
(function(d, s, id){
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) {return;}
js = d.createElement(s); js.id = id;
js.src = '//connect.facebook.net/<?php echo $lang_fb_apis[$lang_code]; ?>/sdk.js';
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>