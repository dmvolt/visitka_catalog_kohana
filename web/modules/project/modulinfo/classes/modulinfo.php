<?php

defined('SYSPATH') or die('No direct script access.');

class Modulinfo {

    public static function get_admin_block($module = 'articles') {
        $content = View::factory('admin/modulinfo-block')
				->bind('module', $module)
                ->bind('modulinfo', $modulinfo);
        $modulinfo_obj = new Model_Modulinfo();
        $modulinfo = $modulinfo_obj->get_block($module);
        return $content;
    }
	
	public static function get_block($module = 'articles') {
        $modulinfo_obj = new Model_Modulinfo();
        return $modulinfo_obj->get_block($module);
    }
}
// Modulinfo