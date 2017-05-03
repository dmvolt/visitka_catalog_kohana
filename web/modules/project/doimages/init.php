<?php defined('SYSPATH') or die('No direct script access.');

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`doimages` ( 
			`id` int(10) auto_increment,
			`filename` varchar(64),
			`filepathname` varchar(255),
			`filesize` int(10),
			`fileurl` varchar(255),
			`filetype` varchar(64),
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`contents_doimages` ( 
			`content_id` int(10),
			`file_id` int(10),
			`delta` int(5),
			`is_image` int(1),
			`module` varchar(64)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`doimages_description` (
			`file_id` int(10),
			`lang_id` int(3),
			`link` varchar(255),
			`title` text,
			`description` text
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();