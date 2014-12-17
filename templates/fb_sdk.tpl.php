<script>
$(document).ready(function() {
    $('#fb_holder').append('<div id="fb-root"></div>');
    $('#fb_holder').append('<fb:like-box href="https://www.facebook.com/bieudonhipsinhhoc" width="908" colorscheme="light" show_faces="true" header="false" stream="true" show_border="false"></fb:like-box>'); 
    jQuery.getScript('http://connect.facebook.net/en_US/all.js#xfbml=1&appId=657755270955356&version=v2.0', function() {
        FB.init({status: true, cookie: true, xfbml: true});
    });
});
</script>