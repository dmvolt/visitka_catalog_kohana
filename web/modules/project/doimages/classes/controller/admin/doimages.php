<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Doimages {

	public static function set_fields($content_id = 0, $post = array(), $module = 'products') {
		$session = Session::instance();
		$doimages_obj = new Model_Doimages();		
		$add_doimages = $session->get('add_doimages', 0);
		if ($add_doimages) {
			foreach ($add_doimages as $delta => $doimages_id) {
				$doimages_obj->add_files_by_content($content_id, $doimages_id, $delta, $module, 0);
			}
			$session->delete('add_doimages');
		}
		
		if (isset($post['doimages_descriptions'])) {
            $doimages_descriptions = Arr::get($post, 'doimages_descriptions', null);
            if ($doimages_descriptions) {
                foreach ($doimages_descriptions as $doimages_id => $data) {
                    $doimages_obj->update_fileinfo($doimages_id, $data);
                }
            }
        }		
		return true;
    }
	
	public static function get_fields($data = array(), $module = 'products') {
		$doimages_obj = new Model_Doimages();
		if($data AND !empty($data)){
			$filedata['filesdata'] = $doimages_obj->get_files_by_content_id($data['id'], $module);
		} else {
			$data['id'] = 0;
		}
		
		return View::factory('admin/fields_doimages')
				->bind('module', $module)
				->bind('is_image', $is_image)
                ->bind('id', $data['id']);
    }
}