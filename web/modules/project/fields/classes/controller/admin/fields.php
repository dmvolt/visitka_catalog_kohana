<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Fields extends Controller_Admin_Template {

	public function action_index() {
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
				
		if (isset($_POST['fields'])) {    
			Controller_Admin_Fields::set_fields(0, $_POST, 'fields');
			Request::initial()->redirect('admin/fields');
		}
		
		$data['fields_form'] = Controller_Admin_Fields::get_fields(array('id' => 0), 'fields', 'Добавить ссылку на файл');
        $this->template->content = View::factory('admin/fields', $data);
    }

	public static function set_fields($id, $post = array(), $module = 'pages') {
		$fields_obj = new Model_Fields();	
		$fields_data = Arr::get($post, 'fields', array());
	
		$fields_obj->add($id, $fields_data, $module);	
		return true;
    }
	
	public static function get_fields($data = array(), $module = 'pages', $group_fieldname = 'Ссылка на файл', $fieldname1 = 'Url:', $fieldname2 = 'Текст ссылки:') {
		$fields_obj = new Model_Fields();		
		if($data AND !empty($data)){
			$result = $fields_obj->get_fields_to_content($data['id'], $module);
		} else {
			$result = false;
		}		
		return View::factory('admin/fields_fields')
				->bind('group_fieldname', $group_fieldname)
				->bind('fieldname1', $fieldname1)
				->bind('fieldname2', $fieldname2)
                ->bind('fields', $result);
    }
}