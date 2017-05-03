<?php defined('SYSPATH') or die('No direct script access.');

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`projects` ( 
			`id` int(10) NOT NULL AUTO_INCREMENT,
			`alias` varchar(250),
			`is_fine` int(1),
			`weight` int(5),
			`status` int(1),
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();


Route::set('project_lang', '<lang>/projects/<alias>', array('lang' => '[a-zA-Z]{2}', 'alias' => '.+'))
->defaults(array(
	'controller' => 'projects',
	'action'     => 'project',
));

Route::set('project', 'projects/<alias>', array('alias' => '.+'))
->defaults(array(
	'controller' => 'projects',
	'action'     => 'project',
));

Route::set('projects', 'projects')
	->defaults(array(
		'controller' => 'projects',
		'action'     => 'projects',
));

Route::set('projects_lang', '<lang>/projects', array('lang' => '[a-zA-Z]{2}'))
	->defaults(array(
		'controller' => 'projects',
		'action'     => 'projects',
));