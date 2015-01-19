$(document).ready(function() {
	$(document).ajaxStart(function() {
		NProgress.start();
		$('#loading').fadeIn(42);
	}).ajaxStop(function() {
		NProgress.done();
		$('#loading').fadeOut(42);
	});
});