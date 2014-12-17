//https://github.com/yuhua-chen/MAWButton/blob/master/js/mawbutton.js
(function($){
	$.fn.ripple = function (options) {
		var settings = $.extend({
			speed : 333,					// ms
			alpha : 0.333,
			transitionEnd : function(){}	// callback when transition ends.
		}, options);

		return this.each(function() {
			var $this = $(this);
			var supportEvent = ('ontouchstart' in window ) ? 'touchstart':'mousedown';
			$this.addClass('ripple').on(supportEvent, function(e) {	 //bind touch/click event
				e.stopPropagation();
				$this.append('<div class="ripple-effect"></div>');
				// Fetch click position and size
				var posX = $this.offset().left,
					posY = $this.offset().top;
				var w = $this.outerWidth(),
					h = $this.outerHeight();
				var d = Math.max(w,h) * 2;
				var targetX = e.pageX - posX;
				var targetY = e.pageY - posY;
				var backColor = $this.css('color');

				//Fix target position
				if(!targetX || !targetY){
					targetX = e.originalEvent.touches[0].pageX - posX;
					targetY = e.originalEvent.touches[0].pageY - posY;
				}

				var ratio = 0.5;		 
				var $effectElem = $this.children(':last');

				//Animate Start
				$effectElem.addClass('ripple-stop').css({
					'top' : targetY,
					'left' : targetX,
					'width' : d,
					'height' : d,
					'margin-left' : -d * ratio,
					'margin-top' : -d * ratio,
					'background-color': $.Color(backColor).alpha(settings.alpha).toRgbaString(),
					'transition-duration' : settings.speed+'ms',
					'-webkit-transition-duration' : settings.speed+'ms',
					'-moz-transition-duration' : settings.speed+'ms',
					'-o-transition-duration' : settings.speed+'ms'
				}).removeClass('ripple-stop');

				//Animate End
				setTimeout(function(){
					$effectElem.addClass('ripple-effect-out').css({
						'background-color': $.Color(backColor).alpha(0).toRgbaString(),
						'transition-duration' : settings.speed+'ms',
						'-webkit-transition-duration' : settings.speed+'ms',
						'-moz-transition-duration' : settings.speed+'ms',
						'-o-transition-duration' : settings.speed+'ms'
					});
					setTimeout(function(){
						$this.find('.ripple-effect').first().remove();
						settings.transitionEnd.call(this);
					},settings.speed);
				}, settings.speed);
			});
		});
	}
}(jQuery));