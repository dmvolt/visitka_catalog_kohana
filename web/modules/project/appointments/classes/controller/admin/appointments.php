<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Kohana user guide and api browser.
 *
 * @package    Kohana/Userguide
 * @category   Controllers
 * @author     Kohana Team
 */
class Controller_Admin_Appointments extends Controller_Admin_Template {

    public function action_index() {
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
		$parameters = '';
		$contents = array();
		
		$appointments_obj = new Model_Appointments();
		$categories_obj = new Model_Categories();
		$doctors_obj = new Model_Doctors();
		
		$doctors = $doctors_obj->get_all();
		
		$catid = Arr::get($_GET, 'cat'); // Получение параметра cat из адресной строки
		$docid = Arr::get($_GET, 'doctor'); // Получение параметра doctor из адресной строки
		
        $content = View::factory('admin/appointments')
				->bind('parameters', $parameters)
				->bind('cat_name', $cat_name)
				->bind('categories_form', $categories_form)
                ->bind('parent', $catid)
                ->bind('group_cat', $group_cat)
				->bind('errors', $errors)
                ->bind('post', $validation)
				->bind('doctors', $doctors)
                ->bind('contents', $contents);
				
		$group_cat = Kohana::$config->load('menu.group_cat');
        foreach ($group_cat as $group) {
            if ($group['dictionary_id'] == 1) {
                $result = $categories_obj->getCategories($group['dictionary_id'], 0, 2);
                if ($result) {
                    foreach ($result as $item) {
                        $cats[$item['id']] = array(
                            'name' => $item['descriptions'][1]['title'],
                        );
                        $cats2[] = array(
                            'id' => $item['id'],
                            'name' => $item['descriptions'][1]['title'],
                        );
                    }
                }
            }
        }
		if ($catid) {
			$contents = $appointments_obj->get_all_to_cat($catid, 0, 100, 'a.weight, a.date DESC', 0, 1);		
		
			if (isset($cats2[0]['name'])) {
				$cat_name = "Заявки - " . $cats[$catid]['name'];
			} else {
				$cat_name = "В данной категории нет заявок";
			}
			if (count($contents) < 1) {
				$cat_name = "В данной категории нет заявок";
			}
			
			$parameters .= '?cat='.$catid;
			
		} else {
			$contents = $appointments_obj->get_all(1);
			
			$cat_name = "Заявки";
			if (count($contents) < 1) {
				$cat_name = "Нет заявок";
			}
		}
        $this->template->content = $content;
    }
	
    public function action_add() {
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
		
		$appointments_obj = new Model_Appointments();
		$doctors_obj = new Model_Doctors();
		
        if (isset($_POST['name'])) {
            $validation = Validation::factory($_POST);
            $validation->rule('name', 'not_empty');
            $validation->rule('name', 'min_length', array(':value', '2'));
            $validation->rule('name', 'max_length', array(':value', '128'));
            $validation->labels(array('name' => $this->lang['text_name']));
			
            if ($validation->check()) {
			
                $add_data = array(
					'category_id' => Arr::get($_POST, 'category_id', 0),
                    'doctor_id' => Arr::get($_POST, 'doctor_id', 0),
					'date' => Arr::get($_POST, 'date', ''),
					'name' => Arr::get($_POST, 'name', ''),
					'time' => Arr::get($_POST, 'time', ''),
					'contact' => Arr::get($_POST, 'contact', ''),
                    'weight' => Arr::get($_POST, 'weight', 0),
                    'status' => Arr::get($_POST, 'status', 0),
                );
                
                $result = $appointments_obj->add($add_data);
                if ($result) {
                    Request::initial()->redirect('admin/appointments');
                }
            }
            $errors = $validation->errors('validation');
        }
		$doctors = $doctors_obj->get_all();
        $this->template->content = View::factory('admin/appointments-add')
                ->bind('errors', $errors)
				->bind('doctors', $doctors)
                ->bind('post', $validation);
    }
	
    public function action_edit() {
	
        $Id = $this->request->param('id');
		
        $appointments_obj = new Model_Appointments();
		$doctors_obj = new Model_Doctors();
		
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
		
        if (isset($_POST['name'])) {
            $validation = Validation::factory($_POST);
            $validation->rule('name', 'not_empty');
            $validation->rule('name', 'min_length', array(':value', '2'));
            $validation->rule('name', 'max_length', array(':value', '128'));
            $validation->labels(array('name' => $this->lang['text_name']));
			
            if ($validation->check()) {
			
                $edit_data = array(
					'category_id' => Arr::get($_POST, 'category_id', 0),
                    'doctor_id' => Arr::get($_POST, 'doctor_id', 0),
					'date' => Arr::get($_POST, 'date', ''),
					'name' => Arr::get($_POST, 'name', ''),
					'time' => Arr::get($_POST, 'time', ''),
					'contact' => Arr::get($_POST, 'contact', ''),
                    'weight' => Arr::get($_POST, 'weight', 0),
                    'status' => Arr::get($_POST, 'status', 0),
                );
				
                $result = $appointments_obj->edit($Id, $edit_data);
                if ($result) {
                    Request::initial()->redirect('admin/appointments'.$this->parameters);
                }
            }
            $errors = $validation->errors('validation');
        }
        $data['content'] = $appointments_obj->get_content($Id);
		$doctors = $doctors_obj->get_all();
        $this->template->content = View::factory('admin/appointments-edit', $data)
                ->bind('errors', $errors)
				->bind('doctors', $doctors)
                ->bind('post', $validation);
    }
	
    public function action_delete() {
        $Id = $this->request->param('id');
        $appointments_obj = new Model_Appointments();
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
        if (isset($_POST['delete'])) {
            $result = $appointments_obj->delete($Id);
            if ($result) {
                Request::initial()->redirect('admin/appointments'.$this->parameters);
            }
        }		
        $data['content'] = $appointments_obj->get_content($Id);
        $this->template->content = View::factory('admin/appointments-delete', $data);
    }
	
    public function unique_url($url) {
        return !DB::select(array(DB::expr('COUNT(alias)'), 'total'))
                        ->from('appointments')
                        ->where('alias', '=', $url)
                        ->execute()
                        ->get('total');
    }
}
// End Controller_Admin_appointments