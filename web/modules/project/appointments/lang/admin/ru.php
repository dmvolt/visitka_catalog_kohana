<?php

defined('SYSPATH') or die('No direct script access.');

$lang_array = array(
    'text_appointments' => 'Все заявки',
    'text_add_new_appointments' => 'Добавить заявку',
	'text_cat_appointments' => 'Специализация:',
	'text_doctor_appointments' => 'Врач:',
    'text_appointments_date' => 'Дата:',
	'text_appointments_name' => 'Имя:',
	'text_appointments_contact' => 'Контактная информация:',
	'text_appointments_time' => 'Время:',
    'text_appointments_status' => 'Опубликовано:',
    'text_appointments_thead_date' => 'Дата',
    'text_appointments_thead_time' => 'Время',
	'text_appointments_thead_name' => 'Имя',
	'text_appointments_thead_contact' => 'Контакты',
    'text_appointments_thead_status' => 'Статус',
    'text_appointments_thead_action' => 'Действия',
);

View::set_global($lang_array);