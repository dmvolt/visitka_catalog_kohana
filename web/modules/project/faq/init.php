<?php defined('SYSPATH') or die('No direct script access.');
DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`faq` ( 
			`id` int(5) auto_increment,
			`content_id` int(5),
			`parent_id` int(5),
			`doctor_id` int(5),
			`group_id` int(3),
			`date` varchar(64),
			`contact` varchar(255),
			`weight` int(5),
			`status` int(1),
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();