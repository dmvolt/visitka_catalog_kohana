<?php

defined('SYSPATH') or die('No direct script access.');

$lang_array = array(
    'text_search_not_found' => 'Извините, по данному поисковому запросу ничего не найдено.',
	'text_search' => 'Поиск',
	'text_filter' => 'Фильтр',
	'text_filter_ok' => 'Применить',
	'text_filter_as_type' => 'по типу',
	'text_filter_as_style' => 'по стилю',
	'text_filter_as_price' => 'по цене',
	'text_filter_as_price_from' => 'от',
	'text_filter_as_price_to' => 'до',
	'text_filter_as_price_currency' => 'руб.',
	'text_search_results' => 'Результаты поиска',
);

View::set_global($lang_array);