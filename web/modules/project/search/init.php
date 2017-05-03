<?php defined('SYSPATH') or die('No direct script access.');


Route::set('search_lang', '<lang>/search', array('lang' => '[a-zA-Z]{2}'))
	->defaults(array(
		'controller' => 'search',
		'action'     => 'index',		
));

Route::set('search', 'search')
	->defaults(array(
		'controller' => 'search',
		'action'     => 'index',		
));