<?php defined('SYSPATH') or die('No direct script access.');

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`services` ( 
			`id` int(10) NOT NULL AUTO_INCREMENT,
			`alias` varchar(250),
			`is_fine` int(1),
			`weight` int(5),
			`status` int(1),
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();


Route::set('service_lang', '<lang>/services/<alias>', array('lang' => '[a-zA-Z]{2}', 'alias' => '.+'))
->defaults(array(
	'controller' => 'services',
	'action'     => 'service',
));

Route::set('service', 'services/<alias>', array('alias' => '.+'))
->defaults(array(
	'controller' => 'services',
	'action'     => 'service',
));

Route::set('services', 'services')
	->defaults(array(
		'controller' => 'services',
		'action'     => 'services',
));

Route::set('services_lang', '<lang>/services', array('lang' => '[a-zA-Z]{2}'))
	->defaults(array(
		'controller' => 'services',
		'action'     => 'services',
));