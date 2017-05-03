<?php

defined('SYSPATH') or die('No direct script access.');

$lang_array = array(
    'text_page_not_found' => 'Извините, здесь пока ничего нет.',
	'text_edit' => 'Редактировать',	'text_full_edit' => 'Расширеное редактирование материала',
	'text_save' => 'Сохранить',
	'text_entry_captcha' => 'Пожалуйста, введите комбинацию букв и цифр с картинки',
	'text_login_field' => 'Ваш логин...',
	'text_login' => 'Войти',
	'text_password_field' => 'Ваш пароль...',
	'text_reg' => 'Регистрация',
	'text_pass_recovery' => 'Забыли пароль?',
	'text_logout' => 'Выйти',
	'text_login_welcome' => 'Вы вошли как ',
	'text_old_browser_warning' => 'Вы используете <strong>устаревший</strong> браузер. Пожалуйста <a href="http://browsehappy.com/">обновите Ваш браузер</a> для корректного отображения страницы.',
	'text_link_preview' => '<< Предыдущая',
	'text_preview' => 'Предыдущая статья',
	'text_link_next' => 'Следующая >>',
	'text_next' => 'Следующая статья',
	'text_error_404' => 'Запрашиваемая вами страница не найдена!<br>Возможно вы ввели неправильный адрес<br>или страница была удалена.<br><a href="/">Перейти на главную страницу</a>.',
	'text_error_500' => 'Произошла ошибка на сервере!<br>Не расстраивайтесь и смело идите на <a href="/front">Главную страницу</a>.',
	'text_error_503' => 'Произошла ошибка на сервере!<br>Не расстраивайтесь и смело идите на <a href="/front">Главную страницу</a>.',
	
	'text_our_products' => 'Наша продукция',
	
	'text_contact_form' => 'Связаться с нами',
	'text_contact_form_name' => 'Ваше имя',
	'text_contact_form_phone' => 'Телефон',
	'text_contact_form_email' => 'E-mail',
	'text_contact_form_city' => 'Город',
	'text_contact_form_message' => 'Сообщение',
	'text_contact_form_notice' => '<b>Примечание:</b> поля, отмеченные звездочкой (<span class="r">*</span>), обязательны к заполнению.',
	'text_contact_form_submit' => 'Отправить',
);

View::set_global($lang_array);