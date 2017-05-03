<?php
defined('SYSPATH') or die('No direct script access.');
$lang_array = array(
    'text_articles' => 'Статьи',
    'text_cat_articles' => 'Категории публикаций',
    'text_add_new_articles' => 'Добавить публикацию',
    'text_articles_date' => 'Дата:',
    'text_articles_author' => 'Автор:',
    'text_articles_status' => 'Опубликовано:',
	'text_articles_is_fine' => 'Важное:',
    'text_articles_thead_name' => 'Наименование',
    'text_articles_thead_alias' => 'Путь (синоним)',
    'text_articles_thead_status' => 'Статус',
    'text_articles_thead_action' => 'Действия',
);
View::set_global($lang_array);