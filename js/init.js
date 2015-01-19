$(document).ready(function() {
	manipulateBirthday();
	$(window).load(function() {
		manipulateBirthday();
	});
	$('body').load(function() {
		manipulateBirthday();
	});
	$(document).ajaxStart(function() {
		NProgress.start();
		$('#loading').fadeIn(42);
	}).ajaxStop(function() {
		NProgress.done();
		$('#loading').fadeOut(42);
	});
});