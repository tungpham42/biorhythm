<?php
class Chart {
	protected $_dob, $_diff, $_date, $_is_secondary, $_dt_change, $_lang, $_rhythms_count,  $_dates_count, $_today_index, $_title_text, $_explanation_title_text, $_percentage_text, $_average_text, $_download_jpeg_text, $_download_pdf_text, $_download_png_text, $_download_svg_text, $_print_chart_text, $_date_text, $_age, $_statistics_h5, $_lunar_h5, $_controls_h5, $_dates_json, $_rhythms_json;
	protected $_rhythms = array();
	protected $_days = array();
	protected $_dates = array();
	
	function __construct($dob,$diff,$is_secondary,$dt_change,$lang_code) {
		global $lang_codes;
		$this->_dob = $dob;
		$this->_diff = $diff;
		$this->_date = date('Y-m-d', time()+86400*$this->_diff);
		$this->_lang_code = in_array($lang_code, $lang_codes) ? $lang_code: 'vi';
		$this->_is_secondary = $is_secondary;
		$this->_dt_change = isset($dt_change) ? $dt_change: $this->_date;
		if ($this->_is_secondary == 0) {
			$this->_rhythms = array_filter(load_all_array('nsh_rhythms'), array(new filter($this->_is_secondary), 'filter_secondary'));
		} else if ($this->_is_secondary == 1) {
			$this->_rhythms = load_all_array('nsh_rhythms');
		}
		sort($this->_rhythms);
		for ($i = -14; $i <= 14; ++$i) {
			$j = $i + 14;
			$day = time()+86400*($i+$diff);
			$this->_days[$j] = date('d',$day);
			$this->_dates[$j] = date('Y-m-d',$day);
		}
		$this->_rhythms_count = count($this->_rhythms);
		$this->_dates_count = count($this->_dates);
		$this->_today_index = array_search(date('Y-m-d'),$this->_dates);
		$this->_dates_json = json_encode($this->_dates);
		$this->_rhythms_json = json_encode($this->_rhythms);
		switch ($this->_lang_code) {
			case 'vi':
				$this->_title_text = 'Ngày sinh: ';
				$this->_explanation_title_text = 'Biểu đồ nhịp sinh học';
				$this->_percentage_text = 'Phần trăm';
				$this->_average_text = 'Trung bình';
				$this->_download_jpeg_text = 'Tải về tập tin JPEG';
				$this->_download_pdf_text = 'Tải về tập tin PDF';
				$this->_download_png_text = 'Tải về tập tin PNG';
				$this->_download_svg_text = 'Tải về tập tin SVG';
				$this->_print_chart_text = 'In biểu đồ';
				$this->_date_text = 'Ngày';
				$this->_age = 'tuổi';
				$this->_statistics_h5 = 'Thống kê';
				$this->_lunar_h5 = 'Âm lịch';
				if (date('m-d',time()+86400*$this->_diff) == date('m-d',strtotime($this->_dob))) {
					$this->_controls_h5 = 'Sinh nhật';
				} else if ($this->_diff == 0) {
					$this->_controls_h5 = 'Hôm nay';
				} else if ($this->_diff == 1) {
					$this->_controls_h5 = 'Ngày mai';
				} else if ($this->_diff == -1) {
					$this->_controls_h5 = 'Hôm qua';
				} else {
					$this->_controls_h5 = 'Ngày: '.$this->_date;
				}
				break;
			case 'en':
				$this->_title_text = 'Date of birth: ';
				$this->_explanation_title_text = 'Biorhythm chart';
				$this->_percentage_text = 'Percentage';
				$this->_average_text = 'Average';
				$this->_download_jpeg_text = 'Download JPEG file';
				$this->_download_pdf_text = 'Download PDF file';
				$this->_download_png_text = 'Download PNG file';
				$this->_download_svg_text = 'Download SVG file';
				$this->_print_chart_text = 'Print chart';
				$this->_date_text = 'Date';
				$this->_age = pluralize(date('Y', time()+86400*$this->_diff) - date('Y', strtotime($this->_dob)),'year').' old';
				$this->_statistics_h5 = 'Statistics';
				$this->_lunar_h5 = 'Lunar calendar';
				if (date('m-d',time()+86400*$this->_diff) == date('m-d',strtotime($this->_dob))) {
					$this->_controls_h5 = 'Birthday';
				} else if ($this->_diff == 0) {
					$this->_controls_h5 = 'Today';
				} else if ($this->_diff == 1) {
					$this->_controls_h5 = 'Tomorrow';
				} else if ($this->_diff == -1) {
					$this->_controls_h5 = 'Yesterday';
				} else {
					$this->_controls_h5 = 'Date: '.$this->_date;
				}
				break;
			case 'ru':
				$this->_title_text = 'Дата рождения: ';
				$this->_explanation_title_text = 'Биоритм диаграммы';
				$this->_percentage_text = 'Процент';
				$this->_average_text = 'Среднее число';
				$this->_download_jpeg_text = 'Скачать JPEG файл';
				$this->_download_pdf_text = 'Скачать PDF файл';
				$this->_download_png_text = 'Скачать PNG файл';
				$this->_download_svg_text = 'Скачать SVG файл';
				$this->_print_chart_text = 'Печать диаграммы';
				$this->_date_text = 'Дата';
				$this->_age = 'лет';
				$this->_statistics_h5 = 'Статистика';
				$this->_lunar_h5 = 'Лунный календарь';
				if (date('m-d',time()+86400*$this->_diff) == date('m-d',strtotime($this->_dob))) {
					$this->_controls_h5 = 'День рождения';
				} else if ($this->_diff == 0) {
					$this->_controls_h5 = 'Сегодня';
				} else if ($this->_diff == 1) {
					$this->_controls_h5 = 'Завтра';
				} else if ($this->_diff == -1) {
					$this->_controls_h5 = 'Вчерашний день';
				} else {
					$this->_controls_h5 = 'Дата: '.$this->_date;
				}
				break;
			case 'es':
				$this->_title_text = 'Fecha de nacimiento: ';
				$this->_explanation_title_text = 'Biorritmo carta';
				$this->_percentage_text = 'Porcentaje';
				$this->_average_text = 'Promedio';
				$this->_download_jpeg_text = 'Descarga de archivos JPEG';
				$this->_download_pdf_text = 'Descarga de archivos PDF';
				$this->_download_png_text = 'Descarga de archivos PNG';
				$this->_download_svg_text = 'Descarga de archivos SVG';
				$this->_print_chart_text = 'Imprimir el gráfico';
				$this->_date_text = 'Fecha';
				$this->_age = 'años';
				$this->_statistics_h5 = 'Estadística';
				$this->_lunar_h5 = 'Calendario lunar';
				if (date('m-d',time()+86400*$this->_diff) == date('m-d',strtotime($this->_dob))) {
					$this->_controls_h5 = 'Cumpleaños';
				} else if ($this->_diff == 0) {
					$this->_controls_h5 = 'Hoy';
				} else if ($this->_diff == 1) {
					$this->_controls_h5 = 'Mañana';
				} else if ($this->_diff == -1) {
					$this->_controls_h5 = 'Ayer';
				} else {
					$this->_controls_h5 = 'Fecha: '.$this->_date;
				}
				break;
			case 'zh':
				$this->_title_text = '出生日期: ';
				$this->_explanation_title_text = '生物节律图';
				$this->_percentage_text = '百分比';
				$this->_average_text = '平均';
				$this->_download_jpeg_text = '下载 JPEG 文件';
				$this->_download_pdf_text = '下载 PDF 文件';
				$this->_download_png_text = '下载 PNG 文件';
				$this->_download_svg_text = '下载 SVG 文件';
				$this->_print_chart_text = '打印图表';
				$this->_date_text = '上';
				$this->_age = '岁老';
				$this->_statistics_h5 = '统计学';
				$this->_lunar_h5 = '阴历';
				if (date('m-d',time()+86400*$this->_diff) == date('m-d',strtotime($this->_dob))) {
					$this->_controls_h5 = '生辰';
				} else if ($this->_diff == 0) {
					$this->_controls_h5 = '今天';
				} else if ($this->_diff == 1) {
					$this->_controls_h5 = '明天';
				} else if ($this->_diff == -1) {
					$this->_controls_h5 = '昨天';
				} else {
					$this->_controls_h5 = '上: '.$this->_date;
				}
				break;
			case 'ja':
				$this->_title_text = '生まれた日: ';
				$this->_explanation_title_text = 'バイオリズムチャート';
				$this->_percentage_text = '百分率';
				$this->_average_text = '平均する';
				$this->_download_jpeg_text = 'ダウンロード JPEG ファイル';
				$this->_download_pdf_text = 'ダウンロード PDF ファイル';
				$this->_download_png_text = 'ダウンロード PNG ファイル';
				$this->_download_svg_text = 'ダウンロード SVG ファイル';
				$this->_print_chart_text = 'チャート印刷';
				$this->_date_text = '日付';
				$this->_age = '歳';
				$this->_statistics_h5 = '統計学';
				$this->_lunar_h5 = '太陰暦';
				if (date('m-d',time()+86400*$this->_diff) == date('m-d',strtotime($this->_dob))) {
					$this->_controls_h5 = 'バースデー';
				} else if ($this->_diff == 0) {
					$this->_controls_h5 = '今日';
				} else if ($this->_diff == 1) {
					$this->_controls_h5 = 'あくる日';
				} else if ($this->_diff == -1) {
					$this->_controls_h5 = '昨日';
				} else {
					$this->_controls_h5 = '日付: '.$this->_date;
				}
				break;
		}
	}
	function get_rhythm_name($rhythm) {
		switch ($this->_lang_code) {
			case 'vi':
				return $rhythm['name'];
				break;
			case 'en':
				return $rhythm['description_en'];
				break;
			case 'ru':
				return $rhythm['description_ru'];
				break;
			case 'es':
				return $rhythm['description_es'];
				break;
			case 'zh':
				return $rhythm['description_zh'];
				break;
			case 'ja':
				return $rhythm['description_ja'];
				break;
		}
	}
	function serialize_chart_data() {
		$chart_data = '[{name:"'.$this->_average_text.'",data:[';
		for ($d = 0; $d < $this->_dates_count; ++$d) {
			$chart_data .= average_count($this->_dob,$this->_dates[$d],$this->_rhythms);
			$chart_data .= ($d != ($this->_dates_count-1)) ? ',': '';
		}
		$chart_data .= '],lineWidth: 2},';
		for ($r = 0; $r < $this->_rhythms_count; ++$r) {
			$this->_rhythms[$r]['rhythm_name'] = $this->get_rhythm_name($this->_rhythms[$r]);
			$chart_data .= '{name:"'.$this->_rhythms[$r]['rhythm_name'].'",data:[';
			for ($d = 0; $d < $this->_dates_count; ++$d) {
				$chart_data .= bio_count($this->_dob,$this->_dates[$d],$this->_rhythms[$r]['scale']);
				$chart_data .= ($d != ($this->_dates_count-1)) ? ',': '';
			}
			$chart_data .= ']';
			$chart_data .= ($r != ($this->_rhythms_count-1)) ? '},': '}';
		}
		$chart_data .= ']';
		return $chart_data;
	}
	function render_meta_description() {
		$meta_description = (date('Y') - date('Y', strtotime($this->_dob))).' '.$this->_age;
		$meta_description .= ' - '.date('Y-m-d',time()+86400*$this->_diff).' -';
		foreach ($this->_rhythms as $rhythm) {
			$meta_description .= ' '.$this->get_rhythm_name($rhythm).' '.percent_bio_count($this->_dob,date('Y-m-d',time()+86400*$this->_diff),$rhythm['scale']);
		}
		return $meta_description;
	}
	// Render info
	function render_info() {
		global $help_interfaces;
		echo '
<section id="info" class="context-menu-'.$this->_diff.'-'.$this->_is_secondary.'-'.$this->_lang_code.'">
	<h5>'.$this->_statistics_h5.'</h5>
	<p><strong><span class="translate" data-lang-ja="歳:" data-lang-zh="岁老:" data-lang-es="Años:" data-lang-ru="Лет:" data-lang-en="Years old:" data-lang-vi="Số năm tuổi:"></span></strong> '.(date('Y', time()+86400*$this->_diff) - date('Y', strtotime($this->_dob))).' <span class="translate" data-lang-ja="年々" data-lang-zh="岁" data-lang-es="año" data-lang-ru="лет" data-lang-en="'.pluralize(date('Y', time()+86400*$this->_diff) - date('Y', strtotime($this->_dob)),'year').'" data-lang-vi="năm"></span></p>
	<p><strong><span class="translate" data-lang-ja="日古:" data-lang-zh="日老:" data-lang-es="Días:" data-lang-ru="Дней:" data-lang-en="Days old:" data-lang-vi="Số ngày tuổi:"></span></strong> '.differ_date($this->_dob, $this->_date).' <span class="translate" data-lang-ja="日" data-lang-zh="日" data-lang-es="'.pluralize(differ_date($this->_dob, $this->_date),'día').'" data-lang-ru="дней" data-lang-en="'.pluralize(differ_date($this->_dob, $this->_date),'day').'" data-lang-vi="ngày"></span></p>
	<p><strong><span class="translate" data-lang-ja="誕生日カウントダウン:" data-lang-zh="生日倒计时:" data-lang-es="Cuenta atrás cumpleaños:" data-lang-ru="День рождения отсчет:" data-lang-en="Birthday countdown:" data-lang-vi="Đếm ngược sinh nhật:"></span></strong> '.countdown_birthday($this->_dob, $this->_date).' <span class="translate" data-lang-ja="日" data-lang-zh="日" data-lang-es="'.pluralize(countdown_birthday($this->_dob, $this->_date),'día').'" data-lang-ru="дней" data-lang-en="'.pluralize(countdown_birthday($this->_dob, $this->_date),'day').'" data-lang-vi="ngày"></span></p>
	<p><a id="life_path_link" target="_blank" href="'.$help_interfaces['life_path_number_prefix'][$this->_lang_code].calculate_life_path($this->_dob).$help_interfaces['life_path_number_suffix'][$this->_lang_code].'"><strong><span class="translate" data-lang-ja="ライフパス番号:" data-lang-zh="人生道路数量:" data-lang-es="Vida número de camino:" data-lang-ru="Число Жизненный путь:" data-lang-en="Life path number:" data-lang-vi="Con số cuộc đời:"></span></strong> '.calculate_life_path($this->_dob).'</a></p>
	<p><strong><span class="translate" data-lang-ja="黄道帯の印:" data-lang-zh="星宮名稱:" data-lang-es="Signo del Zodíaco:" data-lang-ru="Знак зодиака:" data-lang-en="Zodiac sign:" data-lang-vi="Cung hoàng đạo:"></span></strong> <span class="translate" data-lang-ja="'.get_zodiac_from_dob($this->_dob,'ja').'" data-lang-zh="'.get_zodiac_from_dob($this->_dob,'zh').'" data-lang-es="'.get_zodiac_from_dob($this->_dob,'es').'" data-lang-ru="'.get_zodiac_from_dob($this->_dob,'ru').'" data-lang-en="'.get_zodiac_from_dob($this->_dob,'en').'" data-lang-vi="'.get_zodiac_from_dob($this->_dob,'vi').'"></span></p>
	<textarea id="embed_box" rows="3" cols="420" onClick=select() ><embed src="http://nhipsinhhoc.vn/?embed=1&dob='.$this->_dob.'&lang='.$this->_lang_code.'" height="480" width="600"></textarea>
	<div id="embed_toggle"><i class="icon-eject icon-white"></i></div>
</section>
		';
	}
	// Render lunar calendar
	function render_lunar() {
		echo '
<section id="lunar" class="context-menu-'.$this->_diff.'-'.$this->_is_secondary.'-'.$this->_lang_code.'">
	<h5>'.$this->_lunar_h5.'</h5>
	<p><strong><span class="translate" data-lang-ja="歳:" data-lang-zh="岁老:" data-lang-es="Años:" data-lang-ru="Лет:" data-lang-en="Years old:" data-lang-vi="Số năm tuổi:"></span></strong> '.get_lunar_years_old($this->_dob,$this->_date).' <span class="translate" data-lang-ja="年々" data-lang-zh="岁" data-lang-es="año" data-lang-ru="лет" data-lang-en="'.pluralize(get_lunar_years_old($this->_dob,$this->_date),'year').'" data-lang-vi="năm"></span></p>
	<p><strong><span class="translate" data-lang-ja="年:" data-lang-zh="年:" data-lang-es="Año:" data-lang-ru="Год:" data-lang-en="Year:" data-lang-vi="Năm:"></span></strong> <span class="translate" data-lang-ja="'.get_lunar_year($this->_dob,'ja').'" data-lang-zh="'.get_lunar_year($this->_dob,'zh').'" data-lang-es="'.get_lunar_year($this->_dob,'es').'" data-lang-ru="'.get_lunar_year($this->_dob,'ru').'" data-lang-en="'.get_lunar_year($this->_dob,'en').'" data-lang-vi="'.get_lunar_year($this->_dob,'vi').'"></span></p>
	<p><strong><span class="translate" data-lang-ja="月:" data-lang-zh="月:" data-lang-es="Mes:" data-lang-ru="Месяц:" data-lang-en="Month:" data-lang-vi="Tháng:"></span></strong> <span class="translate" data-lang-ja="'.get_lunar_month($this->_dob,'ja').'" data-lang-zh="'.get_lunar_month($this->_dob,'zh').'" data-lang-es="'.get_lunar_month($this->_dob,'es').'" data-lang-ru="'.get_lunar_month($this->_dob,'ru').'" data-lang-en="'.get_lunar_month($this->_dob,'en').'" data-lang-vi="'.get_lunar_month($this->_dob,'vi').'"></span></p>
	<p><strong><span class="translate" data-lang-ja="日:" data-lang-zh="日:" data-lang-es="Día:" data-lang-ru="Сутки:" data-lang-en="Day:" data-lang-vi="Ngày:"></span></strong> <span class="translate" data-lang-ja="'.get_lunar_day($this->_dob,'ja').'" data-lang-zh="'.get_lunar_day($this->_dob,'zh').'" data-lang-es="'.get_lunar_day($this->_dob,'es').'" data-lang-ru="'.get_lunar_day($this->_dob,'ru').'" data-lang-en="'.get_lunar_day($this->_dob,'en').'" data-lang-vi="'.get_lunar_day($this->_dob,'vi').'"></span></p>
	<div id="lunar_box">
		<p id="lunar_desc"><strong><span class="translate" data-lang-ja="月面日付:" data-lang-zh="农历日期:" data-lang-es="Fecha lunar:" data-lang-ru="Лунный день:" data-lang-en="Lunar date:" data-lang-vi="Ngày Âm lịch:"></span></strong> <span>'.get_lunar_date($this->_date,true).'</span></p>
		<p class="lunar_desc"><strong><span class="translate" data-lang-ja="年:" data-lang-zh="年:" data-lang-es="Año:" data-lang-ru="Год:" data-lang-en="Year:" data-lang-vi="Năm:"></span></strong> <span class="translate" data-lang-ja="'.get_lunar_year($this->_date,'ja').'" data-lang-zh="'.get_lunar_year($this->_date,'zh').'" data-lang-es="'.get_lunar_year($this->_date,'es').'" data-lang-ru="'.get_lunar_year($this->_date,'ru').'" data-lang-en="'.get_lunar_year($this->_date,'en').'" data-lang-vi="'.get_lunar_year($this->_date,'vi').'"></span></p>
		<p class="lunar_desc"><strong><span class="translate" data-lang-ja="月:" data-lang-zh="月:" data-lang-es="Mes:" data-lang-ru="Месяц:" data-lang-en="Month:" data-lang-vi="Tháng:"></span></strong> <span class="translate" data-lang-ja="'.get_lunar_month($this->_date,'ja').'" data-lang-zh="'.get_lunar_month($this->_date,'zh').'" data-lang-es="'.get_lunar_month($this->_date,'es').'" data-lang-ru="'.get_lunar_month($this->_date,'ru').'" data-lang-en="'.get_lunar_month($this->_date,'en').'" data-lang-vi="'.get_lunar_month($this->_date,'vi').'"></span></p>
		<p class="lunar_desc"><strong><span class="translate" data-lang-ja="日:" data-lang-zh="日:" data-lang-es="Día:" data-lang-ru="Сутки:" data-lang-en="Day:" data-lang-vi="Ngày:"></span></strong> <span class="translate" data-lang-ja="'.get_lunar_day($this->_date,'ja').'" data-lang-zh="'.get_lunar_day($this->_date,'zh').'" data-lang-es="'.get_lunar_day($this->_date,'es').'" data-lang-ru="'.get_lunar_day($this->_date,'ru').'" data-lang-en="'.get_lunar_day($this->_date,'en').'" data-lang-vi="'.get_lunar_day($this->_date,'vi').'"></span></p>
	</div>
</section>
		';
	}
	// Render controls
	function render_controls() {
		global $button_interfaces;
		global $input_interfaces;
		global $span_interfaces;
		$h5 = '';
		echo '
<section id="controls" class="context-menu-'.$this->_diff.'-'.$this->_is_secondary.'-'.$this->_lang_code.'">
	<h5>'.$this->_controls_h5.'</h5>
	<ul>
		<li class="rhythm"><i class="icon-white icon-arrow-'.((average_count($this->_dob,date('Y-m-d',time()+86400*($this->_diff-1)),$this->_rhythms) < average_count($this->_dob,date('Y-m-d',time()+86400*$this->_diff),$this->_rhythms)) ? 'up': 'down').'"></i><span class="translate" data-lang-ja="平均する:" data-lang-zh="平均:" data-lang-es="Promedio:" data-lang-ru="Средний:" data-lang-en="Average:" data-lang-vi="Trung bình:"></span> '.average_count($this->_dob,date('Y-m-d',time()+86400*$this->_diff),$this->_rhythms).' %</li>';
		foreach ($this->_rhythms as $rhythm){
			echo '<li class="rhythm'.(($rhythm['is_secondary'] == 1) ? ' secondary': '').'"><i class="icon-white icon-arrow-'.((bio_count($this->_dob,date('Y-m-d',time()+86400*($this->_diff-1)),$rhythm['scale']) < bio_count($this->_dob,date('Y-m-d',time()+86400*$this->_diff),$rhythm['scale'])) ? 'up': 'down').'"></i><span class="translate" data-lang-ja="'.$rhythm['description_ja'].'" data-lang-zh="'.$rhythm['description_zh'].'" data-lang-es="'.$rhythm['description_es'].'" data-lang-ru="'.$rhythm['description_ru'].'" data-lang-en="'.$rhythm['description_en'].'" data-lang-vi="'.$rhythm['name'].'"></span>: '.percent_bio_count($this->_dob,date('Y-m-d',time()+86400*$this->_diff),$rhythm['scale']).'</li>';
		}
		echo '
	</ul>
	<input type="hidden" id="dt_curr" value="'.date('Y-m-d',time()+86400*$this->_diff).'" />
	<label class="m-checkbox m-wrap" for="is_secondary">
		<span class="translate" data-lang-ja="表示セカンダリ・リズム" data-lang-zh="示第二性韵律" data-lang-es="Mostrar secundario ritmos" data-lang-ru="Показать вторичные ритмы" data-lang-en="Show secondary rhythms" data-lang-vi="Hiện nhịp sinh học phụ"></span>
		<input class="m-wrap" type="checkbox" name="is_secondary" id="is_secondary" value="1" '.(($this->_is_secondary == 1) ? 'checked': '').' />
	</label>
	<div class="m-input-prepend">
		<span data-lang-ja="日付を表示す:" data-lang-zh="查看日期:" data-lang-es="Ver la fecha:" data-lang-ru="Посмотреть дата:" data-lang-en="View date:" data-lang-vi="Xem ngày:" class="add-on translate" id="dt_change_label"></span>
		<input data-lang-ja="'.$input_interfaces['dt_change']['ja'].'" data-lang-zh="'.$input_interfaces['dt_change']['zh'].'" data-lang-es="'.$input_interfaces['dt_change']['es'].'" data-lang-ru="'.$input_interfaces['dt_change']['ru'].'" data-lang-en="'.$input_interfaces['dt_change']['en'].'" data-lang-vi="'.$input_interfaces['dt_change']['vi'].'" class="m-wrap required" placeholder="'.$input_interfaces['dt_change'][$this->_lang_code].'" id="dt_change" type="text" name="dt_change" size="42" maxlength="128" value="'.$this->_dt_change.'" />
	</div>
	<div class="m-btn-group">
		<a class="m-btn green" id="today"><i class="icon-calendar icon-white"></i><span class="translate" data-lang-ja="'.$button_interfaces['today']['ja'].'" data-lang-zh="'.$button_interfaces['today']['zh'].'" data-lang-es="'.$button_interfaces['today']['es'].'" data-lang-ru="'.$button_interfaces['today']['ru'].'" data-lang-en="'.$button_interfaces['today']['en'].'" data-lang-vi="'.$button_interfaces['today']['vi'].'">'.$button_interfaces['today'][$this->_lang_code].'</span></a>
		<a class="m-btn blue" id="prev"><i class="icon-backward icon-white"></i><span class="translate" data-lang-ja="'.$button_interfaces['prev']['ja'].'" data-lang-zh="'.$button_interfaces['prev']['zh'].'" data-lang-es="'.$button_interfaces['prev']['es'].'" data-lang-ru="'.$button_interfaces['prev']['ru'].'" data-lang-en="'.$button_interfaces['prev']['en'].'" data-lang-vi="'.$button_interfaces['prev']['vi'].'">'.$button_interfaces['prev'][$this->_lang_code].'</span></a>
		<a class="m-btn blue" id="next"><span class="translate" data-lang-ja="'.$button_interfaces['next']['ja'].'" data-lang-zh="'.$button_interfaces['next']['zh'].'" data-lang-es="'.$button_interfaces['next']['es'].'" data-lang-ru="'.$button_interfaces['next']['ru'].'" data-lang-en="'.$button_interfaces['next']['en'].'" data-lang-vi="'.$button_interfaces['next']['vi'].'">'.$button_interfaces['next'][$this->_lang_code].'</span><i class="icon-forward icon-white"></i></a>
	</div>
	<div class="clear"></div>
</section>';
	}
	// Render explanation chart
	function render_explanation_chart() {
		global $menu_interfaces;
		echo '
<div id="explanation_chart" class="context-menu-'.$this->_diff.'-'.$this->_is_secondary.'-'.$this->_lang_code.'"></div>
<script>
$(document).ready(function(){
	$.contextMenu({
		selector: ".context-menu-'.$this->_diff.'-'.$this->_is_secondary.'-'.$this->_lang_code.'",
		items: {
			"today": {
				name: "'.$menu_interfaces['today'][$this->_lang_code].'",
				callback: function(){
					loadExplanationChartResults("'.$this->_dob.'","0","1","'.date('Y-m-d').'",lang);
				}
			},
			"prev": {
				name: "'.$menu_interfaces['prev'][$this->_lang_code].'",
				callback: function(){
					loadExplanationChartResults("'.$this->_dob.'","'.($this->_diff-1).'","1","'.date('Y-m-d',time()+86400*($this->_diff-1)).'",lang);
				}
			},
			"next": {
				name: "'.$menu_interfaces['next'][$this->_lang_code].'",
				callback: function(){
					loadExplanationChartResults("'.$this->_dob.'","'.($this->_diff+1).'","1","'.date('Y-m-d',time()+86400*($this->_diff+1)).'",lang);
				}
			}
		}
	});
	Highcharts.setOptions({
		lang: {
			downloadJPEG: "'.$this->_download_jpeg_text.'",
			downloadPDF: "'.$this->_download_pdf_text.'",
			downloadPNG: "'.$this->_download_png_text.'",
			downloadSVG: "'.$this->_download_svg_text.'",
			printChart: "'.$this->_print_chart_text.'"
		}
	});
	renderChart("#explanation_chart","∞ '.$this->_explanation_title_text.' ∞","'.$this->_percentage_text.'","'.$this->_date_text.'",'.$this->_dates_json.',"'.$this->_today_index.'","'.$this->_dob.'",'.$this->_diff.',"1","'.date('Y-m-d',time()+86400*$this->_diff).'",'.$this->serialize_chart_data().',"explanation");
});
$("#lang_bar").on("click", "#vi_toggle", function(){
	if (!$(this).hasClass("disabled")) {
		loadExplanationChartResults("'.$this->_dob.'","'.$this->_diff.'","1","'.date('Y-m-d',time()+86400*$this->_diff).'","vi");
	}
}).on("click", "#en_toggle", function(){
	if (!$(this).hasClass("disabled")) {
		loadExplanationChartResults("'.$this->_dob.'","'.$this->_diff.'","1","'.date('Y-m-d',time()+86400*$this->_diff).'","en");
	}
}).on("click", "#ru_toggle", function(){
	if (!$(this).hasClass("disabled")) {
		loadExplanationChartResults("'.$this->_dob.'","'.$this->_diff.'","1","'.date('Y-m-d',time()+86400*$this->_diff).'","ru");
	}
}).on("click", "#es_toggle", function(){
	if (!$(this).hasClass("disabled")) {
		loadExplanationChartResults("'.$this->_dob.'","'.$this->_diff.'","1","'.date('Y-m-d',time()+86400*$this->_diff).'","es");
	}
}).on("click", "#zh_toggle", function(){
	if (!$(this).hasClass("disabled")) {
		loadExplanationChartResults("'.$this->_dob.'","'.$this->_diff.'","1","'.date('Y-m-d',time()+86400*$this->_diff).'","zh");
	}
}).on("click", "#ja_toggle", function(){
	if (!$(this).hasClass("disabled")) {
		loadExplanationChartResults("'.$this->_dob.'","'.$this->_diff.'","1","'.date('Y-m-d',time()+86400*$this->_diff).'","ja");
	}
});
</script>
		';
	}
	// Render embed chart
	function render_embed_chart() {
		global $menu_interfaces;
		echo '
<div id="embed_chart" class="context-menu-'.$this->_diff.'-'.$this->_is_secondary.'-'.$this->_lang_code.'"></div>
<script>
$(document).ready(function(){
	$.contextMenu({
		selector: ".context-menu-'.$this->_diff.'-'.$this->_is_secondary.'-'.$this->_lang_code.'",
		items: {
			"today": {
				name: "'.$menu_interfaces['today'][$this->_lang_code].'",
				callback: function(){
					loadEmbedChartResults("'.$this->_dob.'","0","0","'.date('Y-m-d').'",lang);
				}
			},
			"prev": {
				name: "'.$menu_interfaces['prev'][$this->_lang_code].'",
				callback: function(){
					loadEmbedChartResults("'.$this->_dob.'","'.($this->_diff-1).'","0","'.date('Y-m-d',time()+86400*($this->_diff-1)).'",lang);
				}
			},
			"next": {
				name: "'.$menu_interfaces['next'][$this->_lang_code].'",
				callback: function(){
					loadEmbedChartResults("'.$this->_dob.'","'.($this->_diff+1).'","0","'.date('Y-m-d',time()+86400*($this->_diff+1)).'",lang);
				}
			}
		}
	});
	Highcharts.setOptions({
		lang: {
			downloadJPEG: "'.$this->_download_jpeg_text.'",
			downloadPDF: "'.$this->_download_pdf_text.'",
			downloadPNG: "'.$this->_download_png_text.'",
			downloadSVG: "'.$this->_download_svg_text.'",
			printChart: "'.$this->_print_chart_text.'"
		}
	});
	renderChart("#embed_chart","'.$this->_title_text.$this->_dob.' | '.date('Y-m-d',time()+86400*$this->_diff).'","'.$this->_percentage_text.'","'.$this->_date_text.'",'.$this->_dates_json.',"'.$this->_today_index.'","'.$this->_dob.'",'.$this->_diff.',"0","'.date('Y-m-d',time()+86400*$this->_diff).'",'.$this->serialize_chart_data().',"embed");
});
</script>
		';
	}
	// Render chart
	function render_chart() {
		echo '<div id="chart">';
		$this->render_main_chart();
		echo '</div>';
	}
	// Render Highcharts
	function render_main_chart() {
		global $menu_interfaces;
		echo '
<div id="main_chart" class="context-menu-'.$this->_diff.'-'.$this->_is_secondary.'-'.$this->_lang_code.'"></div>
<script>
$(document).ready(function(){
	$.contextMenu({
		selector: ".context-menu-'.$this->_diff.'-'.$this->_is_secondary.'-'.$this->_lang_code.'",
		items: {
			"today": {
				name: "'.$menu_interfaces['today'][$this->_lang_code].'",
				callback: function(){
					loadResults("'.$this->_dob.'","0","'.$this->_is_secondary.'","'.date('Y-m-d').'",lang);
				}
			},
			"prev": {
				name: "'.$menu_interfaces['prev'][$this->_lang_code].'",
				callback: function(){
					loadResults("'.$this->_dob.'","'.($this->_diff-1).'","'.$this->_is_secondary.'","'.date('Y-m-d',time()+86400*($this->_diff-1)).'",lang);
				}
			},
			"next": {
				name: "'.$menu_interfaces['next'][$this->_lang_code].'",
				callback: function(){
					loadResults("'.$this->_dob.'","'.($this->_diff+1).'","'.$this->_is_secondary.'","'.date('Y-m-d',time()+86400*($this->_diff+1)).'",lang);
				}
			},
			"next_birthday": {
				name: "'.$menu_interfaces['next_birthday'][$this->_lang_code].'",
				callback: function(){
					loadResults("'.$this->_dob.'","'.($this->_diff+countdown_birthday($this->_dob, $this->_date)).'","'.$this->_is_secondary.'","'.date('Y-m-d',time()+86400*($this->_diff+countdown_birthday($this->_dob, $this->_date))).'",lang);
				}
			}
		}
	});
	Highcharts.setOptions({
		lang: {
			downloadJPEG: "'.$this->_download_jpeg_text.'",
			downloadPDF: "'.$this->_download_pdf_text.'",
			downloadPNG: "'.$this->_download_png_text.'",
			downloadSVG: "'.$this->_download_svg_text.'",
			printChart: "'.$this->_print_chart_text.'"
		}
	});
	renderChart("#main_chart","'.$this->_title_text.$this->_dob.' | '.date('Y-m-d',time()+86400*$this->_diff).'","'.$this->_percentage_text.'","'.$this->_date_text.'",'.$this->_dates_json.',"'.$this->_today_index.'","'.$this->_dob.'",'.$this->_diff.',"'.$this->_is_secondary.'",$("#dt_change").val(),'.$this->serialize_chart_data().',"main");
});
</script>
		';
	}
	// Render script
	function render_script() {
		echo '
<script>
$(document).ready(function(){';
if ($this->_diff == 0) {
		echo '
	$("body").addClass("today");';
} else {
		echo '
	$("body").removeClass("today");';
}
if (date('m-d',time()+86400*$this->_diff) == date('m-d',strtotime($this->_dob))) {
		echo '
	$("body").removeClass("today").addClass("birthday");';
} else {
		echo '
	$("body").removeClass("birthday");';
	}
		echo '
});
lang = $.cookie("NSH:lang");
dt_curr = $("#dt_curr").val();
dt_change = $("#dt_change").val();
disableInput("dt_change");
$("#dt_change").datepicker({
	dateFormat: "yy-mm-dd",
	changeYear: true,
	changeMonth: true,
	yearRange: "'.(date('Y',strtotime($this->_dob))).':2500",
	defaultDate: "'.date('Y-m-d',strtotime($this->_dt_change)).'",
	minDate: "'.$this->_dob.'",
	showButtonPanel: true,
	showAnim: ""
});
$("#controls a.m-btn, #embed_toggle, #lunar_desc, label[for=\"is_secondary\"]").ripple();
if ($("label[for=is_secondary]").find("#is_secondary").prop("checked") == false) {
	$("label[for=is_secondary]").removeClass("clicked");
} else if ($("label[for=is_secondary]").find("#is_secondary").prop("checked") == true) {
	$("label[for=is_secondary]").addClass("clicked");
}
$("span.translate").each(function(){
	$(this).text($(this).attr("data-lang-"+lang));
});
$("input.translate").each(function(){
	$(this).text($(this).attr("data-lang-"+lang)).attr("placeholder",$(this).attr("data-lang-"+lang));
});
toggleCookie("NSH:embed-toggle","textarea#embed_box","#embed_toggle","#info");
toggleCookie("NSH:lunar-toggle","#lunar_desc ~ .lunar_desc","#lunar_desc","#lunar");
$("#controls").on("click", "#today", function(){
	loadResults("'.$this->_dob.'","0","'.$this->_is_secondary.'","'.date('Y-m-d').'",lang);
}).on("click", "#prev", function(){
	loadResults("'.$this->_dob.'","'.($this->_diff-1).'","'.$this->_is_secondary.'","'.date('Y-m-d',time()+86400*($this->_diff-1)).'",lang);
}).on("click", "#next", function(){
	loadResults("'.$this->_dob.'","'.($this->_diff+1).'","'.$this->_is_secondary.'","'.date('Y-m-d',time()+86400*($this->_diff+1)).'",lang);
}).on("change", "#dt_change", function(){
	loadResults("'.$this->_dob.'",'.$this->_diff.'+dateDiff(dt_curr,$("#dt_change").val()),"'.$this->_is_secondary.'",$("#dt_change").val(),lang);
}).on("change", "#is_secondary", function(){
	if ($(this).prop("checked") == false) {
		loadResults("'.$this->_dob.'","'.$this->_diff.'","0","'.date('Y-m-d',time()+86400*$this->_diff).'",lang);
	} else if ($(this).prop("checked") == true) {
		loadResults("'.$this->_dob.'","'.$this->_diff.'","1","'.date('Y-m-d',time()+86400*$this->_diff).'",lang);
	}
}).on("click", "#dt_change_label", function(){
	$("#dt_change").datepicker("show");
});
$("#lang_bar").on("click", "#vi_toggle", function(){
	if (!$(this).hasClass("disabled")) {
		loadResults("'.$this->_dob.'","'.$this->_diff.'","'.$this->_is_secondary.'","'.date('Y-m-d',time()+86400*$this->_diff).'","vi");
	}
}).on("click", "#en_toggle", function(){
	if (!$(this).hasClass("disabled")) {
		loadResults("'.$this->_dob.'","'.$this->_diff.'","'.$this->_is_secondary.'","'.date('Y-m-d',time()+86400*$this->_diff).'","en");
	}
}).on("click", "#ru_toggle", function(){
	if (!$(this).hasClass("disabled")) {
		loadResults("'.$this->_dob.'","'.$this->_diff.'","'.$this->_is_secondary.'","'.date('Y-m-d',time()+86400*$this->_diff).'","ru");
	}
}).on("click", "#es_toggle", function(){
	if (!$(this).hasClass("disabled")) {
		loadResults("'.$this->_dob.'","'.$this->_diff.'","'.$this->_is_secondary.'","'.date('Y-m-d',time()+86400*$this->_diff).'","es");
	}
}).on("click", "#zh_toggle", function(){
	if (!$(this).hasClass("disabled")) {
		loadResults("'.$this->_dob.'","'.$this->_diff.'","'.$this->_is_secondary.'","'.date('Y-m-d',time()+86400*$this->_diff).'","zh");
	}
}).on("click", "#ja_toggle", function(){
	if (!$(this).hasClass("disabled")) {
		loadResults("'.$this->_dob.'","'.$this->_diff.'","'.$this->_is_secondary.'","'.date('Y-m-d',time()+86400*$this->_diff).'","ja");
	}
});
</script>
		';
	}
	function render_results() {
		$this->render_info();
		$this->render_lunar();
		$this->render_controls();
		$this->render_chart();
		$this->render_script();
	}
	function render_array() {
		echo '<pre>';
		print_r($this->_rhythms);
		echo '</pre>';
	}
}