<?php

defined('SYSPATH') or die('No direct script access.');

class Fields {

	public static function get_fields($Id = 0, $module = 'fields') {
		$fields_obj = new Model_Fields();		
		
		$result = $fields_obj->get_fields_to_content($Id, $module);
			
		return View::factory(Data::_('template_directory') . 'links-block')
                ->bind('fields', $result);
    }
	
	public static function video_block($Id = 0, $module = 'fields') {
		$fields_obj = new Model_Fields();		
		
		$result = $fields_obj->get_fields_to_content($Id, $module);
			
		return View::factory(Data::_('template_directory') . 'video-block')
                ->bind('fields', $result);
    }
}
// Fields