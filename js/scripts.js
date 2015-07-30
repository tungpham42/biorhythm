function isset(variable) {
	if (typeof variable !== 'undefined' && variable !== 'undefined' && variable !== null) {
		return true;
	} else {
		return false;
	}
}
function isEmpty(selector) {
	if (!$.trim($(selector).val()).length) {
		return true;
	} else if ($.trim($(selector).val()).length) {
		return false;
	}
}
function isHovered(selector) {
	return $(selector+':hover').length > 0;
}
function isClicked(selector) {
	return $(selector+':active').length > 0;
}
function isFocused(selector) {
	return $(selector+':focus').length > 0;
}
function isBlurred(selector) {
	return $(selector+':not(:focus)').length > 0;
}
function isChild(parentSelector, childSelector) {
	if ($(parentSelector).find(childSelector).length > 0) {
		return true;
	} else if (!($(parentSelector).find(childSelector).length > 0)) {
		return false;
	}	
}
function selectText(containerid) {
	var range = null;
	if (document.selection) {
		range = document.body.createTextRange();
		range.moveToElementText(document.getElementById(containerid));
		range.select();
	} else if (window.getSelection) {
		range = document.createRange();
		range.selectNode(document.getElementById(containerid));
		window.getSelection().addRange(range);
	}
}
function countChar(string, character) {
	var charRegex = new RegExp(character, 'g');
	return (string.match(charRegex)||[]).length;
}
function escapeRegExp(str) {
	return str.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, '\\$&');
}
function replaceAll(find, replace, str) {
	return str.replace(new RegExp(escapeRegExp(find), 'g'), replace);
}
function getUrlVars() {
	var vars = [], hash;
	var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
	var hashesLength = hashes.length;
	for (var i = 0; i < hashesLength; ++i) {
		hash = hashes[i].split('=');
		vars.push(hash[0]);
		vars[hash[0]] = hash[1];
	}
	return vars;
}
function dateDiff(start, end) {
	var start_ts = new Date(start);
	var end_ts = new Date(end);
	var diff = end_ts.getTime() - start_ts.getTime();
	return Math.round(diff/86400000);
}
function isDate(txtDate) {
	var currVal = txtDate;
	if (currVal === '') {
		return false;
	}
	var rxDatePattern = /^(\d{4})(-)(\d{1,2})(-)(\d{1,2})$/; //Declare Regex
	var dtArray = currVal.match(rxDatePattern); // is format OK?

	if (dtArray === null) {
		return false;
	}
	dtMonth = dtArray[3];
	dtDay= dtArray[5];
	dtYear = dtArray[1];		
	
	if (dtMonth < 1 || dtMonth > 12) {
		return false;
	} else if (dtDay < 1 || dtDay> 31) {
		return false;
	} else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31) {
		return false;
	} else if (dtMonth == 2) {
		var isleap = (dtYear % 4 === 0 && (dtYear % 100 !== 0 || dtYear % 400 === 0));
		if (dtDay> 29 || (dtDay ==29 && !isleap)) {
			return false;
		}
	}
	return true;
}
function pad(s) {
	return (s < 10) ? '0' + s : s;
}
function dateFromISO(isostr) {
	var parts = isostr.match(/\d+/g);
	return new Date(parts[0], parts[1]-1, parts[2]);
}
function convertDate(inputFormat) {
	var d = (typeof inputFormat == 'string') ? dateFromISO(inputFormat): new Date(inputFormat);
	return [d.getFullYear(), pad(d.getMonth()+1), pad(d.getDate())].join('-');
}
function maskInput(input, textbox, location, delimiter) {
	//Get the delimiter positons
	var locs = location.split(',');
	var locsLength = locs.length;
	var inputLength = input.length;
	//Iterate until all the delimiters are placed in the textbox
	for (var delimCount = 0; delimCount <= locsLength; ++delimCount) {
		for (var inputCharCount = 0; inputCharCount <= inputLength; ++inputCharCount) {
			//Check for the actual position of the delimiter
			if (inputCharCount == locs[delimCount]) {
				//Confirm that the delimiter is not already present in that position
				if (input.substring(inputCharCount, inputCharCount + 1) != delimiter) {
					input = input.substring(0, inputCharCount) + delimiter + input.substring(inputCharCount, input.length);
				}
			}
		}
	}
	textbox.val(input);
}
function randomFromTo(from, to) {
	return Math.floor(Math.random() * (to - from + 1) + from);
}
function analogClock(){
}
analogClock.prototype.run = function() {
	var date = new Date();
	var second = date.getSeconds()*6;
	var minute = date.getMinutes()*6+second/60;
	var hour = ((date.getHours()%12)/12)*360+90+minute/12;
	jQuery('#hour').css('transform','rotate('+hour+'deg)');
	jQuery('#minute').css('transform','rotate('+minute+'deg)');
	jQuery('#second').css('transform', 'rotate('+second+'deg)');
};
$.fn.textWidth = function() {
	var htmlOrg = $(this).html();
	var htmlCalc = '<span>'+htmlOrg+'</span>';
	$(this).html(htmlCalc);
	var width = $(this).find('span:first').width();
	$(this).html(htmlOrg);
	return width;
};
// Highcharts plugin for displaying value information in the legend
// Author: Torstein Hønsi
// License: MIT license
// Last revision: 2013-07-29
(function (H) {
	H.Series.prototype.point = {}; // The active point
	H.Chart.prototype.callbacks.push(function (chart) {
		$(chart.container).bind('mousemove touchmove', function () {
			var legendOptions = chart.legend.options,
				hoverPoints = chart.hoverPoints;
			
			if (!hoverPoints && chart.hoverPoint) {
				hoverPoints = [chart.hoverPoint];
			}
			if (hoverPoints) {
				H.each(hoverPoints, function (point) {
					point.series.point = point;
				});
				H.each(chart.legend.allItems, function (item) {
					item.legendItem.attr({
						text: legendOptions.labelFormat ? 
							H.format(legendOptions.labelFormat, item) :
							legendOptions.labelFormatter.call(item)
					});
				});
				chart.legend.render();
			}
		});
	});
	// Hide the tooltip but allow the crosshair
	//H.Tooltip.prototype.defaultFormatter = function () { return false; };
}(Highcharts));

q = (isset($('span#variables').attr('data-q')) && $('span#variables').attr('data-q') !== '') ? $('span#variables').attr('data-q'): decodeURIComponent(getUrlVars()['q']);
p = (isset($('span#variables').attr('data-p')) && $('span#variables').attr('data-p') !== '') ? $('span#variables').attr('data-p'): decodeURIComponent(getUrlVars()['p']);
dob = (isset($('span#variables').attr('data-dob')) && $('span#variables').attr('data-dob') !== '') ? $('span#variables').attr('data-dob'): decodeURIComponent(getUrlVars()['dob']);
fullname = (isset($('span#variables').attr('data-fullname')) && $('span#variables').attr('data-fullname') !== '') ? $('span#variables').attr('data-fullname'): replaceAll('+',' ',decodeURIComponent(getUrlVars()['fullname']));
givenLang = window.location.pathname.substr(1,2);
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

function disableInput(fieldName) {
	$('#'+fieldName).on('keypress', function(e) {
		return false;
	}).on('keyup', function(e) {
		return false;
	}).on('keydown', function(e) {
		return false;
	});
}
function disableHyphen(fieldName) {
	$('#'+fieldName).on('keypress', function(e) {
		if (e.which == 45) {
			return false;
		}
	}).on('keyup', function(e) {
		if (e.which == 189 || e.which == 173 || e.which == 109) {
			return false;
		}
	}).on('keydown', function(e) {
		if (e.which == 189 || e.which == 173 || e.which == 109) {
			return false;
		}
	});
}
function updateHeadTitle(langCode) {
	ajaxData = {
		lang: langCode
	};
	if (isset(q)) {
		ajaxData.q = q;
	}
	if (isset(p)) {
		ajaxData.p = p;
	}
	if (isset(dob)) {
		ajaxData.dob = dob;
	}
	if (isset(fullname)) {
		ajaxData.fullname = fullname;
	}
	$.ajax({
		url: '/triggers/head_title.php',
		type: 'GET',
		cache: false,
		data: ajaxData,
		dataType: 'text',
		success: function(data) {
			$('head').find('title').html(data);
		}
	});
}
function updateHeadTitleBirthday(langCode,time) {
	ajaxData = {
		lang: langCode,
		time: time
	};
	if (isset(q)) {
		ajaxData.q = q;
	}
	if (isset(dob)) {
		ajaxData.dob = dob;
	}
	if (isset(fullname)) {
		ajaxData.fullname = fullname;
	}
	$.ajax({
		url: '/triggers/head_title_birthday.php',
		type: 'GET',
		cache: false,
		data: ajaxData,
		dataType: 'text',
		success: function(data) {
			$('head').find('title').html(data);
		}
	});
}
function updateHeadingH1(langCode) {
	ajaxData = {
		lang: langCode
	};
	if (isset(q)) {
		ajaxData.q = q;
	}
	if (isset(p)) {
		ajaxData.p = p;
	}
	if (isset(dob)) {
		ajaxData.dob = dob;
	}
	if (isset(fullname)) {
		ajaxData.fullname = fullname;
	}
	$.ajax({
		url: '/triggers/heading_h1.php',
		type: 'GET',
		cache: false,
		data: ajaxData,
		dataType: 'text',
		success: function(data) {
			$('h1#heading').html(data);
		}
	});
}
function updateHeadingH1Birthday(langCode,time) {
	ajaxData = {
		lang: langCode,
		time: time
	};
	if (isset(q)) {
		ajaxData.q = q;
	}
	if (isset(dob)) {
		ajaxData.dob = dob;
	}
	if (isset(fullname)) {
		ajaxData.fullname = fullname;
	}
	$.ajax({
		url: '/triggers/heading_h1_birthday.php',
		type: 'GET',
		cache: false,
		data: ajaxData,
		dataType: 'text',
		success: function(data) {
			$('h1#heading').html(data);
		}
	});
}
function updateHeadDescription(langCode) {
	ajaxData = {
		lang: langCode
	};
	if (isset(q)) {
		ajaxData.q = q;
	}
	if (isset(dob)) {
		ajaxData.dob = dob;
	}
	if (isset(fullname)) {
		ajaxData.fullname = fullname;
	}
	$.ajax({
		url: '/triggers/head_description.php',
		type: 'GET',
		cache: false,
		data: ajaxData,
		dataType: 'text',
		success: function(data) {
			$('head').find('meta[name="description"]').attr('content', data);
		}
	});
}
function updateHeadDescriptionBirthday(langCode,time) {
	ajaxData = {
		lang: langCode,
		time: time
	};
	if (isset(q)) {
		ajaxData.q = q;
	}
	if (isset(dob)) {
		ajaxData.dob = dob;
	}
	if (isset(fullname)) {
		ajaxData.fullname = fullname;
	}
	$.ajax({
		url: '/triggers/head_description_birthday.php',
		type: 'GET',
		cache: false,
		data: ajaxData,
		dataType: 'text',
		success: function(data) {
			$('head').find('meta[name="description"]').attr('content', data);
		}
	});
}
function updateInputInterface(inputId,langCode) {
	ajaxData = {
		input_id: inputId,
		lang: langCode
	};
	$.ajax({
		url: '/triggers/input_interface.php',
		type: 'GET',
		cache: false,
		data: ajaxData,
		dataType: 'text',
		success: function(data) {
			$('input[id="'+inputId+'"].translate').attr('placeholder', data);
		}
	});
}
function updateButtonInterface(buttonId,langCode) {
	ajaxData = {
		button_id: buttonId,
		lang: langCode
	};
	$.ajax({
		url: '/triggers/button_interface.php',
		type: 'GET',
		cache: false,
		data: ajaxData,
		dataType: 'text',
		success: function(data) {
			$('a[id="'+buttonId+'"].translate > span').html(data);
		}
	});
}
function updateChromeWebstoreItem(langCode) {
	ajaxData = {
		lang: langCode
	};
	$.ajax({
		url: '/triggers/chrome_webstore_item.php',
		type: 'GET',
		cache: false,
		data: ajaxData,
		dataType: 'text',
		success: function(data) {
			$('link[rel="chrome-webstore-item"]').attr('href',data);
		}
	});
}
function updateExplanation(langCode) {
	$.ajax({
		url: '/triggers/explanation.php',
		type: 'GET',
		cache: false,
		data: {
			lang: langCode
		},
		dataType: 'html',
		success: function(data) {
			$('#explanation').html(data);
		}
	});
}
function updateInterfaceLanguage(langCode) {
	var langCodes = ['vi', 'en', 'ru', 'es', 'zh', 'ja'];
	var langCodeIndex = $.inArray(langCode, langCodes);
	if ($('#lang_bar').length && langCodeIndex != -1) {
		langCodes.splice(langCodeIndex, 1);
		remainingLangCodeIds = '';
		remainingLangCodesCount = langCodes.length;
		for (i = 0; i < remainingLangCodesCount; ++i) {
			remainingLangCodeIds += '#'+langCodes[i]+'_toggle';
			if (i < remainingLangCodesCount-1) {
				remainingLangCodeIds += ', ';
			}
		}
		$('#'+langCode+'_toggle').addClass('clicked').addClass('disabled');
		$(remainingLangCodeIds).removeClass('clicked').removeClass('disabled');
		updateHeadTitle(langCode);
		updateHeadingH1(langCode);
		updateHeadDescription(langCode);
		updateChromeWebstoreItem(langCode);
		updateExplanation(langCode);
		$('#explanation').attr('data-lang', langCode);
		$('#pham_tung > span.translate').attr('data-title',$('#pham_tung > span.translate').attr('data-lang-'+langCode));
		$('span.translate').each(function() {
			$(this).text($(this).attr('data-lang-'+langCode));
		});
		$('input.translate').each(function() {
			$(this).text($(this).attr('data-lang-'+langCode)).attr('placeholder',$(this).attr('data-lang-'+langCode));
		});
		$('input[type="submit"].translate').each(function() {
			$(this).val($(this).attr('data-lang-'+langCode));
		});
		$('label.placeholder').each(function() {
			$(this).text($(this).next().attr('data-lang-'+langCode));
		});
		$.cookie('NSH:lang', langCode);
		$('html, body').attr('lang', langCode);
		$(document).ready(function(){
			$.datepicker.setDefaults($.datepicker.regional[langCode]);
		});
	}
}
function loadResults(dob,diff,isSecondary,dtChange,partnerDob,langCode) {
	if ($('#results').length) {
		$.ajax({
			url: '/triggers/results.php',
			type: 'GET',
			cache: false,
			data: {
				dob: dob,
				diff: diff,
				is_secondary: isSecondary,
				dt_change: dtChange,
				partner_dob: partnerDob,
				lang_code: langCode
			},
			dataType: 'html',
			success: function(data) {
				$('#results').html(data);
				if ($('body').hasClass('has_dob') || $('body').hasClass('member')) {
					manipulateBirthday();
					updateHeadTitleBirthday(langCode,dtChange);
					updateHeadDescriptionBirthday(langCode,dtChange);
					updateHeadingH1Birthday(langCode,dtChange);
				}
			}
		});
	}
}
function loadExplanationChartResults(dob,diff,isSecondary,dtChange,partnerDob,langCode) {
	if ($('#explanation_chart_results').length) {
		$.ajax({
			url: '/triggers/explanation_chart_results.php',
			type: 'GET',
			cache: false,
			data: {
				dob: dob,
				diff: diff,
				is_secondary: isSecondary,
				dt_change: dtChange,
				partner_dob: partnerDob,
				lang_code: langCode
			},
			dataType: 'html',
			success: function(data) {
				$('#explanation_chart_results').html(data);
			}
		});
	}
}
function loadEmbedChartResults(dob,diff,isSecondary,dtChange,partnerDob,langCode) {
	if ($('#embed_chart_results').length) {
		$.ajax({
			url: '/triggers/embed_chart_results.php',
			type: 'GET',
			cache: false,
			data: {
				dob: dob,
				diff: diff,
				is_secondary: isSecondary,
				dt_change: dtChange,
				partner_dob: partnerDob,
				lang_code: langCode
			},
			dataType: 'html',
			success: function(data) {
				$('#embed_chart_results').html(data);
			}
		});
	}
}
function loadProverb(langCode) {
	if ($('#proverb').length) {
		$.ajax({
			url: '/triggers/proverb.php',
			type: 'GET',
			cache: false,
			data: {
				lang_code: langCode
			},
			dataType: 'html',
			success: function(data) {
				$('#proverb').html(data);
				if ($('body').hasClass('has_dob')) {
					manipulateBirthday();
				}
			}
		});
	}
}
function loadNews(langCode) {
	if ($('#news').length) {
		$.ajax({
			url: '/triggers/news.php',
			type: 'GET',
			cache: false,
			data: {
				lang_code: langCode
			},
			dataType: 'html',
			success: function(data) {
				$('#news ul').html(data);
			}
		});
	}
}
function loadFeed(url,id) {
	if ($('#'+id).length) {
		$.ajax({
			url: '/triggers/feed.php',
			type: 'GET',
			cache: false,
			data: {
				url: url
			},
			dataType: 'html',
			success: function(data) {
				$('#'+id).find('div.feed').html(data);
			}
		});
	}
}
function loadHash(password) {
	$.ajax({
		url: '/triggers/hash.php',
		type: 'POST',
		cache: false,
		data: {
			unhashed: password
		},
		dataType: 'text',
		success: function(data) {
			$('#hashed').val(data);
		}
	});
}
function searchBirthdates(keyword) {
	if ($('#birthdates').length) {
		$.ajax({
			url: '/triggers/birthdates.php',
			type: 'GET',
			cache: false,
			data: {
				keyword: keyword
			},
			dataType: 'html',
			success: function(data) {
				$('#birthdates').html(data);
			}
		});
	}
}
function showBirthdates() {
	if ($('#birthdates').length) {
		$.ajax({
			url: '/triggers/birthdates.php',
			type: 'GET',
			cache: false,
			dataType: 'html',
			success: function(data) {
				$('#birthdates').html(data).show();
				if (!isEmpty('#user_birthdates_search')) {
					searchBirthdates($('#user_birthdates_search').val());
				}
			}
		});
	}
}
function hideBirthdates() {
	$('#birthdates').html('').hide();
}
function toggleFade(selector,state) {
	switch (state) {
		case 'show':
			$(selector).addClass('fade_toggle');
			break;
		case 'hide':
			$(selector).removeClass('fade_toggle');
			break;
		default:
			break;
	}
}
function checkFade(selector) {
	if ($(selector).hasClass('fade_toggle')) {
		return 'show';
	} else if (!$(selector).hasClass('fade_toggle')) {
		return 'hide';
	}
}
function toggleCookie(cookieName,objectSelector,toggleSelector,containerSelector) {
	if (!isset($.cookie(cookieName))) {
		if (checkFade(objectSelector) == 'hide' && !$(toggleSelector).hasClass('clicked')) {
			$(toggleSelector).addClass('clicked');
			$.cookie(cookieName, 'hide');
		} else if (checkFade(objectSelector) == 'show' && $(toggleSelector).hasClass('clicked')) {
			$(toggleSelector).removeClass('clicked');
			$.cookie(cookieName, 'show');
		}
	}
	if ($.cookie(cookieName) == 'show') {
		toggleFade(objectSelector,'show');
		$(toggleSelector).addClass('clicked');
	} else if ($.cookie(cookieName) == 'hide') {
		toggleFade(objectSelector,'hide');
		$(toggleSelector).removeClass('clicked');
	}
	$(containerSelector).on('click', toggleSelector, function(){
		if (checkFade(objectSelector) == 'hide' && !$(toggleSelector).hasClass('clicked')) {
			toggleFade(objectSelector,'show');
			$(toggleSelector).addClass('clicked');
			$.cookie(cookieName, 'show');
		} else if (checkFade(objectSelector) == 'show' && $(toggleSelector).hasClass('clicked')) {
			toggleFade(objectSelector,'hide');
			$(toggleSelector).removeClass('clicked');
			$.cookie(cookieName, 'hide');
		}
	});
}
function toggleRhythm(chartSelector,rhythmId,type) {
	var chart = $(chartSelector).highcharts();
	var series = chart.series[rhythmId];
	var cookieName = 'NSH:rhythm-'+type+'-id-'+rhythmId;
	if (!isset($.cookie(cookieName))) {
		if (!series.visible) {
			$.cookie(cookieName, 'hide');
		} else if (series.visible) {
			$.cookie(cookieName, 'show');
		}
	}
	if ($.cookie(cookieName) == 'show') {
		series.show();
	} else if ($.cookie(cookieName) == 'hide') {
		series.hide();
	}
}
function toggleRhythms(chartSelector,type) {
	var chart = $(chartSelector).highcharts();
	var seriesCount = chart.series.length;
	for (i = 0; i < seriesCount; ++i) {
		toggleRhythm(chartSelector,i,type);
	}
}
function generatePlotLines(todayIndex) {
	var plotLinesArray = [];
	plotLinesArray.push({
		color: '#c0c0c0',
		width: 2,
		value: 14,
		zIndex: 2
	});
	for (var i = 0; i <= 13; ++i) {
		plotLinesArray.push({
			color: '#e0e0c0',
			width: 1,
			value: i,
			zIndex: 1
		},{
			color: '#c0e0e0',
			width: 1,
			value: i+15,
			zIndex: 1
		});
	}
	if (todayIndex >= 0 && todayIndex <= 28 && todayIndex !== '') {
		plotLinesArray.push({
			color: '#c0e0c0',
			width: 2,
			value: todayIndex,
			zIndex: 2
		});
	}
	return plotLinesArray;
}
function setChartOptions(downloadJPEGText,downloadPDFText,downloadPNGText,downloadSVGText,printChartText,resetZoomText) {
	Highcharts.setOptions({
		global: {
			canvasToolsURL: "http://nhipsinhhoc.vn/js/highcharts/modules/canvas-tools.js"
		},
		lang: {
			downloadJPEG: downloadJPEGText,
			downloadPDF: downloadPDFText,
			downloadPNG: downloadPNGText,
			downloadSVG: downloadSVGText,
			printChart: printChartText,
			resetZoom: resetZoomText
		}
	});
}
function getLegendItemWidth() {
	switch (lang) {
		case 'vi': return 140; break;
		case 'en': return 140; break;
		case 'ru': return 190; break;
		case 'es': return 140; break;
		case 'zh': return 120; break;
		case 'ja': return 130; break;
	}
}
function renderChart(selector,titleText,percentageText,dateText,datesArray,todayIndex,dob,diff,isSecondary,dateDiff,seriesData,type) {
	var plotLinesArray = generatePlotLines(todayIndex);
	var chart = $(selector);
	chart.highcharts({
		chart: {
			type: 'spline',
			style: {
				fontFamily: '"Myriad Pro",sans-serif'
			}
		},
		colors: ['#f15c80','#d4c344','#8085e8','#8d4653','#81d8d1','#5c95cc','#434348','#90ed7d','#f7a35c','#7075d9'],
		credits: {
			href: 'http://nhipsinhhoc.vn/',
			text: 'Nhịp Sinh Học . VN',
			position: {
				align: 'right',
				x: -10,
				verticalAlign: 'bottom',
				y: -10
			}
		},
		exporting: {
			url: 'http://export.highcharts.com/'
		},
		title: {
			text: titleText
		},
		navigation: {
			buttonOptions: {
				theme: {
					stroke: '#e2e2e2',
					r: 0,
					states: {
						hover: {
							stroke: '#c2c2c2',
							fill: '#d2d2d2'
						},
						select: {
							stroke: '#a2a2a2',
							fill: '#b2b2b2'
						}
					}
				}
			},
			menuItemStyle: {
				fontWeight: 'bold',
				fontSize: '12px'
			},
			menuItemHoverStyle: {
				background: '#848484',
				color: '#e5e5e5',
				fontWeight: 'bold',
				fontSize: '12px'
			}
		},
		yAxis: {
			title: {
				text: percentageText+' (%)'
			},
			min: 0,
			max: 100,
			maxPadding: 0,
			tickInterval: 10,
			plotLines: [{
				color: '#c0c0c0',
				width: 2,
				value: 50
			}]
		},
		xAxis: {
			categories: datesArray,
			tickmarkPlacement: 'on',
			tickPosition: 'inside',
			tickColor: 'transparent',
			tickPixelInterval: 50,
			labels: {
				rotation: -90,
				x: 0
			},
			type: 'datetime',
			plotBands: [{
				color: '#ffffe0',
				from: 0,
				to: 14
			},
			{
				color: '#e0ffff',
				from: 14,
				to: 28
			}],
			plotLines: plotLinesArray
		},
		tooltip: {
			enabled: true,
			shared: true,
			followPointer: false,
			crosshairs: [{
				color: '#e0c0c0',
				dashStyle: 'solid',
				width: 2
			},
			{
				color: '#e0c0c0',
				dashStyle: 'solid',
				width: 2
			}],
			backgroundColor: 'rgba(250,250,250,0.666)',
			borderColor: '#c0c0c0',
			borderRadius: 4,
			snap: 42,
			useHTML: true,
			headerFormat: '<strong><u>'+dateText+': {point.key}</u></strong><table id="rhythms_table">',
			pointFormat: '<tr class="rhythm_value" id="rhythm_id_{series.index}"><td class="rhythm_label"><span style="color: {series.color}">{series.name}:</span></td><td class="value"><span><strong>{point.y} %<strong></span></td></tr>',
			footerFormat: '</table>'
		},
		legend: {
			enabled: true,
			align: 'center',
			itemWidth: getLegendItemWidth(),
			labelFormat: '<span style="color:{color}">{name}: </span><strong>{point.y} %</strong>'
		},
		plotOptions: {
			line: {
				dataLabels: {
					enabled: false
				},
				enableMouseTracking: true
			},
			series: {
				animation: false,
				stickyTracking: false,
				cursor: 'pointer',
				lineWidth: 1,
				events: {
					legendItemClick: function(e){
						e.preventDefault();
						if (!this.visible) {
							this.show();
							$.cookie('NSH:rhythm-'+type+'-id-'+this.index, 'show');
							$('i.rhythm_toggle[data-rhythm-id="'+this.index+'"]').removeClass('icon-heart-empty').addClass('icon-heart');
						} else if (this.visible) {
							this.hide();
							$.cookie('NSH:rhythm-'+type+'-id-'+this.index, 'hide');
							$('i.rhythm_toggle[data-rhythm-id="'+this.index+'"]').removeClass('icon-heart').addClass('icon-heart-empty');
						}
					}
				},
				marker: {
					radius: 1,
					fillColor: null,
					lineWidth: 1,
					lineColor: '#fff',
					symbol: 'circle',
					enabled: false,
					states: {
						hover: {
							enabled: true
						}
					}
				},
				states: {
					hover: {
						halo: null
					}
				},
				point: {
					events: {
						click: function(){
							switch (type) {
								case 'main':
									if ($('#partner_dob').val() != 'YYYY-MM-DD') {
										loadResults(dob,diff+this.x-14,isSecondary,convertDate(+new Date(dateDiff)+(this.x-14)*864e5),$('#partner_dob').val(),lang);
									} else if ($('#partner_dob').val() == 'YYYY-MM-DD') {
										loadResults(dob,diff+this.x-14,isSecondary,convertDate(+new Date(dateDiff)+(this.x-14)*864e5),dob,lang);
									}
									break;
								case 'embed':
									loadEmbedChartResults(dob,diff+this.x-14,isSecondary,convertDate(+new Date(dateDiff)+(this.x-14)*864e5),dob,lang);
									break;
								case 'explanation':
									loadExplanationChartResults(dob,diff+this.x-14,isSecondary,convertDate(+new Date(dateDiff)+(this.x-14)*864e5),dob,lang);
									break;
								default:
									break;
							}
							console.log(this.x);
						},
						mouseOver: function() {
							$('#rhythm_id_'+this.series.index).addClass('rhythm_hover');
							$('#rhythm_id_'+this.series.index).find('td.value > span').css('color',this.series.color);
						},
						mouseOut: function() {
							$('#rhythm_id_'+this.series.index).removeClass('rhythm_hover');
							$('#rhythm_id_'+this.series.index).find('td.value > span').css('color','black');
						}
					}
				}
			}
		},
		series: seriesData
	});
	$('.highcharts-xaxis-labels').find('text').on('click',function(){
		var labelText = this.textContent || this.innerText;
		var x = datesArray.indexOf(labelText);
		switch (type) {
			case 'main':
				if ($('#partner_dob').val() != 'YYYY-MM-DD') {
					loadResults(dob,diff+x-14,isSecondary,convertDate(+new Date(dateDiff)+(x-14)*864e5),$('#partner_dob').val(),lang);
				} else if ($('#partner_dob').val() == 'YYYY-MM-DD') {
					loadResults(dob,diff+x-14,isSecondary,convertDate(+new Date(dateDiff)+(x-14)*864e5),dob,lang);
				}
				break;
			case 'embed':
				loadEmbedChartResults(dob,diff+x-14,isSecondary,convertDate(+new Date(dateDiff)+(x-14)*864e5),dob,lang);
				break;
			case 'explanation':
				loadExplanationChartResults(dob,diff+x-14,isSecondary,convertDate(+new Date(dateDiff)+(x-14)*864e5),dob,lang);
				break;
			default:
				break;
		}
	});
	toggleRhythms(selector,type);
	if (type == 'main') {
		chart = $(selector).highcharts();
		$('i.rhythm_toggle').each(function(){
			id = $(this).attr('data-rhythm-id');
			series = chart.series[id];
			if (series.visible) {
				series.show();
				$.cookie('NSH:rhythm-'+type+'-id-'+id, 'show');
				$(this).removeClass('icon-heart-empty').addClass('icon-heart');
			} else if (!series.visible) {
				series.hide();
				$.cookie('NSH:rhythm-'+type+'-id-'+id, 'hide');
				$(this).removeClass('icon-heart').addClass('icon-heart-empty');
			}
			console.log(id);
		});
		$('i.rhythm_toggle').on('click', function(){
			id = $(this).attr('data-rhythm-id');
			series = chart.series[id];
			if (!series.visible) {
				series.show();
				$.cookie('NSH:rhythm-'+type+'-id-'+id, 'show');
				$(this).removeClass('icon-heart-empty').addClass('icon-heart');
				console.log(id);
			} else if (series.visible) {
				series.hide();
				$.cookie('NSH:rhythm-'+type+'-id-'+id, 'hide');
				$(this).removeClass('icon-heart').addClass('icon-heart-empty');
				console.log(id);
			}
		});
	}
}
/* Person Management */
function createPerson() {
	if ($('body').hasClass('member')) {
		ajaxData = {
			fullname: $('input[name="person_fullname"]').val(),
			dob: $('input[name="person_dob"]').val()
		};
		$.ajax({
			url: '/triggers/person_create.php',
			type: 'POST',
			cache: false,
			data: ajaxData,
			dataType: 'text',
			success: function(lastId) {
				$.ajax({
					url: '/triggers/person_list.php',
					type: 'GET',
					cache: false,
					dataType: 'html',
					success: function(data) {
						$('#persons_list').html(data);
						window.location = $('#my_birthdate').attr('href')+'?pid='+lastId;
					}
				});
			}
		});
	}
}
function editPerson() {
	if ($('body').hasClass('member')) {
		ajaxData = {
			pid: decodeURIComponent(getUrlVars()['pid']),
			fullname: $('input[name="person_fullname"]').val(),
			dob: $('input[name="person_dob"]').val()
		};
		$.ajax({
			url: '/triggers/person_edit.php',
			type: 'POST',
			cache: false,
			data: ajaxData,
			dataType: 'text',
			success: function() {
				$.ajax({
					url: '/triggers/person_list.php',
					type: 'GET',
					cache: false,
					dataType: 'html',
					success: function(data) {
						$('#persons_list').html(data);
						window.location = $('#my_birthdate').attr('href')+'?pid='+decodeURIComponent(getUrlVars()['pid']);
					}
				});
			}
		});
	}
}
function removePerson() {
	if ($('body').hasClass('member')) {
		ajaxData = {
			pid: decodeURIComponent(getUrlVars()['pid'])
		};
		$.ajax({
			url: '/triggers/person_remove.php',
			type: 'POST',
			cache: false,
			data: ajaxData,
			dataType: 'text',
			success: function() {
				$.ajax({
					url: '/triggers/person_list.php',
					type: 'GET',
					cache: false,
					dataType: 'html',
					success: function(data) {
						$('#persons_list').html(data);
						window.location = $('#my_birthdate').attr('href');
					}
				});
			}
		});
	}
}