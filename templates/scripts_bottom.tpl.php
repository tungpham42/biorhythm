<?php
if (!isset($_GET['p']) && $embed == 0 || in_array($p, $navs)):
?>
<script>
$(document).ready(function(){
	manipulateHeader();
	manipulateDobForm();
	manipulateProverb();
	manipulateExplanation();
	manipulateVideo();
	$('#dob').datepicker({
		dateFormat: 'yy-mm-dd',
		changeYear: true,
		changeMonth: true,
		yearRange: '0:<?php echo date('Y') ?>',
		defaultDate: '<?php echo ($dob != '') ? date('Y-m-d',strtotime($dob)): '1961-09-26'; ?>',
		maxDate: '<?php echo date('Y-m-d'); ?>',
		showButtonPanel: true,
		showAnim: ''
	});
});
</script>
<?php
endif;
?>
<script>
$(document).ready(function(){
	manipulateLang();
	manipulateButtons();
});
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-45705743-1', 'nhipsinhhoc.vn');
ga('send', 'pageview');
</script>