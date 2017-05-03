<?php defined('SYSPATH') or die('No direct script access.');

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`documents` ( 
			`id` int(10) NOT NULL AUTO_INCREMENT,
			`parent_id` int(10),
			`date` varchar(250),
			`link` varchar(250),
			`alias` varchar(250),
			`weight` int(5),
			`status` int(1),
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();


Route::set('document_lang', '<lang>/documents/<alias>', array('lang' => '[a-zA-Z]{2}', 'alias' => '.+'))
->defaults(array(
	'controller' => 'documents',
	'action'     => 'article',
));

Route::set('document', 'documents/<alias>', array('alias' => '.+'))
->defaults(array(
	'controller' => 'documents',
	'action'     => 'article',
));





Route::set('documents', 'documents')
	->defaults(array(
		'controller' => 'documents',
		'action'     => 'documents',
));

Route::set('documents_lang', '<lang>/documents', array('lang' => '[a-zA-Z]{2}'))
	->defaults(array(
		'controller' => 'documents',
		'action'     => 'documents',
));