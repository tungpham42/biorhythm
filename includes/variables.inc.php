<?php
error_reporting(-1);
ini_set('display_errors', 'On');
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/ip/geoipcity.inc.php';
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/ip/timezone.php';
$geoip = geoip_open(realpath($_SERVER['DOCUMENT_ROOT']).'/includes/ip/GeoIPCity.dat',GEOIP_STANDARD);
$geoip_record = geoip_record_by_addr($geoip,$_SERVER['REMOTE_ADDR']);
$lang_codes = array('vi','en','ru','es','zh','ja');
$navs = array('bmi','lunar','pong');
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/prep.inc.php';
$brand = 'Nhip Sinh Hoc . VN';
$p = isset($_GET['p']) ? prevent_xss($_GET['p']): 'home';
$q = isset($_GET['q']) ? prevent_xss($_GET['q']): '';
$dob = isset($_GET['dob']) ? prevent_xss($_GET['dob']): '';
$fullname = isset($_GET['fullname']) ? prevent_xss($_GET['fullname']): '';
$embed = isset($_GET['embed']) ? prevent_xss($_GET['embed']): 0;
$lang_code = init_lang_code();
$time_zone = 7;
$show_ad = true;
$show_donate = false;
$show_sponsor = false;
$show_addthis = false;
$show_sumome = true;
$credential_id = 4;
$number = calculate_life_path($dob);
if (isset($_GET['dob']) && isset($_GET['diff']) && isset($_GET['is_secondary']) && isset($_GET['dt_change']) && isset($_GET['partner_dob']) && isset($_GET['lang_code'])) {
	$chart = new Chart($_GET['dob'],$_GET['diff'],$_GET['is_secondary'],$_GET['dt_change'],$_GET['partner_dob'],$_GET['lang_code']);
} else {
	$date = (isset($_GET['date']) && $_GET['date'] != '') ? $_GET['date']: date('Y-m-d');
	$chart = new Chart($dob,0,0,$date,$dob,$lang_code);
}
$input_interfaces = array(
	'search' => array(
		'vi' => 'Tìm kiếm',
		'en' => 'Search',
		'ru' => 'Искать',
		'es' => 'Buscar',
		'zh' => '寻求',
		'ja' => '探す'
	),
	'fullname' => array(
		'vi' => 'Họ tên',
		'en' => 'Full name',
		'ru' => 'Полное имя',
		'es' => 'Nombre',
		'zh' => '全名',
		'ja' => 'フルネーム'
	),
	'dob' => array(
		'vi' => 'Ngày sinh',
		'en' => 'Date of birth',
		'ru' => 'Дата рождения',
		'es' => 'Fecha de nacimiento',
		'zh' => '出生日期',
		'ja' => '生まれた日'
	),
	'dt_change' => array(
		'vi' => 'Đổi ngày',
		'en' => 'Change date',
		'ru' => 'Изменение даты',
		'es' => 'Cambiar fecha',
		'zh' => '更改日期',
		'ja' => '日付の変更'
	),
	'partner_dob' => array(
		'vi' => 'Đối tác',
		'en' => 'Partner',
		'ru' => 'Напарник',
		'es' => 'Compañero',
		'zh' => '伙伴',
		'ja' => 'パートナー'
	)
);
$button_interfaces = array(
	'name_toggle' => array(
		'vi' => 'Họ tên',
		'en' => 'Full name',
		'ru' => 'Полное имя',
		'es' => 'Nombre',
		'zh' => '全名',
		'ja' => 'フルネーム'
	),
	'home_page' => array(
		'vi' => 'Trang chủ',
		'en' => 'Home',
		'ru' => 'Дом',
		'es' => 'Casa',
		'zh' => '主页',
		'ja' => 'わが家へ'
	),
	'dob_erase' => array(
		'vi' => 'Xóa',
		'en' => 'Erase',
		'ru' => 'Стирать',
		'es' => 'Borrar',
		'zh' => '抹去',
		'ja' => '消す'
	),
	'dob_submit' => array(
		'vi' => 'Chạy',
		'en' => 'Run',
		'ru' => 'Идти',
		'es' => 'Correr',
		'zh' => '运行',
		'ja' => '走る'
	),
	'today' => array(
		'vi' => ' Hôm nay',
		'en' => ' Today',
		'ru' => ' Сегодня',
		'es' => ' Hoy',
		'zh' => ' 今天',
		'ja' => ' 今日'
	),
	'prev' => array(
		'vi' => ' Trước',
		'en' => ' Back',
		'ru' => ' Назад',
		'es' => ' Atrás',
		'zh' => ' 回去',
		'ja' => ' 戻る'
	),
	'next' => array(
		'vi' => 'Sau ',
		'en' => 'Forward ',
		'ru' => 'Вперед ',
		'es' => 'Enviar ',
		'zh' => '前进 ',
		'ja' => '前進する '
	),
	'blog' => array(
		'vi' => 'Blog',
		'en' => 'Blog',
		'ru' => 'блог',
		'es' => 'Blog',
		'zh' => '博客',
		'ja' => 'ブログ'
	),
	'forum' => array(
		'vi' => 'Diễn đàn',
		'en' => 'Forum',
		'ru' => 'Форум',
		'es' => 'Forum',
		'zh' => '论坛',
		'ja' => 'フォーラム'
	),
	'bmi' => array(
		'vi' => 'Chỉ số khối cơ thể',
		'en' => 'Body mass index',
		'ru' => 'Индекс массы тела',
		'es' => 'Índice de masa corporal',
		'zh' => '身高體重指數',
		'ja' => 'ボディマス指数'
	),
	'lunar' => array(
		'vi' => 'Xem ngày',
		'en' => 'Lunar calendar',
		'ru' => 'Лунный календарь',
		'es' => 'Calendario lunar',
		'zh' => '阴历',
		'ja' => '太陰暦'
	),
	'game' => array(
		'vi' => 'Trò chơi',
		'en' => 'Game',
		'ru' => 'Игра',
		'es' => 'Juego',
		'zh' => '游戏',
		'ja' => 'ゲーム'
	),
	'donate' => array(
		'vi' => 'ĐÓNG GÓP',
		'en' => 'DONATE',
		'ru' => 'ДАРИТЬ',
		'es' => 'DONAR',
		'zh' => '捐赠',
		'ja' => '寄付する'
	),
	'donate_reason' => array(
		'vi' => 'nếu bạn thấy trang có ích',
		'en' => 'if you find it useful',
		'ru' => 'коли вас считать это полезным',
		'es' => 'si usted lo encuentra útil',
		'zh' => '如果您发现它有用',
		'ja' => 'あなたはそれが役立つかどう'
	),
	'sponsor' => array(
		'vi' => 'TÀI TRỢ',
		'en' => 'SPONSOR',
		'ru' => 'СПОНСОР',
		'es' => 'PATROCINIO',
		'zh' => '贊助',
		'ja' => 'スポンサー'
	),
	'sponsor_reason' => array(
		'vi' => 'để đặt quảng cáo',
		'en' => 'to put banner',
		'ru' => 'положить баннер',
		'es' => 'poner bandera',
		'zh' => '把旗帜',
		'ja' => 'バナーを置くために'
	)
);
$span_interfaces = array(
	'list_user_same_birthday_links' => array(
		'vi' => 'Những người trùng ngày sinh với bạn',
		'en' => 'People with same birthday with you',
		'ru' => 'Люди с таким же день рождения с вами',
		'es' => 'Las personas con el mismo cumpleaños con ustedes',
		'zh' => '人同与一天生日与你',
		'ja' => 'あなたと同じ誕生日の人々'
	),
	'list_user_birthday_links' => array(
		'vi' => 'Sinh nhật người nổi tiếng hôm nay',
		'en' => 'Celebrities birthdays today',
		'ru' => 'Знаменитости дня рождения',
		'es' => 'Celebridades cumpleaños hoy',
		'zh' => '名人今天生日',
		'ja' => '今日は有名人誕生日'
	),
	'list_user_links' => array(
		'vi' => 'Hiện ngày sinh người nổi tiếng',
		'en' => 'Show celebrities birth dates',
		'ru' => 'Показать знаменитости даты рождения',
		'es' => 'Mostrar celebridades fecha de nacimiento',
		'zh' => '示名人的出生日期',
		'ja' => '表示有名人誕生日'
	),
	'copyright' => array(
		'vi' => 'bản quyền thuộc',
		'en' => 'copyright',
		'ru' => 'авторское право',
		'es' => 'derechos del autor',
		'zh' => '著作權',
		'ja' => 'コピーライト'
	),
	'pham_tung' => array(
		'vi' => 'Phạm Tùng',
		'en' => 'Tung Pham',
		'ru' => 'Tung Pham',
		'es' => 'Tung Pham',
		'zh' => '范松',
		'ja' => '范松'
	),
	'email' => array(
		'vi' => 'Thư điện tử',
		'en' => 'Email',
		'ru' => 'Электронная почта',
		'es' => 'Correo electrónico',
		'zh' => '电子邮件',
		'ja' => '電子メール'
	),
	'blog' => array(
		'vi' => 'Blog',
		'en' => 'Blog',
		'ru' => 'блог',
		'es' => 'Blog',
		'zh' => '博客',
		'ja' => 'ブログ'
	)
);
$menu_interfaces = array(
	'today' => array(
		'vi' => 'Hôm nay',
		'en' => 'Today',
		'ru' => 'Сегодня',
		'es' => 'Hoy',
		'zh' => '今天',
		'ja' => '今日'
	),
	'prev' => array(
		'vi' => 'Trước',
		'en' => 'Back',
		'ru' => 'Назад',
		'es' => 'Atrás',
		'zh' => '回去',
		'ja' => '戻る'
	),
	'next' => array(
		'vi' => 'Sau',
		'en' => 'Forward',
		'ru' => 'Вперед',
		'es' => 'Enviar',
		'zh' => '前进',
		'ja' => '前進する'
	),
	'next_birthday' => array(
		'vi' => 'Sinh nhật tới',
		'en' => 'Next birthday',
		'ru' => 'Следующий день рождения',
		'es' => 'Próximo cumpleaños',
		'zh' => '下一个生日',
		'ja' => '次の誕生日'
	)
);
$help_interfaces = array(
	'info_box' => array(
		'vi' => 'Hiển thị các thông số liên quan đến ngày sinh của bạn.',
		'en' => 'Display the general statistics related to your birth date.',
		'ru' => 'Показать общую статистику, связанные с вашей даты рождения.',
		'es' => 'Mostrar las estadísticas generales relacionadas con su fecha de nacimiento.',
		'zh' => '显示与你的出生日期的统计资料。',
		'ja' => 'あなたの誕生日に関連する一般的な統計情報を表示します。'
	),
	'lunar_box' => array(
		'vi' => 'Hiển thị ngày tháng năm sinh Âm lịch của bạn. Ấn nút Ngày Âm lịch sẽ hiện ra ngày tháng năm Âm lịch hiện tại.',
		'en' => 'Display the Lunar Calendar year, month and day of your birth date. Click on Lunar date to show the current Lunar year, month and day.',
		'ru' => 'Отображение лунному календарю год, месяц и день вашего дня рождения. Нажмите на Лунной даты, чтобы показать текущий лунный год, месяц и день.',
		'es' => 'Visualizar el calendario lunar año, mes y día de su fecha de nacimiento. Clic en la fecha Lunar para mostrar la corriente Lunar año, mes y día.',
		'zh' => '显示您的出生日期是农历日历年，月，日。点击农历日期显示当前的农历年，月，日。',
		'ja' => 'あなたの誕生日の太陰暦の年、月、日を表示します。現在の月の年、月、日を示すために月の日付をクリックします。'
	),
	'compatibility_box' => array(
		'vi' => 'Cho biết sự khả năng hòa hợp giữa Bạn và Đối tác (người yêu, bạn bè, thân hữu). Chọn ngày sinh (theo thứ tự năm, tháng, ngày) của Đối tác để xem các chỉ số thể hiện mức độ hòa hợp, chỉ số phần trăm càng cao thì càng gần gũi.',
		'en' => 'Show the Compatibility between you and your Partner (lover, friends, acquaintance). Choose the birth date of your partner to get the values indicating compatibility, the higher the more compatible.',
		'ru' => 'Показать совместимость между вами и вашим партнером (любовник, друзья, знакомства). Выберите дату рождения вашего партнера, чтобы получить значения, указывающие совместимость, выше более совместимыми.',
		'es' => 'Mostrar el Compatibilidad entre usted y su pareja (amante, amigos, conocidos). Elija la fecha de nacimiento de su pareja para obtener los valores que indican la compatibilidad, el más alto es el más compatible.',
		'zh' => '告诉你和你的伴侣（情人，朋友，熟人）之间的兼容性。选择你的伴侣的出生日期以获得显示兼容性值，越高越不兼容。',
		'ja' => 'あなたとあなたのパートナー（恋人、友人、知人）間の互換性を表示します。より互換性が高い、互換性を示す値を取得するためにあなたのパートナーの誕生日を選択してください。'
	),
	'controls_box' => array(
		'vi' => 'Hiển thị các chỉ số nhịp sinh học cho ngày hiện tại, chỉ số phần trăm càng cao thì càng tốt. Ấn nút Hiện nhịp sinh học phụ để hiện ra thêm các chỉ số phụ. Chọn ngày bằng cách ấn ô Xem ngày. Ấn nút Trước và Sau để thay đổi ngày hiện tại, nút Hôm nay để trở về Hôm nay.',
		'en' => 'Display the biorhythm values for the current date, the higher the better. Press the button Show secondary rhythms to show more biorhythm values. Choose the date by clicking on the field View date. Click on Back or Forward to change the current date, show today values by clicking on Today.',
		'ru' => 'Отображение значения биоритмов на текущую дату. Нажмите кнопку Показать вторичные ритмы, чтобы показать несколько значений биоритмов. Выберите дату, нажав на дату поле зрения. Нажмите на вперед или назад, чтобы изменить текущую дату, показать значения сегодня, нажав на Сегодня.',
		'es' => 'Muestra los valores de biorritmo para la fecha actual. Pulse el botón Mostrar ritmos secundarias para mostrar más valores biorritmo. Elija la fecha haciendo clic en el campo de fecha Vista. Haga clic en Atrás o en Siguiente para cambiar la fecha actual, mostrar los valores actuales, haga clic en Hoy.',
		'zh' => '显示的生物节律的值对于当前日期。按下按钮显示次要节奏，表现出更多的生物节律值。通过单击现场查看日期。单击后退或前进，以改变当前的日期，点击今天显示今天的价值观。',
		'ja' => '現在の日付のためのバイオリズム値を表示します。より多くのバイオリズムの値を表示するためにボタンを表示二次リズムを押します。フィールドビューの日付をクリックして日付を選択してください。 、現在の日付を変更するには、戻るまたは進むをクリックして今日をクリックすることで、今日の値を表示。'
	),
	'biorhythm' => array(
		'vi' => 'nhịp sinh học',
		'en' => 'biorhythm',
		'ru' => 'биоритм',
		'es' => 'biorritmo',
		'zh' => '生理节律',
		'ja' => 'バイオリズム'
	),
	'definition' => array(
		'vi' => 'Nhịp sinh học (tiếng Anh: biorhythm) là một chu trình giả thiết về tình trạng khỏe mạnh hay năng lực sinh lý, cảm xúc, hoặc trí thông minh.',
		'en' => 'A biorhythm (from Greek βίος - bios, "life" and ῥυθμός - rhuthmos, "any regular recurring motion, rhythm"[2]) is an attempt to predict various aspects of a person\'s life through simple mathematical cycles. Most scientists believe that the idea has no more predictive power than chance and consider the concept an example of pseudoscience.',
		'ru' => 'Биологи́ческие ри́тмы — (биоритмы) периодически повторяющиеся изменения характера и интенсивности биологических процессов и явлений. Они свойственны живой материи на всех уровнях ее организации — от молекулярных и субклеточных до биосферы. Являются фундаментальным процессом в живой природе.',
		'es' => 'Los biorritmos constituyen un intento de predecir aspectos diversos de la vida de un individuo recurriendo a ciclos matemáticos sencillos. La mayoría de los investigadores estima que esta idea no tendría más poder predictivo que el que podría atribuirse al propio azar, considerándola un caso claro de pseudociencia.',
		'zh' => '生理节律是一種描述人類的身體、情感及智力的假想周期的理論。該概念与生物节律无关。在生物学和医学领域，这个词都是会被小心避免的，因為它被一些人認為是一种伪科学或是前科学。',
		'ja' => 'バイオリズム（英: biorhythm）とは、「生命」を意味する bio-（バイオ）と「規則的な運動」を意味する rhythm（リズム）の合成語で、生命体の生理状態、感情、知性などは周期的パターンに沿って変化するという仮説、およびそれを図示したグラフである。'
	),
	'wiki' => array(
		'vi' => 'http://vi.wikipedia.org/wiki/Nh%E1%BB%8Bp_sinh_h%E1%BB%8Dc',
		'en' => 'http://en.wikipedia.org/wiki/Biorhythm',
		'ru' => 'https://ru.wikipedia.org/wiki/%D0%91%D0%B8%D0%BE%D1%80%D0%B8%D1%82%D0%BC',
		'es' => 'http://es.wikipedia.org/wiki/Biorritmo',
		'zh' => 'http://zh.wikipedia.org/wiki/%E7%94%9F%E7%90%86%E8%8A%82%E5%BE%8B',
		'ja' => 'http://ja.wikipedia.org/wiki/%E3%83%90%E3%82%A4%E3%82%AA%E3%83%AA%E3%82%BA%E3%83%A0'
	),
	'life_path_number_prefix' => array(
		'vi' => 'http://nhipsinhhoc.vn/blog/con-so-cuoc-doi-',
		'en' => 'http://nhipsinhhoc.vn/blog/life-path-number-',
		'ru' => 'http://www.astroland.ru/numerology/lw/lifeway',
		'es' => 'http://www.horoscopius.es/numerologia/perfil-numerologico-para-el-numero-',
		'zh' => 'http://nhipsinhhoc.vn/blog/life-path-number-',
		'ja' => 'http://www.heavenlyblue.jp/num/'
	),
	'life_path_number_suffix' => array(
		'vi' => '/',
		'en' => '/',
		'ru' => '.htm',
		'es' => '/',
		'zh' => '/',
		'ja' => '.html'
	)
);
$information_interfaces = array(
	'average' => array(
		'vi' => array(
			'excellent' => 'Ngày hiện tại của bạn rất tốt, bạn nên tận hưởng ngày này.',
			'good' => 'Ngày hiện tại của bạn khá tốt, tuy nhiên bạn nên cẩn thận trong ngày này.',
			'gray' => 'Ngày hiện tại của bạn không được tốt lắm, bạn nên cẩn trọng hơn.',
			'bad' => 'Ngày hiện tại của bạn không khả quan, bạn nên cực kỳ cẩn thận.'
		),
		'en' => array(
			'excellent' => 'Your current day is excellent, enjoy it.',
			'good' => 'Your current day is quite good, take a little care.',
			'gray' => 'Your current day is not good, take more care of yourself.',
			'bad' => 'Your current day is bad, should take a lot of care.'
		),
		'ru' => array(
			'excellent' => 'Ваш текущий день отлично, наслаждаться ею.',
			'good' => 'Ваш текущий день является достаточно хорошим, возьмите немного заботы.',
			'gray' => 'Ваш текущий день не очень хорошо, больше заботиться о себе.',
			'bad' => 'Ваш текущий день плохо, должно занять много ухода.'
		),
		'es' => array(
			'excellent' => 'Su día actual es excelente, que lo disfruten.',
			'good' => 'Su día actual es bastante buena, tomar un poco de cuidado.',
			'gray' => 'Su día actual no es bueno, tener más cuidado de ti mismo.',
			'bad' => 'Su día actual es mala, hay que tener mucho cuidado.'
		),
		'zh' => array(
			'excellent' => '您当前的一天是优秀的，享受它。',
			'good' => '您当前的一天是相当不错的，需要一点点的关心。',
			'gray' => '您当前的日子是不好的，把自己的更多的关怀。',
			'bad' => '您当前的日子是不好的，应该采取大量的关怀。'
		),
		'ja' => array(
			'excellent' => 'あなたの現在の日が優れている、それを楽しむ。',
			'good' => '現在の日はかなり良いです、少し注意してください。',
			'gray' => '現在の日はよくない、自分のことをより多くの世話をする。',
			'bad' => 'あなたの現在の日が悪い、介護の多くを取る必要があります。'
		)
	),
	'physical' => array(
		'vi' => array(
			'excellent' => 'Sức khỏe hiện tại của bạn rất tốt, hãy tham gia vận động nhiều hơn.',
			'good' => 'Sức khỏe hiện tại của bạn khá tốt, hãy vận động điều độ.',
			'gray' => 'Sức khỏe hiện tại của bạn không được tốt, hãy nghĩ ngơi một tí.',
			'bad' => 'Sức khỏe hiện tại của bạn không khả quan, hãy nghỉ ngơi nhiều hơn.'
		),
		'en' => array(
			'excellent' => 'Your current health is excellent, you should work out more.',
			'good' => 'Your current health is quite good, you should work out with care.',
			'gray' => 'Your current health is not good, take a little rest.',
			'bad' => 'Your current health is bad, take more rest.'
		),
		'ru' => array(
			'excellent' => 'Ваше текущее здоровье отличное, вы должны работать больше.',
			'good' => 'Ваше текущее здоровье неплохое, вы должны работать с осторожностью.',
			'gray' => 'Ваше текущее здоровье не хорошо, немного отдохнуть.',
			'bad' => 'Ваше текущее здоровье плохо, взять больше отдыхать.'
		),
		'es' => array(
			'excellent' => 'Su estado de salud actual es excelente, debe trabajar más.',
			'good' => 'Su estado de salud actual es bastante bueno, usted debe hacer ejercicio con cuidado.',
			'gray' => 'Su estado de salud actual no es buena, tomar un poco de descanso.',
			'bad' => 'Su estado de salud actual es mala, tener más descanso.'
		),
		'zh' => array(
			'excellent' => '您当前的健康是优秀的，你应该更多。',
			'good' => '您当前的健康是相当不错的，你应该制定出谨慎。',
			'gray' => '你目前的身体不好，需要一点休息。',
			'bad' => '您当前的健康是不好的，需要更多的休息。'
		),
		'ja' => array(
			'excellent' => 'あなたの現在の健康状態が優れている、あなたはより多くを動作するはずです。',
			'good' => 'あなたの現在の健康状態はかなり良いですが、あなたが注意して動作するはずです。',
			'gray' => 'あなたの現在の健康状態が良くない、少し休憩を取る。',
			'bad' => 'あなたの現在の健康状態が悪いと、より多くの休息を取る。'
		)
	),
	'emotional' => array(
		'vi' => array(
			'excellent' => 'Tình cảm hiện tại của bạn rất tốt, hãy tham gia gặp gỡ bạn bè nhiều hơn.',
			'good' => 'Tình cảm hiện tại của bạn khá tốt, hãy gặp gỡ bạn bè.',
			'gray' => 'Tình cảm hiện tại của bạn không được tốt, bạn hơi dễ cáu kỉnh.',
			'bad' => 'Tình cảm hiện tại của bạn không khả quan, bạn nên tránh các cuộc xung đột.'
		),
		'en' => array(
			'excellent' => 'Your current mood is excellent, you meet more friends.',
			'good' => 'Your current mood is quite good, you should meet some friends.',
			'gray' => 'Your current mood is not good, you are easily annoyed.',
			'bad' => 'Your current mood is bad, avoid conflicts.'
		),
		'ru' => array(
			'excellent' => 'Ваше текущее настроение отличное, вы встретите больше друзей.',
			'good' => 'Ваше текущее настроение неплохое, вы должны встретиться с друзьями.',
			'gray' => 'Ваше текущее настроение не очень хорошо, вы легко раздражаться.',
			'bad' => 'Ваше текущее настроение плохое, во избежание конфликтов.'
		),
		'es' => array(
			'excellent' => 'Su estado de ánimo actual es excelente, te encuentras con más amigos.',
			'good' => 'Su estado de ánimo actual es bastante buena, usted debe cumplir con algunos amigos.',
			'gray' => 'Su estado de ánimo actual no es bueno, ustedes son fácilmente molesto.',
			'bad' => 'Su estado de ánimo actual es mala, evitar conflictos.'
		),
		'zh' => array(
			'excellent' => '你现在的心情非常好，你认识更多的朋友。',
			'good' => '你现在的心情是相当不错的，你应该满足一些朋友。',
			'gray' => '你现在的心情不是很好，你很容易生气。',
			'bad' => '你现在的心情不好，避免冲突。'
		),
		'ja' => array(
			'excellent' => 'あなたの現在の気分が優れている、あなたはより多くの友人に会う。',
			'good' => 'あなたの現在の気分はかなり良いですが、あなたは何人かの友人を満たしている必要があります。',
			'gray' => 'あなたの現在の気分が良くない、あなたは簡単にイライラです。',
			'bad' => 'あなたの現在の気分が悪い、競合を避ける。'
		)
	),
	'intellectual' => array(
		'vi' => array(
			'excellent' => 'Trí tuệ hiện tại của bạn rất tốt, bạn có thể đưa ra những quyết định sáng suốt.',
			'good' => 'Trí tuệ hiện tại của bạn khá tốt, bạn có thể đưa ra quyết định nhưng cần suy tính kỹ.',
			'gray' => 'Trí tuệ hiện tại của bạn không được tốt, bạn nên suy nghĩ kỹ trước khi ra quyết định.',
			'bad' => 'Trí tuệ hiện tại của bạn không khả quan, bạn không nên đưa ra quyết định lớn.'
		),
		'en' => array(
			'excellent' => 'Your current intellect is excellent, you can make great decisions.',
			'good' => 'Your current intellect is quite good, you can make decisions with a little care.',
			'gray' => 'Your current intellect is not good, you should think twice before making decisions.',
			'bad' => 'Your current intellect is bad, you should not make big decisions.'
		),
		'ru' => array(
			'excellent' => 'Ваше текущее интеллект отлично, вы можете сделать большие решения.',
			'good' => 'Ваше текущее интеллект является достаточно хорошим, вы можете принимать решения с особого ухода.',
			'gray' => 'Ваше текущее интеллект не является хорошим, вы должны подумать дважды, прежде чем принимать решения.',
			'bad' => 'Ваше текущее интеллект плохо, вы не должны делать большие решения.'
		),
		'es' => array(
			'excellent' => 'Su intelecto actual es excelente, puedes tomar grandes decisiones.',
			'good' => 'Su intelecto actual es bastante buena, se puede tomar decisiones con un poco de cuidado.',
			'gray' => 'Su intelecto actual no es buena, usted debe pensar dos veces antes de tomar decisiones.',
			'bad' => 'Su intelecto actual es mala, no debe tomar decisiones importantes.'
		),
		'zh' => array(
			'excellent' => '您当前的智力是优秀的，你可以做出伟大的决定。',
			'good' => '您当前的智力是相当不错的，你可以用一点点小心做出决定。',
			'gray' => '您当前的智力不好，你做决策前，应三思而后行。',
			'bad' => '您当前的智力是坏的，你不应该做出重大的决定。'
		),
		'ja' => array(
			'excellent' => 'あなたの現在の知性は、あなたは偉大な決定を行うことができ、優れたものである。',
			'good' => 'あなたの現在の知性はかなり良いですが、あなたは少し注意して意思決定を行うことができます。',
			'gray' => 'あなたの現在の知性はあなたが意思決定をする前に二度考える必要があり、良いではありません。',
			'bad' => 'あなたの現在の知性は、あなたは大きな意思決定を行うべきではない、悪いです。'
		)
	)
);