<?php defined('SYSPATH') or die('No direct script access.');
DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`appointments` ( 
			`id` int(5) auto_increment,
			`category_id` int(5),
			`doctor_id` int(3),
			`date` varchar(64),
			`name` varchar(64),
			`contact` varchar(128),
			`time` varchar(128),
			`weight` int(5),
			`status` int(1),
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();