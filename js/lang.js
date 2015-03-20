var lang;
var dobText;
var fullnameText;
var addthisLink;

jQuery(function ($)
{
	$.datepicker.regional['vi'] =
	{
		closeText: 'Đóng',
		prevText: 'Trước',
		nextText: 'Sau',
		currentText: 'Hôm nay',
		monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
		monthNamesShort: ['Th 1', 'Th 2', 'Th 3', 'Th 4', 'Th 5', 'Th 6', 'Th 7', 'Th 8', 'Th 9', 'Th 10', 'Th 11', 'Th 12'],
		dayNames: ['Chủ nhật', 'Thứ hai', 'Thứ ba', 'Thứ tư', 'Thứ năm', 'Thứ sáu', 'Thứ bảy'],
		dayNamesShort: ['CN', 'Hai', 'Ba', 'Tư', 'Năm', 'Sáu', 'Bảy'],
		dayNamesMin: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
		weekHeader: 'Tuần',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''
	};
});
jQuery(function($) {
	$.datepicker.regional['en'] = {
		closeText: 'Done',
		prevText: 'Prev',
		nextText: 'Next',
		currentText: 'Today',
		monthNames: ['January','February','March','April','May','June','July','August','September','October','November','December'],
		monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
		dayNames: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
		dayNamesShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
		dayNamesMin: ['Su','Mo','Tu','We','Th','Fr','Sa'],
		weekHeader: 'Wk',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''
	};
});
jQuery(function($) {
	$.datepicker.regional['ru'] = {
		closeText: 'Закрыть',
		prevText: '&#x3c;Пред',
		nextText: 'След&#x3e;',
		currentText: 'Сегодня',
		monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
		monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт','Ноя','Дек'],
		dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
		dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
		dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
		weekHeader: 'Не',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
});
jQuery(function($) {
	$.datepicker.regional['es'] = {
		closeText: 'Cerrar',
		prevText: '&#x3c;Ant',
		nextText: 'Sig&#x3e;',
		currentText: 'Hoy',
		monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
		dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
		dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
		dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
		weekHeader: 'Sm',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''
	};
});
jQuery(function($) {
	$.datepicker.regional['zh'] = {
		closeText: '关闭',
		prevText: '&#x3c;上月',
		nextText: '下月&#x3e;',
		currentText: '今天',
		monthNames: ['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'],
		monthNamesShort: ['一','二','三','四','五','六','七','八','九','十','十一','十二'],
		dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],
		dayNamesShort: ['周日','周一','周二','周三','周四','周五','周六'],
		dayNamesMin: ['日','一','二','三','四','五','六'],
		weekHeader: '周',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: true,
		yearSuffix: '年'
	};
});
jQuery(function($) {
	$.datepicker.regional['ja'] = {
		closeText: '閉じる',
		prevText: '&#x3C;前',
		nextText: '次&#x3E;',
		currentText: '今日',
		monthNames: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
		monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
		dayNames: ['日曜日','月曜日','火曜日','水曜日','木曜日','金曜日','土曜日'],
		dayNamesShort: ['日','月','火','水','木','金','土'],
		dayNamesMin: ['日','月','火','水','木','金','土'],
		weekHeader: '週',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: true,
		yearSuffix: '年'
	};
});
function initLang() {
	var countryCode;
	var countryCodes = {
		'vi': ['VN'],
		'en': ['UK', 'US'],
		'ru': ['RU', 'AM', 'AZ', 'BY', 'KZ', 'KG', 'MD', 'TJ', 'UZ', 'TM', 'UA'],
		'es': ['ES', 'CO', 'PE', 'VE', 'EC', 'GT', 'CU', 'BO', 'HN', 'PY', 'SV', 'CR', 'PA', 'GQ', 'MX', 'AR', 'CL', 'DO', 'NI', 'UY', 'PR'],
		'zh': ['CN', 'HK', 'MO', 'TW', 'SG'],
		'ja': ['JP']
	};
	if (!$.cookie('NSH:lang')) {
		$.getJSON('./ip', function(response) {
			countryCode = response.country;
			console.log(countryCode);
			if (!$.cookie('NSH:lang')) {
				if ($.inArray(countryCode, countryCodes.vi) != -1) {
					$.cookie('NSH:lang','vi');
					lang = 'vi';
				} else if ($.inArray(countryCode, countryCodes.en) != -1) {
					$.cookie('NSH:lang','en');
					lang = 'en';
				} else if ($.inArray(countryCode, countryCodes.ru) != -1) {
					$.cookie('NSH:lang','ru');
					lang = 'ru';
				} else if ($.inArray(countryCode, countryCodes.es) != -1) {
					$.cookie('NSH:lang','es');
					lang = 'es';
				} else if ($.inArray(countryCode, countryCodes.zh) != -1) {
					$.cookie('NSH:lang','zh');
					lang = 'zh';
				} else if ($.inArray(countryCode, countryCodes.ja) != -1) {
					$.cookie('NSH:lang','ja');
					lang = 'ja';
				} else {
					$.cookie('NSH:lang','en');
					lang = 'en';
				}
			}
			manipulateLang();
		});
	} else {
		manipulateLang();
	}
}