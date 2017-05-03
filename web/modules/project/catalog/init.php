<?php defined('SYSPATH') or die('No direct script access.');

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`catalog` ( 
			`id` int(10) NOT NULL AUTO_INCREMENT,
			`price1` varchar(250),
			`price2` varchar(250),
			`alias` varchar(250),
			`weight` int(5),
			`is_fine` int(1),
			`status` int(1),
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();

Route::set('good3', 'catalog/<cat1>/<cat2>/<cat3>/g-<alias>', array('alias' => '[a-zA-Z0-9\-]+', 'cat1' => '[a-zA-Z0-9\-]+', 'cat2' => '[a-zA-Z0-9\-]+', 'cat3' => '[a-zA-Z0-9\-]+'))
->defaults(array(
	'controller' => 'catalog',
	'action'     => 'good',
));

Route::set('good2', 'catalog/<cat1>/<cat2>/g-<alias>', array('alias' => '[a-zA-Z0-9\-]+', 'cat1' => '[a-zA-Z0-9\-]+', 'cat2' => '[a-zA-Z0-9\-]+'))
->defaults(array(
	'controller' => 'catalog',
	'action'     => 'good',
));

Route::set('good1', 'catalog/<cat1>/g-<alias>', array('alias' => '[a-zA-Z0-9\-]+', 'cat1' => '[a-zA-Z0-9\-]+'))
->defaults(array(
	'controller' => 'catalog',
	'action'     => 'good',
));

Route::set('good', 'catalog/g-<alias>', array('alias' => '[a-zA-Z0-9\-]+'))
->defaults(array(
	'controller' => 'catalog',
	'action'     => 'good',
));

Route::set('catalog3', 'catalog/<cat1>/<cat2>/<cat3>', array('cat1' => '[a-zA-Z0-9\-]+', 'cat2' => '[a-zA-Z0-9\-]+', 'cat3' => '[a-zA-Z0-9\-]+'))
	->defaults(array(
		'controller' => 'catalog',
		'action'     => 'catalog',
));

Route::set('catalog2', 'catalog/<cat1>/<cat2>', array('cat1' => '[a-zA-Z0-9\-]+', 'cat2' => '[a-zA-Z0-9\-]+'))
	->defaults(array(
		'controller' => 'catalog',
		'action'     => 'catalog',
));

Route::set('catalog1', 'catalog/<cat1>', array('cat1' => '[a-zA-Z0-9\-]+'))
	->defaults(array(
		'controller' => 'catalog',
		'action'     => 'catalog',
));

Route::set('catalog', 'catalog')
	->defaults(array(
		'controller' => 'catalog',
		'action'     => 'catalog',
));