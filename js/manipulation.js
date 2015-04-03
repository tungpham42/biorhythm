function manipulateHeader() {
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
	}, '#search').on('click', '#search_submit', function() {
		validateSearch(true);
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
		change: function() {
			validateDob(false);
			helpDobForm();
		},
		keypress: function(e) {
			if (e.keyCode == 13) {
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
		$('#home_page, #dob_erase, #prev, #next').removeClass('blue').addClass('orange');
		$('#proverb_content, li.rhythm, #embed_toggle, .helper, .infor').find('i').removeClass('icon-white').addClass('icon-orange');
		$('#logo').find('i').removeClass('m-icon-white').addClass('m-icon-orange');
		$('h1#heading').burn();
	} else if (!$('body').hasClass('birthday')) {
		$('#home_page, #dob_erase, #prev, #next').removeClass('orange').addClass('blue');
		$('#proverb_content, li.rhythm, #embed_toggle, .helper, .infor').find('i').removeClass('icon-orange').addClass('icon-white');
		$('#logo').find('i').removeClass('m-icon-orange').addClass('m-icon-white');
		$('h1#heading').burn(false);
	}
}
function manipulateLangBar() {
	$('.lang_toggle.button').tsort({order:'desc',attr:'data-order'}).each(function(){
		if ($(this).attr('lang') == $('body').attr('lang')) {
			$(this).addClass('first').appendTo('#lang_bar');
		} else if ($(this).attr('lang') != $('body').attr('lang')) {
			$(this).removeClass('first');
		}
	});
}
lang = $('body').attr('lang');
dobText = '';
fullnameText = '';
dobTexts = {
	'vi': 'Ngày sinh',
	'en': 'Date of birth',
	'ru': 'Дата рождения',
	'es': 'Fecha de nacimiento',
	'zh': '出生日期',
	'ja': '生まれた日'
};
fullnameTexts = {
	'vi': 'Họ tên',
	'en': 'Full name',
	'ru': 'Полное имя',
	'es': 'Nombre',
	'zh': '全名',
	'ja': 'フルネーム'
};
function manipulateLangEvent(langCode) {
	updateInterfaceLanguage(langCode);
	manipulateLangBar();
	loadProverb(langCode);
	lang = langCode;
	dobText = dobTexts[langCode];
	fullnameText = fullnameTexts[langCode];
}
function manipulateLang() {
	updateInterfaceLanguage(lang);
	manipulateLangBar();
	$('#pham_tung').find('span.translate').attr('data-title',$('#pham_tung').find('span.translate').attr('data-lang-'+lang));
	$('span.translate').each(function() {
		$(this).text($(this).attr('data-lang-'+lang));
	});
	if (lang == 'vi') {
		dobText = 'Ngày sinh';
		fullnameText = 'Họ tên';
	} else if (lang == 'en') {
		dobText = 'Date of birth';
		fullnameText = 'Full name';
	} else if (lang == 'ru') {
		dobText = 'Дата рождения';
		fullnameText = 'Полное имя';
	} else if (lang == 'es') {
		dobText = 'Fecha de nacimiento';
		fullnameText = 'Nombre';
	} else if (lang == 'zh') {
		dobText = '出生日期';
		fullnameText = '全名';
	} else if (lang == 'ja') {
		dobText = '生まれた日';
		fullnameText = 'フルネーム';
	}
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