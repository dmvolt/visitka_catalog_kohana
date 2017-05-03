<?php

defined('SYSPATH') or die('No direct script access');



return array(
    'main_menu' => array(
        0 => array(
            'name' => 'Главная',
            'href' => '/',
            'target' => '')
    ),
    'group_cat' => array(
        1 => array(
            'name' => 'Категории каталога',
            'dictionary_id' => 1),
        
    ),
    'group_menu' => array(
        1 => array(
            'name' => 'Главное меню',
            'dictionary_id' => 1),
		2 => array(
            'name' => 'Дополнительное меню',
            'dictionary_id' => 2),
        3 => array(
            'name' => 'Соц.сети',
            'dictionary_id' => 3),
        
    )
);
