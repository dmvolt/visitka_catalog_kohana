<?php defined('SYSPATH') or die('No direct script access');



return array(
    'main_menu' => array(
			
	0 => array(
			'name' => 'Пользователи',
			'href' => '/admin/user',
			'target' => '',
			'controller' => 'user'),	
			
	1=> array(
			'name' => 'Инфо',
			'href' => '/admin/siteinfo',
			'target' => '',
			'controller' => 'siteinfo'),
			
	2 => array(
			'name' => 'Категории',
			'href' => '/admin/categories',
			'target' => '',
			'controller' => 'categories'),
	  
	
	3 => array(
			'name' => 'Страницы',
			'href' => '/admin/pages',
			'target' => '',
			'controller' => 'pages')
			            
	)
);