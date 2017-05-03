<?php 

defined('SYSPATH') or die('No direct script access.');

class Text extends Kohana_Text {

	public static function generatePassword($number){
            //$number - кол-во символов в пароле
            $arr = array('a','b','c','d','e','f',
			'g','h','i','j','k','l',
			'm','n','o','p','r','s',
			't','u','v','x','y','z',
			'A','B','C','D','E','F',
			'G','H','I','J','K','L',
			'M','N','O','P','R','S',
			'T','U','V','X','Y','Z',
			'1','2','3','4','5','6',
			'7','8','9','0');
            // Генерируем пароль
		$pass = "";
		for($i = 0; $i < $number; $i++)
		{
		// Вычисляем случайный индекс массива
			$index = rand(0, count($arr) - 1);
			$pass .= $arr[$index];
		}
		return $pass;
  	}
	
	public static function transliteration($string, $is_file = 0) {
		$string = UTF8::strtolower($string); //В нижний регистр
		$converter = array(
			'а' => 'a',   'б' => 'b',   'в' => 'v',
			'г' => 'g',   'д' => 'd',   'е' => 'e',
			'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
			'и' => 'i',   'й' => 'y',   'к' => 'k',
			'л' => 'l',   'м' => 'm',   'н' => 'n',
			'о' => 'o',   'п' => 'p',   'р' => 'r',
			'с' => 's',   'т' => 't',   'у' => 'u',
			'ф' => 'f',   'х' => 'h',   'ц' => 'c',
			'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
			'ь' => '',    'ы' => 'y',   'ъ' => '',
			'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
			
			'А' => 'a',   'Б' => 'b',   'В' => 'v',
			'Г' => 'g',   'Д' => 'd',   'Е' => 'e',
			'Ё' => 'e',   'Ж' => 'zh',  'З' => 'z',
			'И' => 'i',   'Й' => 'y',   'К' => 'k',
			'Л' => 'l',   'М' => 'm',   'Н' => 'n',
			'О' => 'o',   'П' => 'p',   'Р' => 'r',
			'С' => 's',   'Т' => 't',   'У' => 'u',
			'Ф' => 'f',   'Х' => 'h',   'Ц' => 'c',
			'Ч' => 'ch',  'Ш' => 'sh',  'Щ' => 'sch',
			'Ь' => '',    'Ы' => 'y',   'Ъ' => '',
			'Э' => 'e',   'Ю' => 'yu',  'Я' => 'ya',' ' => '-'
		);
					
		$string = strtr($string, $converter);
		
		if ($is_file){
			$string = preg_replace ('/[^a-zA-Z0-9\-\.]/', '', $string); //переводим в латиницу, избавляемся от левых символов
		} else {
			$string = preg_replace ('/[^a-zA-Z0-9\-]/', '', $string); //переводим в латиницу, избавляемся от левых символов
			if(UTF8::strlen($string) >= 30) $res = UTF8::substr($string, 0, 30); //обрезаем, > 30 символов в URL нафиг не надо
		}
		return $string;
	}
	
	public static function get_sku_separator() {
		return Kohana::$config->load('checkout_setting.default.sku_separator');
	}
	
	public static function auto_filename($filepath) {	
		if($filepath != ''){
			$img_array = explode('/', $filepath);
			$count_segment = count($img_array)-1;
			return $img_array[$count_segment];
		} else {
			return $filepath;
		}
	}
	
	public static function mark($str, $markwords){
	
		foreach ((array)$markwords as $key => $word)
		{
			$str = str_replace(trim($word), '<span class="marker">'.trim($word).'</span>', $str);
		}
		return $str;
	}
	
	public static function format_date($date, $format = 'd-m-Y', $delimiter = '-', $new_day = false, $lang_id = 1){
		
		$new_format_date = '';
		
		if(!empty($date)){
			$monthAr = array(
				1 => array(1 => 'Января', 2 => 'January'),
				2 => array(1 => 'Февраля', 2 => 'February'),
				3 => array(1 => 'Марта', 2 => 'March'),
				4 => array(1 => 'Апреля', 2 => 'April'),
				5 => array(1 => 'Мая', 2 => 'May'),
				6 => array(1 => 'Июня', 2 => 'June'),
				7 => array(1 => 'Июля', 2 => 'July'),
				8 => array(1 => 'Августа', 2 => 'August'),
				9 => array(1 => 'Сентября', 2 => 'September'),
				10=> array(1 => 'Октября', 2 => 'October'),
				11=> array(1 => 'Ноября', 2 => 'November'),
				12=> array(1 => 'Декабря', 2 => 'December')
			);

			if($new_day){
				$date_stamp = strtotime($date.$new_day);
			} else {
				$date_stamp = strtotime($date);
			}
			
			$new_format_date_pre = date($format, $date_stamp);
			
			$new_format_date_arr = explode($delimiter, $new_format_date_pre);
			
			if($new_format_date_arr AND is_array($new_format_date_arr)){
				foreach($new_format_date_arr as $key => $value){
					if($key == 1){
						$new_format_date .= $delimiter.$monthAr[(int)$value][$lang_id];
					} elseif($key > 1){
						$new_format_date .= $delimiter.$value;
					} else {
						$new_format_date .= $value;
					}
				}
			}
		}
		return $new_format_date;
	} 
}