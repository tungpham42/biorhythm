<?php
error_reporting(-1);
ini_set('display_errors', 'On');
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/ip/geoipcity.inc.php';
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/ip/timezone.php';
$geoip = geoip_open(realpath($_SERVER['DOCUMENT_ROOT']).'/includes/ip/GeoIPCity.dat',GEOIP_STANDARD);
$geoip_record = geoip_record_by_addr($geoip,$_SERVER['REMOTE_ADDR']);
$lang_codes = array('vi','en','ru','es','zh','ja');
$lang_fb_apis = array(
	'vi' => 'vi_VN',
	'en' => 'en_US',
	'ru' => 'ru_RU',
	'es' => 'es_ES',
	'zh' => 'zh_CN',
	'ja' => 'ja_JP'
);
$lang_g_apis = array(
	'vi' => 'vi',
	'en' => 'en-US',
	'ru' => 'ru',
	'es' => 'es',
	'zh' => 'zh-CN',
	'ja' => 'ja'
);
$navs = array('member/home','intro','bmi','lunar','2048');
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/includes/prep.inc.php';
$brand = 'Nhip Sinh Hoc . VN';
$p = isset($_GET['p']) ? prevent_xss($_GET['p']): 'home';
$q = isset($_GET['q']) ? prevent_xss($_GET['q']): '';
$dob = isset($_GET['dob']) ? prevent_xss($_GET['dob']): (isset($_COOKIE['NSH:remembered_dob']) ? $_COOKIE['NSH:remembered_dob']: '');
$fullname = isset($_GET['fullname']) ? prevent_xss($_GET['fullname']): (isset($_COOKIE['NSH:remembered_fullname']) ? $_COOKIE['NSH:remembered_fullname']: '');
$embed = isset($_GET['embed']) ? prevent_xss($_GET['embed']): 0;
$lang_code = init_lang_code();
$time_zone = 7;
$show_ad = true;
$show_donate = false;
$show_sponsor = false;
$show_addthis = false;
$show_sumome = false;
$clicktale = false;
$credential_id = 4; //change this to 4 in DEMO
$number = calculate_life_path($dob);
if (isset($_GET['dob']) && isset($_GET['diff']) && isset($_GET['is_secondary']) && isset($_GET['dt_change']) && isset($_GET['partner_dob']) && isset($_GET['lang_code'])) {
	$chart = new Chart($_GET['dob'],$_GET['diff'],$_GET['is_secondary'],$_GET['dt_change'],$_GET['partner_dob'],$_GET['lang_code']);
} else {
	$date = (isset($_GET['date']) && $_GET['date'] != '') ? $_GET['date']: date('Y-m-d');
	$chart = new Chart($dob,0,0,$date,$dob,$lang_code);
}
if (isset($_GET['ad'])) {
	setcookie('NSH:show_ad',$_GET['ad']);
}
$email_credentials = array(
	'username' => '',
	'password' => ''
);
$faroo_key = '';
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
	),
	'email' => array(
		'vi' => 'Thư điện tử',
		'en' => 'Email',
		'ru' => 'Электронная почта',
		'es' => 'Correo electrónico',
		'zh' => '电子邮件',
		'ja' => '電子メール'
	),
	'password' => array(
		'vi' => 'Mật khẩu',
		'en' => 'Password',
		'ru' => 'Пароль',
		'es' => 'Contraseña',
		'zh' => '密码',
		'ja' => 'パスワード'
	),
	'repeat_password' => array(
		'vi' => 'Lặp lại',
		'en' => 'Repeat',
		'ru' => 'Повторять',
		'es' => 'Repetición',
		'zh' => '重复',
		'ja' => 'リピート'
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
		'ja' => 'ホーム'
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
	'dob_list' => array(
		'vi' => 'Danh sách',
		'en' => 'List',
		'ru' => 'Список',
		'es' => 'Lista',
		'zh' => '名单',
		'ja' => 'リスト'
	),
	'dob_create' => array(
		'vi' => 'Tạo',
		'en' => 'Create',
		'ru' => 'Создать',
		'es' => 'Crear',
		'zh' => '创建',
		'ja' => '作る'
	),
	'dob_edit' => array(
		'vi' => 'Sửa',
		'en' => 'Edit',
		'ru' => 'Редактировать',
		'es' => 'Editar',
		'zh' => '编辑',
		'ja' => '編集'
	),
	'dob_remove' => array(
		'vi' => 'Xóa hẳn',
		'en' => 'Remove',
		'ru' => 'Удалить',
		'es' => 'Quitar',
		'zh' => '拆除',
		'ja' => '削除します'
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
	'intro' => array(
		'vi' => 'Giới thiệu',
		'en' => 'Introduction',
		'ru' => 'Введение',
		'es' => 'Introducción',
		'zh' => '介绍',
		'ja' => 'はじめに'
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
		'vi' => 'BMI',
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
	'survey' => array(
		'vi' => 'Góp ý',
		'en' => 'Survey',
		'ru' => 'Обзор',
		'es' => 'Estudio',
		'zh' => '调查',
		'ja' => '調査'
	),
	'apps' => array(
		'vi' => 'Ứng dụng',
		'en' => 'Applications',
		'ru' => 'Приложений',
		'es' => 'Aplicaciones',
		'zh' => '应用',
		'ja' => 'アプリ'
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
	),
	'install_chrome' => array(
		'vi' => 'Thêm vào Chrome',
		'en' => 'Add to Chrome',
		'ru' => 'Добавить в Chrome',
		'es' => 'Añadir a Chrome',
		'zh' => '添加到Chrome浏览器',
		'ja' => 'クロームに追加'
	),
	'install_firefox' => array(
		'vi' => 'Cài ứng dụng Firefox',
		'en' => 'Install Firefox app',
		'ru' => 'Установите Firefox приложение',
		'es' => 'Instalar Firefox aplicación',
		'zh' => '安装Firefox的应用程序',
		'ja' => 'Firefoxのアプリをインストール'
	),
	'register' => array(
		'vi' => 'Đăng ký',
		'en' => 'Register',
		'ru' => 'Регистр',
		'es' => 'Registrarse',
		'zh' => '注册',
		'ja' => '登録'
	),
	'update' => array(
		'vi' => 'Cập nhật',
		'en' => 'Update',
		'ru' => 'Обновлять',
		'es' => 'Actualizar',
		'zh' => '更新',
		'ja' => 'アップデート'
	),
	'login' => array(
		'vi' => 'Đăng nhập',
		'en' => 'Log In',
		'ru' => 'Войти',
		'es' => 'Iniciar Sesión',
		'zh' => '登录',
		'ja' => 'ログイン'
	),
	'logout' => array(
		'vi' => 'Đăng xuất',
		'en' => 'Log Out',
		'ru' => 'Выйти',
		'es' => 'Cerrar Sesión',
		'zh' => '登出',
		'ja' => 'ログアウト'
	),
	'edit' => array(
		'vi' => 'Sửa',
		'en' => 'Edit',
		'ru' => 'Редактировать',
		'es' => 'Editar',
		'zh' => '编辑',
		'ja' => '編集'
	),
	'profile' => array(
		'vi' => 'Hồ sơ',
		'en' => 'Profile',
		'ru' => 'Профиль',
		'es' => 'Perfil',
		'zh' => '轮廓',
		'ja' => 'プロフィール'
	),
	'sleep_now' => array(
		'vi' => 'Ngủ ngay bây giờ!',
		'en' => 'Sleep now!',
		'ru' => 'Засыпай!',
		'es' => '¡Duerme ahora!',
		'zh' => '现在睡觉！',
		'ja' => '今スリープ！'
	)
);
$span_interfaces = array(
	'me' => array(
		'vi' => 'Tôi',
		'en' => 'Me',
		'ru' => 'Меня',
		'es' => 'Yo',
		'zh' => '我',
		'ja' => '私に'
	),
	'list_user_same_birthday_links' => array(
		'vi' => 'Những người trùng ngày sinh với tôi',
		'en' => 'People with same birthday with me',
		'ru' => 'Люди с таким же рождения со мной',
		'es' => 'Las personas con misma fecha de cumpleaños conmigo',
		'zh' => '与人同一天生日与我',
		'ja' => '私と同じ誕生日を持つ人々'
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
		'vi' => 'Ngày sinh người nổi tiếng',
		'en' => 'Celebrities birth dates',
		'ru' => 'Знаменитости даты рождения',
		'es' => 'Celebridades fecha de nacimiento',
		'zh' => '人的出生日期',
		'ja' => '有名人誕生日'
	),
	'list_persons' => array(
		'vi' => 'Danh sách ngày sinh của tôi',
		'en' => 'My birthdates list',
		'ru' => 'Мой список дат рождения',
		'es' => 'Mi lista de fechas de nacimiento',
		'zh' => '我的出生日期列表',
		'ja' => '私の誕生日一覧'
	),
	'no_persons' => array(
		'vi' => 'Tạo ngày sinh đầu tiên nào',
		'en' => 'Create first birthdate now',
		'ru' => 'Создать первую дату рождения в настоящее время',
		'es' => 'Crea primera fecha de nacimiento ahora',
		'zh' => '现在创建第一个生日',
		'ja' => '今最初の誕生日を作成します'
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
		'ru' => 'Тунг Фам',
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
	),
	'forum' => array(
		'vi' => 'Diễn đàn',
		'en' => 'Forum',
		'ru' => 'Форум',
		'es' => 'Forum',
		'zh' => '论坛',
		'ja' => 'フォーラム'
	),
	'sleep_time' => array(
		'vi' => 'Nhịp sinh học ngủ',
		'en' => 'Sleep rhythm',
		'ru' => 'Ритм сна',
		'es' => 'Ritmo del sueño',
		'zh' => '睡眠节律',
		'ja' => '睡眠リズム'
	),
	'hour' => array(
		'vi' => 'Giờ',
		'en' => 'Hour',
		'ru' => 'Час',
		'es' => 'Hora',
		'zh' => '钟头',
		'ja' => 'アワー'
	),
	'minute' => array(
		'vi' => 'Phút',
		'en' => 'Minute',
		'ru' => 'Минут',
		'es' => 'Minuto',
		'zh' => '分钟',
		'ja' => '一刻'
	),
	'sleep_time_head' => array(
		'vi' => 'Nếu bạn dự định thức dậy lúc',
		'en' => 'If you plan to get up at',
		'ru' => 'Если вы встаете на',
		'es' => 'Si te levantas a',
		'zh' => '如果你起床',
		'ja' => 'あなたは時に起きる場合'
	),
	'wake_up_time_head' => array(
		'vi' => 'Hoặc nếu bạn muốn ngủ ngay bây giờ',
		'en' => 'Or if you want to sleep right now',
		'ru' => 'Или, если вы ложитесь спать прямо сейчас',
		'es' => 'O si usted va a dormir en este momento',
		'zh' => '或者，如果你去睡觉，现在',
		'ja' => 'あるいは場合は、あなたは今すぐに眠りにつきます'
	),
	'sleep_time_results' => array(
		'vi' => 'Bạn nên đi ngủ vào một trong những giờ sau:',
		'en' => 'You should try to fall asleep at one of the following times:',
		'ru' => 'Вы должны попытаться заснуть в одном из следующих времен:',
		'es' => 'Usted debe tratar de conciliar el sueño en uno de los siguientes horarios:',
		'zh' => '你应该尝试入睡的以下任一：',
		'ja' => 'あなたは、以下のいずれかの時点で眠りに落ちるようにしてください：'
	),
	'wake_up_time_results' => array(
		'vi' => 'Bạn nên thức dậy vào một trong những giờ sau:',
		'en' => 'You should try to get up at one of the following times:',
		'ru' => 'Вы должны попробовать, чтобы встать в один из следующих случаях:',
		'es' => 'Usted debe tratar de levantarse a uno de los siguientes horarios:',
		'zh' => '你应该尝试起床的以下任一：',
		'ja' => 'あなたは、以下のいずれかの時点で、最大取得しようとする必要があります：'
	),
	'news' => array(
		'vi' => 'Tin tức',
		'en' => 'News',
		'ru' => 'Новости',
		'es' => 'Noticias',
		'zh' => '新闻',
		'ja' => 'ニュース'
	),
	'apps' => array(
		'vi' => 'Ứng dụng',
		'en' => 'Applications',
		'ru' => 'Приложений',
		'es' => 'Aplicaciones',
		'zh' => '应用',
		'ja' => 'アプリ'
	),
	'apps_six_lang' => array(
		'vi' => '6 ngôn ngữ',
		'en' => '6 language',
		'ru' => '6 язык',
		'es' => '6 lenguaje',
		'zh' => '6語言',
		'ja' => '6言語'
	),
	'apps_one_lang' => array(
		'vi' => 'Một ngôn ngữ',
		'en' => 'Single language',
		'ru' => 'Один язык',
		'es' => 'Uno lenguaje',
		'zh' => '一語言',
		'ja' => '一言語'
	),
	'email' => array(
		'vi' => 'Thư điện tử',
		'en' => 'Email',
		'ru' => 'Электронная почта',
		'es' => 'Correo electrónico',
		'zh' => '电子邮件',
		'ja' => '電子メール'
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
	'password' => array(
		'vi' => 'Mật khẩu',
		'en' => 'Password',
		'ru' => 'Пароль',
		'es' => 'Contraseña',
		'zh' => '密码',
		'ja' => 'パスワード'
	),
	'repeat_password' => array(
		'vi' => 'Lặp lại',
		'en' => 'Repeat',
		'ru' => 'Повторять',
		'es' => 'Repetición',
		'zh' => '重复',
		'ja' => 'リピート'
	),
	'register' => array(
		'vi' => 'Đăng ký',
		'en' => 'Register',
		'ru' => 'Регистр',
		'es' => 'Registrarse',
		'zh' => '注册',
		'ja' => '登録'
	),
	'login' => array(
		'vi' => 'Đăng nhập',
		'en' => 'Log In',
		'ru' => 'Войти',
		'es' => 'Iniciar Sesión',
		'zh' => '登录',
		'ja' => 'ログイン'
	),
	'not_yet_registered' => array(
		'vi' => 'Chưa đăng ký?',
		'en' => 'Not yet registered?',
		'ru' => 'Еще не зарегистрированы?',
		'es' => '¿Todavía no estás registrado?',
		'zh' => '尚未注册？',
		'ja' => 'まだ登録されていませんか？'
	),
	'already_registered' => array(
		'vi' => 'Đã đăng ký?',
		'en' => 'Already registered?',
		'ru' => 'Уже зарегистрирован?',
		'es' => '¿Ya registrado?',
		'zh' => '已经注册？',
		'ja' => '既に登録されています？'
	),
	'register_modal' => array(
		'vi' => 'Hãy đăng ký ngay và khám phá thêm nhiều tính năng.',
		'en' => 'Register now to explore more features.',
		'ru' => 'Зарегистрируйтесь сейчас, чтобы изучить больше возможностей.',
		'es' => 'Registrate ahora para explorar más características.',
		'zh' => '现在注册探索更多的功能。',
		'ja' => 'より多くの機能を探索するために今すぐ登録。'
	),
	'biorhythm' => array(
		'vi' => 'nhịp sinh học',
		'en' => 'biorhythm',
		'ru' => 'биоритм',
		'es' => 'biorritmo',
		'zh' => '生理节律',
		'ja' => 'バイオリズム'
	),
	'health' => array(
		'vi' => 'sức khỏe',
		'en' => 'health',
		'ru' => 'здоровье',
		'es' => 'salud',
		'zh' => '健康',
		'ja' => 'ヘルス'
	),
	'year' => array(
		'vi' => 'năm',
		'en' => 'year',
		'ru' => 'год',
		'es' => 'año',
		'zh' => '年',
		'ja' => '年'
	),
	'keyboard_shortcuts' => array(
		'vi' => 'Phím tắt',
		'en' => 'Keyboard shortcuts',
		'ru' => 'Горячие клавиши',
		'es' => 'Atajos de teclado',
		'zh' => '快捷键',
		'ja' => 'キーボードショートカット'
	),
	'for_reference_only' => array(
		'vi' => 'Chỉ mang tính tham khảo',
		'en' => 'For reference only',
		'ru' => 'Только для справки',
		'es' => 'Solo por referencia',
		'zh' => '仅供参考',
		'ja' => '参考のためのみ'
	),
	'comments_head' => array(
		'vi' => 'Mong nhận được ý kiến của các bạn. Hãy để lại bình luận dưới đây.',
		'en' => 'Look forward to your comments. Put them down here.',
		'ru' => 'Посмотрите ждем ваших комментариев. Положите их сюда.',
		'es' => 'Esperamos sus comentarios. Póngalos aquí.',
		'zh' => '期待您的意见。把它们放在这儿。',
		'ja' => 'あなたのコメントを楽しみにしています。ここではそれらを置きます。'
	),
	'bmi_weight' => array(
		'vi' => 'Cân nặng:',
		'en' => 'Weight:',
		'ru' => 'Вес:',
		'es' => 'Peso:',
		'zh' => '重量：',
		'ja' => '重さ：'
	),
	'bmi_height' => array(
		'vi' => 'Chiều cao:',
		'en' => 'Height:',
		'ru' => 'Высота:',
		'es' => 'Altura:',
		'zh' => '身高：',
		'ja' => '身長：'
	),
	'bmi_weight_unit' => array(
		'vi' => 'ký',
		'en' => 'kg',
		'ru' => 'кг',
		'es' => 'kilo',
		'zh' => '千克',
		'ja' => 'キロ'
	),
	'bmi_height_unit' => array(
		'vi' => 'mét',
		'en' => 'metre',
		'ru' => 'метр',
		'es' => 'medidor',
		'zh' => '计',
		'ja' => 'メーター'
	),
	'bmi_value' => array(
		'vi' => 'Chỉ số BMI:',
		'en' => 'BMI value:',
		'ru' => 'Значение ИМТ:',
		'es' => 'Valor de IMC:',
		'zh' => 'BMI值：',
		'ja' => 'BMI値：'
	),
	'bmi_explanation' => array(
		'vi' => 'Đánh giá:',
		'en' => 'Explanation:',
		'ru' => 'Объяснение:',
		'es' => 'Explicación:',
		'zh' => '说明：',
		'ja' => '説明：'
	),
	'bmi_ideal_weight' => array(
		'vi' => 'Cân nặng lý tưởng:',
		'en' => 'Ideal weight:',
		'ru' => 'Идеальный вес:',
		'es' => 'Peso ideal:',
		'zh' => '理想的体重：',
		'ja' => '理想的な体重：'
	),
	'bmi_ideal_height' => array(
		'vi' => 'Chiều cao lý tưởng:',
		'en' => 'Ideal height:',
		'ru' => 'Идеальная высота:',
		'es' => 'Altura ideal:',
		'zh' => '理想的身高：',
		'ja' => '理想の高さ：'
	),
	'bmi_recommendation' => array(
		'vi' => 'Lời khuyên:',
		'en' => 'Recommendation:',
		'ru' => 'Рекомендация:',
		'es' => 'Recomendación:',
		'zh' => '建议：',
		'ja' => '推奨事項：'
	),
	'bmi' => array(
		'vi' => 'Chỉ số khối cơ thể',
		'en' => 'Body mass index',
		'ru' => 'Индекс массы тела',
		'es' => 'Índice de masa corporal',
		'zh' => '身高體重指數',
		'ja' => 'ボディマス指数'
	)
);
$email_interfaces = array(
	'hi' => array(
		'vi' => 'Xin chào bạn',
		'en' => 'Hi',
		'ru' => 'Привет',
		'es' => 'Hola',
		'zh' => '你好',
		'ja' => 'こんにちは'
	),
	'create_user_thank' => array(
		'vi' => 'Cám ơn bạn đã quan tâm đến Nhịp sinh học.',
		'en' => 'Thank you for your interest in Biorhythm.',
		'ru' => 'Спасибо за ваш интерес к Биоритмы.',
		'es' => 'Gracias por su interés en Biorritmo usted.',
		'zh' => '感谢您对生物节律的兴趣。',
		'ja' => 'バイオリズムにご関心をお寄せいただき、ありがとうございます。'
	),
	'create_user_detail' => array(
		'vi' => 'Sau đây là thông tin tài khoản của bạn:',
		'en' => 'Here is your account information:',
		'ru' => 'Вот информация Ваш счет:',
		'es' => 'Aquí está la información de su cuenta:',
		'zh' => '这是您的帐户信息：',
		'ja' => 'ここにあなたのアカウント情報は、次のとおりです：'
	),
	'edit_user_notify' => array(
		'vi' => 'Bạn đã cập nhật hồ sơ Nhịp sinh học.',
		'en' => 'You have updated your Biorhythm profile.',
		'ru' => 'Вы обновили свой профиль Биоритм.',
		'es' => 'Ha actualizado su perfil Biorritmo.',
		'zh' => '您已经更新了您的个人资料生物节律。',
		'ja' => 'あなたのバイオリズムのプロフィールを更新しました。'
	),
	'edit_user_detail' => array(
		'vi' => 'Sau đây là thông tin tài khoản của bạn sau khi sửa đổi hồ sơ:',
		'en' => 'Here is your account information after updating profile:',
		'ru' => 'Вот информация Ваш счет после обновления профиля:',
		'es' => 'Aquí está la información de su cuenta después de actualizar el perfil:',
		'zh' => '这里是更新配置文件后您的帐户信息：',
		'ja' => 'ここでは、プロファイルを更新した後、あなたのアカウント情報は、次のとおりです：'
	),
	'daily_suggestion' => array(
		'vi' => 'Đây là lời khuyên cho hôm nay của bạn',
		'en' => 'This is your daily suggestion',
		'ru' => 'Это ваш день предложение',
		'es' => 'Esta es su sugerencia diaria',
		'zh' => '这是你的每日建议',
		'ja' => 'これはあなたの毎日の提案です'
	),
	'daily_values' => array(
		'vi' => 'Các chỉ số nhịp sinh học chính của bạn',
		'en' => 'Your primary biorhythm values',
		'ru' => 'Ваши первичные значения биоритмов',
		'es' => 'Sus valores biorritmo primarias',
		'zh' => '您的主要生物节律值',
		'ja' => 'あなたの主なバイオリズム値'
	),
	'go_to_your_profile' => array(
		'vi' => 'Đi đến hồ sơ của bạn',
		'en' => 'Go to your profile',
		'ru' => 'Перейти в профиль',
		'es' => 'Ir a su perfil',
		'zh' => '转到您的个人资料',
		'ja' => 'あなたのプロフィールに移動します'
	),
	'colon' => array(
		'vi' => ':',
		'en' => ':',
		'ru' => ':',
		'es' => ':',
		'zh' => '：',
		'ja' => '：'
	),
	'going_up' => array(
		'vi' => 'đang lên',
		'en' => 'going up',
		'ru' => 'подниматься',
		'es' => 'subiendo',
		'zh' => '上升',
		'ja' => '上がっていく'
	),
	'going_down' => array(
		'vi' => 'đang xuống',
		'en' => 'going down',
		'ru' => 'спускаться',
		'es' => 'bajando',
		'zh' => '下降',
		'ja' => '下っていく'
	),
	'regards' => array(
		'vi' => 'Trân trọng,',
		'en' => 'Best regards,',
		'ru' => 'С уважением,',
		'es' => 'Atentamente,',
		'zh' => '最好的问候，',
		'ja' => '宜しくお願いします、'
	),
	'not_changed' => array(
		'vi' => 'Không thay đổi',
		'en' => 'Not changed',
		'ru' => 'Не изменилось',
		'es' => 'Sin cambio',
		'zh' => '没有改变',
		'ja' => '変更されていません'
	),
	'not_mark_as_spam' => array(
		'vi' => 'Đây không phải là thư rác. Vui lòng không đánh dấu thư rác.',
		'en' => 'This is not a spam. Please do not mark it as spam.',
		'ru' => 'Это не спам. Пожалуйста, не отметить его как спам.',
		'es' => 'Esto no es un spam. Por favor, no marcarlo como spam.',
		'zh' => '这不是一个垃圾邮件。请不要将其标记为垃圾邮件。',
		'ja' => 'これはスパムではありません。スパムとしてそれをマークしないでください。'
	),
	'definition' => array(
		'vi' => 'Nhịp sinh học (tiếng Anh: biorhythm) là một chu trình giả thiết về tình trạng khỏe mạnh hay năng lực sinh lý, cảm xúc, hoặc trí thông minh. Một nghiên cứu ở Nhật Bản trên công ty giao thông Ohmi Railway cũng đã lập các biểu đồ sinh học cho các tài xế lái xe của công ty để họ có sự cảnh giác và phòng tránh. Kết quả tai nạn của các tài xế đã giảm 50% từ năm 1969 đến 1970 tại Tokyo.',
		'en' => 'A biorhythm (from Greek βίος - bios, "life" and ῥυθμός - rhuthmos, "any regular recurring motion, rhythm") is an attempt to predict various aspects of a person\'s life through simple mathematical cycles. Most scientists believe that the idea has no more predictive power than chance and consider the concept an example of pseudoscience.',
		'ru' => 'Биоритм - (биоритмы) периодически повторяющиеся изменения характера и интенсивности биологических процессов и явлений. Они свойственны живой материи на всех уровнях ее организации — от молекулярных и субклеточных до биосферы. Являются фундаментальным процессом в живой природе. Одни биологические ритмы относительно самостоятельны (например, частота сокращений сердца, дыхания), другие связаны с приспособлением организмов к геофизическим циклам — суточным (например, колебания интенсивности деления клеток, обмена веществ, двигательной активности животных), приливным (например, открывание и закрывание раковин у морских моллюсков, связанные с уровнем морских приливов), годичным (изменение численности и активности животных, роста и развития растений и др.)',
		'es' => 'Los biorritmos constituyen un intento de predecir aspectos diversos de la vida de un individuo recurriendo a ciclos matemáticos sencillos. La mayoría de los investigadores estima que esta idea no tendría más poder predictivo que el que podría atribuirse al propio azar, considerándola un caso claro de pseudociencia.',
		'zh' => '生理节律是一種描述人類的身體、情感及智力的假想周期的理論。該概念与生物节律无关。在生物学和医学领域，这个词都是会被小心避免的，因為它被一些人認為是一种伪科学或是前科学。',
		'ja' => 'バイオリズム（英: biorhythm）とは、「生命」を意味する bio-（バイオ）と「規則的な運動」を意味する rhythm（リズム）の合成語で、生命体の生理状態、感情、知性などは周期的パターンに沿って変化するという仮説、およびそれを図示したグラフである。'
	),
	'instruction_video_text' => array(
		'vi' => 'Video hướng dẫn',
		'en' => 'Instruction video',
		'ru' => 'Видео инструкции',
		'es' => 'Instrucción de vídeo',
		'zh' => '教学视频',
		'ja' => '教育ビデオ'
	),
	'instruction_video_youtube_id' => array(
		'vi' => '0od3PsgixvQ',
		'en' => '7dRGGRcvI0E',
		'ru' => 'rp8_cTRP4ro',
		'es' => 'sifJsC3v-Lw',
		'zh' => 'TG2ngtokaVc',
		'ja' => 'SJw7lMuKipc'
	),
	'keyboard_shortcuts' => array(
		'vi' => 'Phím tắt: S, K -> Hôm nay; A, J -> Trước, D, L -> Sau; W, I -> Sinh nhật; E, O -> Nhịp sinh học phụ; R, P -> Thành ngữ',
		'en' => 'Keyboard shortcuts: S, K -> Today; A, J -> Back; D, L -> Forward; W, I -> Birthday; E, O -> Secondary rhythm; R, P -> Proverb',
		'ru' => 'Горячие клавиши: S, K -> Сегодня; A, J -> Назад; D, L -> Вперед; W, I -> День рождения; E, O -> Вторичный ритм; R, P -> Пословица',
		'es' => 'Atajos de teclado: S, K -> Hoy; A, J -> Atrás; D, L -> Enviar; W, I -> Cumpleaños; E, O -> Ritmo secundaria; R, P -> Proverbio',
		'zh' => '快捷键： S，K -> 今天; A，J -> 回去; D，L -> 前进; W，I -> 生辰; E，O -> 次要节奏; R，P -> 谚语',
		'ja' => 'キーボードショートカット： S、K -> 今日; A、J -> 戻る; D、L -> 前進する; W、I -> バースデー; E、O -> セカンダリリズム; R、P -> ことわざ'
	),
	'unsubscribe' => array(
		'vi' => 'Hủy đăng ký',
		'en' => 'Unsubscribe',
		'ru' => 'Отказаться',
		'es' => 'Darse de baja',
		'zh' => '退订',
		'ja' => '退会'
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
$error_interfaces = array(
	'not_filled' => array(
		'vi' => 'Chưa điền hết các mục',
		'en' => 'All the fields must be filled in',
		'ru' => 'Все поля должны быть заполнены',
		'es' => 'Todos los campos deben ser llenados',
		'zh' => '所有字段必须填写',
		'ja' => 'すべてのフィールドは記入する必要があります'
	),
	'invalid_member' => array(
		'vi' => 'Thư điện tử hoặc mật khẩu không chính xác',
		'en' => 'Incorrect email or password',
		'ru' => 'Неверный адрес электронной почты или пароль',
		'es' => 'Correo o contraseña incorrectos',
		'zh' => '不正确的电子邮件或密码',
		'ja' => '不適切な電子メールやパスワード'
	),
	'invalid_email' => array(
		'vi' => 'Thư điện tử không hợp lệ',
		'en' => 'Invalid email',
		'ru' => 'Неверный адрес электронной почты',
		'es' => 'Email inválido',
		'zh' => '不合规电邮',
		'ja' => '無効なメール'
	),
	'short_pass' => array(
		'vi' => 'Mật khẩu quá ngắn (≥ 8)',
		'en' => 'Password too short (≥ 8)',
		'ru' => 'Пароль слишком короткий (≥ 8)',
		'es' => 'Contraseña demasiado corta (≥ 8)',
		'zh' => '密码太短 (≥= 8)',
		'ja' => 'パスワードが短すぎます (≥ 8)'
	), 
	'long_pass' => array(
		'vi' => 'Mật khẩu quá dài (≤ 20)',
		'en' => 'Password too long (≤ 20)',
		'ru' => 'Пароль слишком долго (≤ 20)',
		'es' => 'Contraseña demasiado largo (≤ 20)',
		'zh' => '密码太长 (≤ 20)',
		'ja' => 'あまりにも長いパスワード (≤ 20)'
	),
	'no_number_pass' => array(
		'vi' => 'Mật khẩu phải chứa ít nhất 1 chữ số',
		'en' => 'Password must include at least one number',
		'ru' => 'Пароль должен содержать по крайней мере один номер',
		'es' => 'La contraseña debe incluir al menos un número',
		'zh' => '密码必须包括至少一个数',
		'ja' => 'パスワードは、少なくとも1つの番号を含める必要があります'
	),
	'no_letter_pass' => array(
		'vi' => 'Mật khẩu phải chứa ít nhất 1 chữ cái',
		'en' => 'Password must include at least one letter',
		'ru' => 'Пароль должен содержать по меньшей мере одну букву',
		'es' => 'La contraseña debe incluir al menos una letra',
		'zh' => '密码必须包含至少一个字母',
		'ja' => 'パスワードは、少なくとも1つの文字を含める必要があります'
	),
	'no_caps_pass' => array(
		'vi' => 'Mật khẩu phải chứa ít nhất 1 chữ cái VIẾT HOA',
		'en' => 'Password must include at least one CAPS',
		'ru' => 'Пароль должен содержать по крайней мере один ЗАГЛАВНАЯ БУКВА',
		'es' => 'La contraseña debe incluir al menos un MAYÚSCULA',
		'zh' => '密码必须包括至少一个大写字母',
		'ja' => 'パスワードは、少なくとも1つの大文字を含める必要があります'
	),
	'no_symbol_pass' => array(
		'vi' => 'Mật khẩu phải chứa ít nhất 1 ký tự đặc biệt',
		'en' => 'Password must include at least one symbol',
		'ru' => 'Пароль должен содержать по меньшей мере одну символ',
		'es' => 'La contraseña debe incluir al menos una símbolo',
		'zh' => '密码必须包含至少一个符号',
		'ja' => 'パスワードは、少なくとも1つのシンボルを含める必要があります'
	),
	'not_match_pass' => array(
		'vi' => 'Mật khẩu không khớp',
		'en' => 'Password not match',
		'ru' => 'Пароль не совпадает',
		'es' => 'La contraseña no coincide',
		'zh' => '密码不匹配',
		'ja' => 'パスワードが一致しません'
	),
	'invalid_dob' => array(
		'vi' => 'Ngày sinh không hợp lệ',
		'en' => 'Invalid date of birth',
		'ru' => 'Неправильная дата рождения',
		'es' => 'Fecha no válida de nacimiento',
		'zh' => '出生日期无效',
		'ja' => '誕生の無効な日付'
	),
	'taken_email' => array(
		'vi' => 'Thư điện tử đã được người khác dùng',
		'en' => 'Email taken',
		'ru' => 'Электронная почта приняты',
		'es' => 'Email tomada',
		'zh' => '采取电子邮件',
		'ja' => 'メール撮影'
	)
);
$help_interfaces = array(
	'help_h5' => array(
		'vi' => 'Hướng dẫn',
		'en' => 'Instruction',
		'ru' => 'Инструкция',
		'es' => 'Instrucción',
		'zh' => '指令',
		'ja' => '命令'
	),
	'help_p' => array(
		'vi' => 'Nhập thông tin ngày tháng năm sinh Dương lịch của bạn vào ô Ngày sinh. Sau đó, nhấn nút Chạy để hiển thị dự đoán Sức khỏe, Tình cảm, Trí tuệ. Nếu bạn chỉ quan tâm đến Nhịp sinh học ngủ, bạn không cần điền Họ tên và Ngày sinh.',
		'en' => 'Type in your date of birth into the Date of birth field. Then click Run to know your physical, emotional, intellectual values. If you only care about Sleep Rhythm, you don\'t need to type in your Full name or Date of birth.',
		'ru' => 'Введите дату своего рождения в поле День Рождения. Затем нажмите кнопку Идти, чтобы узнать ваши физические, эмоциональные, интеллектуальные ценности. Если вы только заботиться о Sleep ритм, вам не нужно вводить полное имя или дату рождения.',
		'es' => 'Escriba su fecha de nacimiento en el campo Fecha de nacimiento. Luego haga clic en Correr para conocer sus valores, físicas, intelectuales y emocionales. Si sólo se preocupa por el sueño Ritmo, usted no tiene que escribir su nombre o fecha de nacimiento completa.',
		'zh' => '输入你的出生日期为出生场的日期。然后点击运行就知道你的身体，情绪，智力值。如果你只在乎睡眠节律，你不需要输入您的姓名和出生日期。',
		'ja' => '誕生フィールドの日にあなたの生年月日を入力します。 次に、あなたの物理的、感情的、知的な値を知るために実行]をクリックします。あなたが唯一の睡眠リズムに関心があるのであれば、あなたは自分のフルネームや生年月日を入力する必要はありません。'
	),
	'news_box' => array(
		'vi' => 'Hiển thị các tin tức liên quan đến bạn.',
		'en' => 'Show the news related to you.',
		'ru' => 'Показать новости, связанные с вами.',
		'es' => 'Mostrar las noticias relacionadas con usted.',
		'zh' => '显示的消息与你。',
		'ja' => 'あなたに関連するニュースを表示します。'
	),
	'stats_box' => array(
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
	'info_box' => array(
		'vi' => 'Hiển thị lời khuyên cho ngày hiện tại.',
		'en' => 'Display the suggestion for current date.',
		'ru' => 'Показать предложение для текущей даты.',
		'es' => 'Visualice la sugerencia para la fecha actual.',
		'zh' => '显示的建议为当前日期。',
		'ja' => '現在の日付のための提案を表示します。'
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
			'gray' => 'Ngày hiện tại của bạn hơi xấu, bạn nên cẩn trọng hơn.',
			'bad' => 'Ngày hiện tại của bạn khá xấu, bạn nên cực kỳ cẩn thận.'
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
			'excellent' => 'Sức khỏe hiện tại của bạn rất sung mãn, hãy tham gia vận động nhiều hơn, như vận động thể dục, thể thao, tham gia các cuộc vui, để tận dụng năng lượng nhé.',
			'good' => 'Sức khỏe hiện tại của bạn khá sung mãn, hãy vận động điều độ, như các hoạt động bơi lội, đi bộ, yoga hoặc các môn thể dục nhẹ nhàng khác nha bạn.',
			'critical' => 'Sức khỏe hiện tại của bạn đang rơi vào giai đoạn chuyển tiếp, bạn nên nghỉ ngơi nhiều lên nhé, do thể lực bạn đang biến đổi khó lường.',
			'gray' => 'Sức khỏe hiện tại của bạn hơi kém, hãy nghỉ ngơi một tí, do thể lực đã ở vào mức khá thấp, hãy tích trữ năng lượng để dành vào những lúc sung mãn nha.',
			'bad' => 'Sức khỏe hiện tại của bạn khá kém, hãy nghỉ ngơi nhiều hơn, bạn đã hoạt động nhiều rồi, thời gian này nên dành để ngủ đông nhé.'
		),
		'en' => array(
			'excellent' => 'Your current health is excellent, you should work out more.',
			'good' => 'Your current health is quite good, you should work out with care.',
			'critical' => 'Your current health is in critical period, you should be extremely careful.',
			'gray' => 'Your current health is not good, take a little rest.',
			'bad' => 'Your current health is bad, take more rest.'
		),
		'ru' => array(
			'excellent' => 'Ваше текущее здоровье отличное, вы должны работать больше.',
			'good' => 'Ваше текущее здоровье неплохое, вы должны работать с осторожностью.',
			'critical' => 'Ваше текущее здоровье в критический период, вы должны быть очень осторожны.',
			'gray' => 'Ваше текущее здоровье не хорошо, немного отдохнуть.',
			'bad' => 'Ваше текущее здоровье плохо, взять больше отдыхать.'
		),
		'es' => array(
			'excellent' => 'Su estado de salud actual es excelente, debe trabajar más.',
			'good' => 'Su estado de salud actual es bastante bueno, usted debe hacer ejercicio con cuidado.',
			'critical' => 'Su salud actual está en el período crítico , debe ser extremadamente cuidadoso.',
			'gray' => 'Su estado de salud actual no es buena, tomar un poco de descanso.',
			'bad' => 'Su estado de salud actual es mala, tener más descanso.'
		),
		'zh' => array(
			'excellent' => '您当前的健康是优秀的，你应该更多。',
			'good' => '您当前的健康是相当不错的，你应该制定出谨慎。',
			'critical' => '您当前的健康是关键时期，你应该非常小心。',
			'gray' => '你目前的身体不好，需要一点休息。',
			'bad' => '您当前的健康是不好的，需要更多的休息。'
		),
		'ja' => array(
			'excellent' => 'あなたの現在の健康状態が優れている、あなたはより多くを動作するはずです。',
			'good' => 'あなたの現在の健康状態はかなり良いですが、あなたが注意して動作するはずです。',
			'critical' => 'あなたの現在の健康状態は、臨界期に、あなたは非常に慎重であるべきです。',
			'gray' => 'あなたの現在の健康状態が良くない、少し休憩を取る。',
			'bad' => 'あなたの現在の健康状態が悪いと、より多くの休息を取る。'
		)
	),
	'emotional' => array(
		'vi' => array(
			'excellent' => 'Tâm trạng hiện tại của bạn rất ổn, hãy tham gia gặp gỡ bạn bè nhiều hơn, dành thời gian hẹn hò, đi chơi với những người thân yêu của mình để tận dụng lúc cảm xúc đang thăng hoa bạn nhé.',
			'good' => 'Tâm trạng hiện tại của bạn khá ổn, hãy gặp gỡ bạn bè, người thân, nhưng cũng chú ý tránh những xung đột nhỏ để cho cuộc vui được trọn vẹn nha bạn.',
			'critical' => 'Tâm trạng hiện tại của bạn đang rơi vào giai đoạn chuyển giao, hãy chú ý nhiều đến cảm xúc của mình, do đây là lúc cảm xúc thay đổi khó lường.',
			'gray' => 'Tâm trạng hiện tại của bạn hơi tệ, bạn hơi dễ cáu kỉnh, dễ cãi nhau, vì thế, bạn nên tìm đến những góc nhỏ cho riêng mình, để tĩnh tâm lại bạn nhé.',
			'bad' => 'Tâm trạng hiện tại của bạn khá tệ, bạn nên tránh các cuộc xung đột, cãi vã, vì lúc này điều đó rất dễ xảy ra. Bạn nên dành thời gian ở một mình, khoảng thời gian này sẽ qua mau thôi.'
		),
		'en' => array(
			'excellent' => 'Your current mood is excellent, you meet more friends.',
			'good' => 'Your current mood is quite good, you should meet some friends.',
			'critical' => 'Your current mood is in critical period, you should pay more attention to your feelings.',
			'gray' => 'Your current mood is not good, you are easily annoyed.',
			'bad' => 'Your current mood is bad, avoid conflicts.'
		),
		'ru' => array(
			'excellent' => 'Ваше текущее настроение отличное, вы встретите больше друзей.',
			'good' => 'Ваше текущее настроение неплохое, вы должны встретиться с друзьями.',
			'critical' => 'Ваше текущее настроение в критический период, вы должны уделять больше внимания на ваши чувства.',
			'gray' => 'Ваше текущее настроение не очень хорошо, вы легко раздражаться.',
			'bad' => 'Ваше текущее настроение плохое, во избежание конфликтов.'
		),
		'es' => array(
			'excellent' => 'Su estado de ánimo actual es excelente, te encuentras con más amigos.',
			'good' => 'Su estado de ánimo actual es bastante buena, usted debe cumplir con algunos amigos.',
			'critical' => 'Su estado de ánimo actual está en el período crítico, se debe prestar más atención a sus sentimientos.',
			'gray' => 'Su estado de ánimo actual no es bueno, ustedes son fácilmente molesto.',
			'bad' => 'Su estado de ánimo actual es mala, evitar conflictos.'
		),
		'zh' => array(
			'excellent' => '你现在的心情非常好，你认识更多的朋友。',
			'good' => '你现在的心情是相当不错的，你应该满足一些朋友。',
			'critical' => '您现在的心情是关键时期，你应该更加注意你的感受。',
			'gray' => '你现在的心情不是很好，你很容易生气。',
			'bad' => '你现在的心情不好，避免冲突。'
		),
		'ja' => array(
			'excellent' => 'あなたの現在の気分が優れている、あなたはより多くの友人に会う。',
			'good' => 'あなたの現在の気分はかなり良いですが、あなたは何人かの友人を満たしている必要があります。',
			'critical' => 'あなたの現在の気分は、臨界期に、あなたはあなたの気持ちにもっと注意を払う必要があります。',
			'gray' => 'あなたの現在の気分が良くない、あなたは簡単にイライラです。',
			'bad' => 'あなたの現在の気分が悪い、競合を避ける。'
		)
	),
	'intellectual' => array(
		'vi' => array(
			'excellent' => 'Trí tuệ hiện tại của bạn rất sáng suốt, bạn có thể đưa ra những quyết định đúng đắn, có những suy nghĩ rất chính xác, hợp lý.',
			'good' => 'Trí tuệ hiện tại của bạn khá sáng suốt, bạn có thể đưa ra quyết định nhưng cần suy tính kỹ, bởi vì suy nghĩ của bạn chưa đạt độ chính xác cao nhất có thể.',
			'critical' => 'Trí tuệ hiện tại của bạn đang ở trong giai đoạn chuyển biến, bạn nên chú ý kỹ hơn đến suy nghĩ của mình, vì nó có thể dẫn đến những quyết định sai lầm.',
			'gray' => 'Trí tuệ hiện tại của bạn hơi thiếu sáng suốt, bạn nên suy nghĩ kỹ trước khi ra quyết định. Nếu cần thiết, hãy hỏi thêm ý kiến của người thân, bạn bè, đồng nghiệp.',
			'bad' => 'Trí tuệ hiện tại của bạn khá thiếu sáng suốt, bạn không nên đưa ra quyết định lớn. Nếu phải ra quyết định, bạn nhất định nên hỏi ý kiến người khác.'
		),
		'en' => array(
			'excellent' => 'Your current intellect is excellent, you can make great decisions.',
			'good' => 'Your current intellect is quite good, you can make decisions with a little care.',
			'critical' => 'Your current intellect is in critical period, you should pay extra attention to your thoughts, as it may lead to wrong decisions.',
			'gray' => 'Your current intellect is not good, you should think twice before making decisions.',
			'bad' => 'Your current intellect is bad, you should not make big decisions.'
		),
		'ru' => array(
			'excellent' => 'Ваше текущее интеллект отлично, вы можете сделать большие решения.',
			'good' => 'Ваше текущее интеллект является достаточно хорошим, вы можете принимать решения с особого ухода.',
			'critical' => 'Ваше текущее интеллект в критический период, следует обратить особое внимание на ваши мысли, так как это может привести к неправильным решениям.',
			'gray' => 'Ваше текущее интеллект не является хорошим, вы должны подумать дважды, прежде чем принимать решения.',
			'bad' => 'Ваше текущее интеллект плохо, вы не должны делать большие решения.'
		),
		'es' => array(
			'excellent' => 'Su intelecto actual es excelente, puedes tomar grandes decisiones.',
			'good' => 'Su intelecto actual es bastante buena, se puede tomar decisiones con un poco de cuidado.',
			'critical' => 'Su intelecto actual está en período crítico, se debe prestar especial atención a sus pensamientos, ya que puede conducir a decisiones equivocadas.',
			'gray' => 'Su intelecto actual no es buena, usted debe pensar dos veces antes de tomar decisiones.',
			'bad' => 'Su intelecto actual es mala, no debe tomar decisiones importantes.'
		),
		'zh' => array(
			'excellent' => '您当前的智力是优秀的，你可以做出伟大的决定。',
			'good' => '您当前的智力是相当不错的，你可以用一点点小心做出决定。',
			'critical' => '您当前的智力是关键时期，你要格外注意你的想法，因为这可能会导致错误的决策。',
			'gray' => '您当前的智力不好，你做决策前，应三思而后行。',
			'bad' => '您当前的智力是坏的，你不应该做出重大的决定。'
		),
		'ja' => array(
			'excellent' => 'あなたの現在の知性は、あなたは偉大な決定を行うことができ、優れたものである。',
			'good' => 'あなたの現在の知性はかなり良いですが、あなたは少し注意して意思決定を行うことができます。',
			'critical' => 'それは間違った意思決定につながる可能性としてあなたの現在の知性は、臨界期に、あなたは、あなたの考えに特別な注意を払う必要がありますされています。',
			'gray' => 'あなたの現在の知性はあなたが意思決定をする前に二度考える必要があり、良いではありません。',
			'bad' => 'あなたの現在の知性は、あなたは大きな意思決定を行うべきではない、悪いです。'
		)
	)
);
// DKIM is used to sign e-mails. If you change your RSA key, apply modifications to the DNS DKIM record of the mailing (sub)domain too !
// Disclaimer : the php openssl extension can be buggy with Windows, try with Linux first

// To generate a new private key with Linux :
// openssl genrsa -des3 -out private.pem 1024
// Then get the public key
// openssl rsa -in private.pem -out public.pem -outform PEM -pubout

// Edit with your own info :

define('MAIL_RSA_PASSPHRASE', 'nhipsinhhoc');

define('MAIL_RSA_PRIV',
'-----BEGIN RSA PRIVATE KEY-----

-----END RSA PRIVATE KEY-----');

define('MAIL_RSA_PUBL',
'-----BEGIN PUBLIC KEY-----

-----END PUBLIC KEY-----');

// Domain or subdomain of the signing entity (i.e. the domain where the e-mail comes from)
define('MAIL_DOMAIN', 'mail.nhipsinhhoc.vn');  

// Allowed user, defaults is "@<MAIL_DKIM_DOMAIN>", meaning anybody in the MAIL_DKIM_DOMAIN domain. Ex: 'admin@mydomain.tld'. You'll never have to use this unless you do not control the "From" value in the e-mails you send.
define('MAIL_IDENTITY', NULL);

// Selector used in your DKIM DNS record, e.g. : selector._domainkey.MAIL_DKIM_DOMAIN
define('MAIL_SELECTOR', 'x');