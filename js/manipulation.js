function manipulateHeader() {
	var supportedEvent = ('ontouchstart' in window ) ? 'touchstart':'mousedown';
	$('header').on({
		change: function() {
			validateSearch(false);
		},
		keypress: function() {
			validateSearch(false);
		},
		keyup: function(e) {
			if (e.which == 13) {
				$('#search_submit').removeClass('clicked');
				validateSearch(true);
			} else {
				validateSearch(false);
			}
		},
		keydown: function(e) {
			if (e.which == 13) {
				$('#search_submit').addClass('clicked');
				return false;
			} else {
				validateSearch(false);
			}
		}
	}, '#search').on({
		mouseenter: function() {
			marqueeHeading();
		},
		mouseleave: function() {
			$('h1#heading').css('textIndent','0px');
		}
	}, 'h1#heading').on('click', '#search_submit', function() {
		validateSearch(true);
	}).on(supportedEvent, function() {
		if (!$('header').hasClass('clicked')) {
			$('header').addClass('clicked');
		} else if ($('header').hasClass('clicked')) {
			$('header').removeClass('clicked');
		}
	});
}
function manipulateDobForm() {
	disableHyphen('dob');
	helpDobForm();
	helpFullname();
	$('#name_toggle.ripple').removeClass('ripple');
	$('#dob_form').on({
		focus: function() {
			$('#dob').attr('placeholder', 'YYYY-MM-DD');
		},
		blur: function() {
			$('#dob').attr('placeholder', dobText);
		},
		focusout: function() {
			if (Modernizr.touch) {
				validateDob(true);
			}
		},
		change: function() {
			validateDob(false);
			helpDobForm();
		},
		keypress: function(e) {
			if (e.keyCode == 13 || e.which == 13) {
				$('#dob_submit').addClass('clicked');
				e.stopImmediatePropagation();
				e.stopPropagation();
				e.preventDefault();
				return false;
			} else {
				validateDob(false);
			}
			helpDobForm();
		},
		keyup: function(e) {
			if (e.which == 13) {
				$('#dob_submit').removeClass('clicked');
				validateDob(true);
			} else {
				validateDob(false);
			}
			helpDobForm();
		},
		keydown: function(e) {
			if (e.which == 13) {
				$('#dob_submit').addClass('clicked');
				e.stopImmediatePropagation();
				e.stopPropagation();
				e.preventDefault();
				return false;
			} else {
				validateDob(false);
			}
			helpDobForm();
		}
	}, '#dob').on({
		focus: function() {
			helpDobForm();
			helpFullname();
		},
		click: function() {
			helpDobForm();
			helpFullname();
		},
		hover: function() {
			helpDobForm();
			helpFullname();
		},
		change: function() {
			helpDobForm();
			helpFullname();
		},
		keypress: function(e) {
			if (e.keyCode == 13) {
				$('#dob_submit').addClass('clicked');
				e.stopImmediatePropagation();
				e.stopPropagation();
				e.preventDefault();
				return false;
			} else if (e.keyCode == 27) {
				$('#name_remove').addClass('clicked');
				e.stopImmediatePropagation();
				e.stopPropagation();
				e.preventDefault();
				return false;
			}
			helpDobForm();
			helpFullname();
		},
		keyup: function(e) {
			if (e.which == 13) {
				$('#dob_submit').removeClass('clicked');
				validateDob(true);
			} else if (e.which == 27) {
				$('#name_remove').removeClass('clicked');
				hideFullname();
			}
			helpDobForm();
			helpFullname();
		},
		keydown: function(e) {
			if (e.which == 13) {
				$('#dob_submit').addClass('clicked');
				e.stopImmediatePropagation();
				e.stopPropagation();
				e.preventDefault();
				return false;
			} else if (e.which == 27) {
				$('#name_remove').addClass('clicked');
				e.stopImmediatePropagation();
				e.stopPropagation();
				e.preventDefault();
				return false;
			}
			helpDobForm();
			helpFullname();
		}
	}, '#fullname').on('click', '#dob_bar', function() {
		if ($('#fullname').prop('disabled') == true || $('#dob').prop('disabled') == true) {
			enableFields(false);
		}
		helpDobForm();
	}).on('click', '#dob_submit', function() {
		validateDob(true);
		helpDobForm();
	}).on('click', '#dob_erase', function() {
		eraseDobField();
		validateDob(false);
		helpDobForm();
	}).on('click', '#name_remove', function() {
		hideFullname();
		helpDobForm();
	}).on('click', '#name_toggle', function() {
		showFullname();
		helpDobForm();
	});
}
function manipulateProverb() {
	if (isset(dob)) {
		$('#proverb').addClass('has_dob');
	}
	$('#proverb').on('click', 'i#proverb_refresh', function() {
		loadProverb(lang);
	});
}
function manipulateExplanation() {
	$('#explanation p.explain').each(function() {
		$(this).hover(function() {
			$(this).find('span.explain_more').addClass('hover');
		},function() {
			$(this).find('span.explain_more').removeClass('hover');
		});
	});
}
function manipulateBirthday() {
	if ($('body').hasClass('birthday')) {
		$('h1#heading').burn();
	} else if (!$('body').hasClass('birthday')) {
		$('h1#heading').burn(false);
	}
}
function manipulateLangBar() {	
	if ($('#lang_bar').length) {
		$('.lang_toggle.button').tsort({order:'desc',attr:'data-order'}).each(function(){
			if ($(this).attr('lang') == $('body').attr('lang')) {
				$(this).addClass('first').appendTo('#lang_bar');
			} else if ($(this).attr('lang') != $('body').attr('lang')) {
				$(this).removeClass('first');
			}
		});
	}
}
function manipulateLangEvent(langCode) {
	if ($('#lang_bar').length) {
		updateInterfaceLanguage(langCode);
		manipulateLangBar();
		loadProverb(langCode);
		loadNews(langCode);
		lang = langCode;
		dobText = dobTexts[langCode];
		fullnameText = fullnameTexts[langCode];
	}
}
function manipulateLangText() {
	$('#pham_tung').find('span.translate').attr('data-title',$('#pham_tung').find('span.translate').attr('data-lang-'+lang));
	$('span.translate').each(function() {
		$(this).text($(this).attr('data-lang-'+lang));
	});
	dobText = dobTexts[lang];
	fullnameText = fullnameTexts[lang];
}
function manipulateLang() {
	if ($('#lang_bar').length) {
		updateInterfaceLanguage(lang);
		manipulateLangBar();
		manipulateLangText();
		$('#lang_bar').on('click', '#vi_toggle', function() {
			if (!$(this).hasClass('clicked') && !$(this).hasClass('disabled')) {
				manipulateLangEvent('vi');
			}
		}).on('click', '#en_toggle', function() {
			if (!$(this).hasClass('clicked') && !$(this).hasClass('disabled')) {
				manipulateLangEvent('en');
			}
		}).on('click', '#ru_toggle', function() {
			if (!$(this).hasClass('clicked') && !$(this).hasClass('disabled')) {
				manipulateLangEvent('ru');
			}
		}).on('click', '#es_toggle', function() {
			if (!$(this).hasClass('clicked') && !$(this).hasClass('disabled')) {
				manipulateLangEvent('es');
			}
		}).on('click', '#zh_toggle', function() {
			if (!$(this).hasClass('clicked') && !$(this).hasClass('disabled')) {
				manipulateLangEvent('zh');
			}
		}).on('click', '#ja_toggle', function() {
			if (!$(this).hasClass('clicked') && !$(this).hasClass('disabled')) {
				manipulateLangEvent('ja');
			}
		});
		if (isset(decodeURIComponent(getUrlVars()['lang'])) && (decodeURIComponent(getUrlVars()['lang']) == 'vi' || decodeURIComponent(getUrlVars()['lang']) == 'en' || decodeURIComponent(getUrlVars()['lang']) == 'ru' || decodeURIComponent(getUrlVars()['lang']) == 'es' || decodeURIComponent(getUrlVars()['lang']) == 'zh' || decodeURIComponent(getUrlVars()['lang']) == 'ja')) {
			$('#'+decodeURIComponent(getUrlVars()['lang'])+'_toggle').trigger('click');
		}
	} else {
		$(document).ready(function(){
			$.datepicker.setDefaults($.datepicker.regional[lang]);
		});
		manipulateLangText();
	}
}
function manipulateVideo() {
	var $allVideos = $("iframe[src^='http://player.vimeo.com'], iframe[src^='http://www.youtube.com'], object, embed"),
	$fluidEl = $("figure");
	$allVideos.each(function() {
		$(this)
		// jQuery .data does not work on object/embed elements
		.attr('data-aspectRatio', this.height / this.width)
		.removeAttr('height')
		.removeAttr('width');
	});
	$(window).resize(function() {
		var newWidth = $fluidEl.width();
		$allVideos.each(function() {
			var $el = $(this);
			$el.width(newWidth).height(newWidth * $el.attr('data-aspectRatio'));
		});
	}).resize();
}
function manipulateButtons() {
	rippleButtons();
}
function manipulateHelper(selector,content) {
	$(selector).on({
		mouseenter: function(){
			$(selector).find('.helper').append('<div class="helper_box">'+content+'</div>');
		},
		mouseleave: function(){
			$(selector).find('.helper_box').remove();
		}
	}, '.helper').on('click', '.helper_box', function(){
		$(selector).find('.helper_box').remove();
	});
}
function manipulateInfor(selector,content) {
	$(selector).on({
		mouseenter: function(){
			$(selector).find('.infor').append('<div class="infor_box">'+content+'</div>');
		},
		mouseleave: function(){
			$(selector).find('.infor_box').remove();
		}
	}, '.infor').on('click', '.infor_box', function(){
		$(selector).find('.infor_box').remove();
	});
}
function manipulateScroll() {
	var offset = 300, offset_opacity = 1200, scroll_top_duration = 700;
	if ($(document).scrollTop() > 0) {
		$('body').addClass('scrolled');
	} else {
		$('body').removeClass('scrolled');
	}
	if ($(document).scrollTop() >= ($('#apps').offset().top-$('header').height())) {
		$('#apps_link').addClass('clicked');
	} else {
		$('#apps_link').removeClass('clicked');
	}
	animateScrollProverb();
	$(window).on('scroll mousewheel wheel DOMMouseScroll resize', function(){
		($(this).scrollTop() > offset) ? $('.to-top').addClass('is-visible') : $('.to-top').removeClass('is-visible fade-out');
		if($(this).scrollTop() > offset_opacity) {
			$('.to-top').addClass('fade-out');
		}
		if ($(document).scrollTop() > 0) {
			$('body').addClass('scrolled');
		} else {
			$('body').removeClass('scrolled');
		}
		if ($(document).scrollTop() >= Math.floor($('#apps').offset().top-$('header').height())) {
			$('#apps_link').addClass('clicked');
		} else {
			$('#apps_link').removeClass('clicked');
		}
		animateScrollProverb();
	});
	$('.to-top').on('click', function(e){
		e.preventDefault();
		$('body,html').stop().animate({scrollTop: 0}, scroll_top_duration);
	});
	$('#apps_link').on('click', function(){
		$('body, html').stop().animate({scrollTop: ($('#apps').offset().top-$('header').height())}, scroll_top_duration);
		$('#apps_link').addClass('clicked');
	});
}
function manipulateClock() {
	var clock = new analogClock();
	window.setInterval(function(){
		clock.run();
	}, 1000);
}
function manipulateMixPanel() {
	mixpanel.track_links('#logo', 'click logo link', {
		'referrer': document.referrer
	});
	mixpanel.track_links('#home_page', 'click home_page link', {
		'referrer': document.referrer
	});
	mixpanel.track_links('#home_link', 'click home_link link', {
		'referrer': document.referrer
	});
	mixpanel.track_links('#intro_link', 'click intro_link link', {
		'referrer': document.referrer
	});
	mixpanel.track_links('#blog_link', 'click blog_link link', {
		'referrer': document.referrer
	});
	mixpanel.track_links('#forum_link', 'click forum_link link', {
		'referrer': document.referrer
	});
	mixpanel.track_links('#lunar_link', 'click lunar_link link', {
		'referrer': document.referrer
	});
	mixpanel.track_links('#bmi_link', 'click bmi_link link', {
		'referrer': document.referrer
	});
	mixpanel.track_links('#survey_link', 'click survey_link link', {
		'referrer': document.referrer
	});
	mixpanel.track_links('#game_link', 'click game_link link', {
		'referrer': document.referrer
	});
	mixpanel.track_forms('#dob_form', 'submit dob_form');
}