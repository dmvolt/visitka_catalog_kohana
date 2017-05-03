<?php defined('SYSPATH') or die('No direct script access.');

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`photos` ( 
			`id` int(10) NOT NULL AUTO_INCREMENT,
			`alias` varchar(250),
			`weight` int(5),
			`status` int(1),
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();


Route::set('photo_lang', '<lang>/photo/<alias>', array('lang' => '[a-zA-Z]{2}', 'id' => '.+'))
->defaults(array(
	'controller' => 'photos',
	'action'     => 'photo',
));

Route::set('photo', 'photo/<alias>', array('id' => '.+'))
->defaults(array(
	'controller' => 'photos',
	'action'     => 'photo',
));





Route::set('photos', 'photos(/<cat>)', array('cat' => '[a-zA-Z0-9\-]+'))
	->defaults(array(
		'controller' => 'photos',
		'action'     => 'photos',
));

Route::set('photos_lang', '<lang>/photos(/<cat>)', array('lang' => '[a-zA-Z]{2}', 'cat' => '[a-zA-Z0-9\-]+'))
	->defaults(array(
		'controller' => 'photos',
		'action'     => 'photos',
));