<?php defined('SYSPATH') or die('No direct script access.');

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`actions` ( 
			`id` int(10) NOT NULL AUTO_INCREMENT,
			`alias` varchar(250),
			`weight` int(5),
			`status` int(1),
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();


Route::set('action_lang', '<lang>/actions/<alias>', array('lang' => '[a-zA-Z]{2}', 'alias' => '.+'))
->defaults(array(
	'controller' => 'actions',
	'action'     => 'action',
));

Route::set('action', 'actions/<alias>', array('alias' => '.+'))
->defaults(array(
	'controller' => 'actions',
	'action'     => 'action',
));

Route::set('actions', 'actions')
	->defaults(array(
		'controller' => 'actions',
		'action'     => 'actions',
));

Route::set('actions_lang', '<lang>/actions', array('lang' => '[a-zA-Z]{2}'))
	->defaults(array(
		'controller' => 'actions',
		'action'     => 'actions',
));