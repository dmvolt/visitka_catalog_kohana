<?php
defined('SYSPATH') or die('No direct script access.');
$lang_array = array(
	'text_photos' => 'Фотогалерея',
    'text_cat_photos' => 'Категории публикаций',
    'text_add_new_photos' => 'Добавить публикацию',
    'text_photos_date' => 'Дата:',
    'text_photos_author' => 'Автор:',
    'text_photos_status' => 'Опубликовано:',
	'text_photos_is_fine' => 'Важное:',
    'text_photos_thead_name' => 'Наименование',
    'text_photos_thead_alias' => 'Путь (синоним)',
    'text_photos_thead_status' => 'Статус',
    'text_photos_thead_action' => 'Действия',
);
View::set_global($lang_array);