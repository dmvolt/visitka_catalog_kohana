<?php defined('SYSPATH') or die('No direct script access.');

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`articles` ( 
			`id` int(10) NOT NULL AUTO_INCREMENT,
			`date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`author` varchar(100),
			`alias` varchar(250),
			`menu` varchar(64),
			`weight` int(5),
			`status` int(1),
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();


Route::set('article_lang', '<lang>/articles/<alias>', array('lang' => '[a-zA-Z]{2}', 'alias' => '.+'))
->defaults(array(
	'controller' => 'articles',
	'action'     => 'article',
));

Route::set('article', 'articles/<alias>', array('alias' => '.+'))
->defaults(array(
	'controller' => 'articles',
	'action'     => 'article',
));





Route::set('articles', 'articles(/<cat>)', array('cat' => '[a-zA-Z0-9\-]+'))
	->defaults(array(
		'controller' => 'articles',
		'action'     => 'articles',
));

Route::set('articles_lang', '<lang>/articles(/<cat>)', array('lang' => '[a-zA-Z]{2}', 'cat' => '[a-zA-Z0-9\-]+'))
	->defaults(array(
		'controller' => 'articles',
		'action'     => 'articles',
));