<?php defined('SYSPATH') or die('No direct script access.');

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`news` ( 
			`id` int(5) auto_increment,
			`date` varchar(64),
			`timestamp` int(20),
			`alias` varchar(255),
			`weight` int(5),
			`type` int(1),
			`status` int(1),
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`poll` ( 
			`id` int(5) auto_increment,
			`news_id` int(5),
			`lang_id` int(3),
			`result` varchar(255),
			`ip` varchar(255),
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();


Route::set('news_lang', '<lang>/news', array('lang' => '[a-zA-Z]{2}'))
	->defaults(array(
		'controller' => 'news',
		'action'     => 'news',
)); 

Route::set('news', 'news')
	->defaults(array(
		'controller' => 'news',
		'action'     => 'news',
));  

Route::set('new_lang', '<lang>/news(/<id>)', array('lang' => '[a-zA-Z]{2}', 'id' => '[0-9]+'))
->defaults(array(
	'controller' => 'news',
	'action'     => 'new',
));

Route::set('new', 'news(/<id>)', array('id' => '[0-9]+'))
->defaults(array(
	'controller' => 'news',
	'action'     => 'new',
));