var $elems = $('html, body');
var delta = 0;

$(document).on('mousemove', function(e) {
	var h = $(window).height();
	var y = e.clientY - h / 2;
	delta = y * 0.1;
});

$(window).on('blur mouseleave', function() {
	delta = 0;
});

(function f() {
	if(delta) {
		$elems.scrollTop(function(i, v) {
			return v + delta;
		})
	}
	webkitRequestAnimationFrame(f);
})();