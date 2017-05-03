<?php defined('SYSPATH') or die('No direct script access.');

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`fields` ( 
			`id` int(10) auto_increment,
			`lang_id` int(10),
			`field0` text,
			`field1` text,
			`field2` text,
			`field3` text,
			`field4` text,
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`contents_fields` ( 
			`content_id` int(10),
			`field_id` int(10),
			`module` varchar(64)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();