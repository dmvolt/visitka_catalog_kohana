<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Kohana user guide and api browser.
 *
 * @package    Kohana/Userguide
 * @category   Controllers
 * @author     Kohana Team
 */
class Controller_Admin_Faq extends Controller_Admin_Template {

    public function action_index() {
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
		$parameters = '';
		$contents = array();
		
		$faq_obj = new Model_Faq();
		$categories_obj = new Model_Categories();
		//$doctors_obj = new Model_Doctors();
		
		$catid = Arr::get($_GET, 'cat'); // Получение параметра cat из адресной строки
		
		if (isset($_POST['descriptions'][1]['title'])) {
		
            $v_data = array(
				'descriptions' => $_POST['descriptions'], 
				'title' => $_POST['descriptions'][1]['title']
			);
			
            $validation = Validation::factory($v_data);
            $validation->rule('title', 'not_empty');
            $validation->rule('title', 'min_length', array(':value', '2'));
            $validation->rule('title', 'max_length', array(':value', '128'));
            $validation->labels(array('title' => $this->lang['text_name']));
			
            if ($validation->check()) {
                $add_data = array(
                    'descriptions' => Arr::get($_POST, 'descriptions', array()),
					'parent_id' => Arr::get($_POST, 'parent_id', 0),
                    'group_id' => Arr::get($_POST, 'group_id', 1),
					'doctor_id' => Arr::get($_POST, 'doctor_id', 0),
					'contact' => Arr::get($_POST, 'contact', ''),
					'date' => Arr::get($_POST, 'date', ''),
                    'weight' => Arr::get($_POST, 'weight', 0),
                    'status' => Arr::get($_POST, 'status', 1),
                );
				
                $new_content_id = $faq_obj->add($add_data);
                if ($new_content_id) {
					/********************* Операции с модулями ********************/
					//Controller_Admin_Categories::set_fields($new_content_id, $_POST, 'faq');
					/***********************************************************/
                    Request::initial()->redirect('admin/faq'.$this->parameters);
                }
            }
            $errors = $validation->errors('validation');
        }
		
		/********************* Операции с модулями ********************/
		//$categories_form = Controller_Admin_Categories::get_fields(array(), 'faq');	
		/***********************************************************/
		
		$group_faq = Kohana::$config->load('faq.group_faq');
        $content = View::factory('admin/faq')
				->bind('parameters', $parameters)
				->bind('group_faq', $group_faq)
				->bind('cat_name', $cat_name)
				->bind('categories_form', $categories_form)
                ->bind('parent', $catid)
                ->bind('group_cat', $group_cat)
				->bind('errors', $errors)
				->bind('doctors', $doctors)
                ->bind('post', $validation)
                ->bind('contents', $contents);
				
		//$doctors = $doctors_obj->get_all();
				
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
			$parent = $faq_obj->get_all_to_cat($catid, 0, 100, 'a.weight, a.date DESC', 0, 1);		
			if(!empty($parent)){
				foreach($parent as $value){
					$childs = $faq_obj->get_childs($value['id'], 1);
					$contents[] = array(
						'id' => $value['id'],
						'parent_id' => $value['parent_id'],
						'date' => $value['date'],
						'doctor_id' => $value['doctor_id'],
						'contact' => $value['contact'],
						'group_id' => $value['group_id'],
						'descriptions' => $value['descriptions'],
						'weight' => $value['weight'],
						'status' => $value['status'],
						'answer' => $childs,
					);
				}
			}
		
			if (isset($cats2[0]['name'])) {
				$cat_name = "Отзывы - " . $cats[$catid]['name'];
			} else {
				$cat_name = "В данной категории нет материалов";
			}
			if (count($contents) < 1) {
				$cat_name = "В данной категории нет материалов";
			}
			
			$parameters .= '?cat='.$catid;
			
		} else {
			$parent = $faq_obj->get_all(1);
			if(!empty($parent)){
				foreach($parent as $value){
					$childs = $faq_obj->get_childs($value['id'], 1);
					$contents[] = array(
						'id' => $value['id'],
						'parent_id' => $value['parent_id'],
						'date' => $value['date'],
						'group_id' => $value['group_id'],
						'doctor_id' => $value['doctor_id'],
						'contact' => $value['contact'],
						'descriptions' => $value['descriptions'],
						'weight' => $value['weight'],
						'status' => $value['status'],
						'answer' => $childs,
					);
				}
			}
			$cat_name = "Вопросы и ответы";
			if (count($contents) < 1) {
				$cat_name = "Нет материалов";
			}
		}
        $this->template->content = $content;
    }
	
    public function action_add() {
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
        if (isset($_POST['descriptions'][1]['title'])) {
            $v_data = array(
				'descriptions' => $_POST['descriptions'], 
				'title' => $_POST['descriptions'][1]['title']
			);
            $validation = Validation::factory($v_data);
            $validation->rule('title', 'not_empty');
            $validation->rule('title', 'min_length', array(':value', '2'));
            $validation->rule('title', 'max_length', array(':value', '128'));
            $validation->labels(array('title' => $this->lang['text_name']));
            if ($validation->check()) {
                $add_data = array(
                    'descriptions' => Arr::get($_POST, 'descriptions', array()),
                    'group_id' => Arr::get($_POST, 'group_id', 1),
					'doctor_id' => Arr::get($_POST, 'doctor_id', 0),
					'date' => Arr::get($_POST, 'date', ''),
                    'weight' => Arr::get($_POST, 'weight', 0),
                    'status' => Arr::get($_POST, 'status', 0),
                );
                $faq_obj = new Model_Faq();
                $result = $faq_obj->add($add_data);
                if ($result) {
                    Request::initial()->redirect('admin/faq');
                }
            }
            $errors = $validation->errors('validation');
        }
        $this->template->content = View::factory('admin/faq-add')
                ->bind('errors', $errors)
                ->bind('post', $validation);
    }
	
    public function action_edit() {
	
        $Id = $this->request->param('id');
		
        $faq_obj = new Model_Faq();
		//$doctors_obj = new Model_Doctors();
		
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
		
        if (isset($_POST['descriptions'][1]['title'])) {
            $v_data = array(
				'descriptions' => $_POST['descriptions'], 
				'title' => $_POST['descriptions'][1]['title']
			);
            $validation = Validation::factory($v_data);
            $validation->rule('title', 'not_empty');
            $validation->rule('title', 'min_length', array(':value', '2'));
            $validation->rule('title', 'max_length', array(':value', '128'));
            $validation->labels(array('title' => $this->lang['text_name']));
            if ($validation->check()) {
                $edit_data = array(
                    'descriptions' => Arr::get($_POST, 'descriptions', array()),
					'group_id' => Arr::get($_POST, 'group_id', 1),
					'doctor_id' => Arr::get($_POST, 'doctor_id', 0),
                    'date' => Arr::get($_POST, 'date', ''),
                    'weight' => Arr::get($_POST, 'weight', 0),
                    'status' => Arr::get($_POST, 'status', 0),
                );
				
                $result = $faq_obj->edit($Id, $edit_data);
                if ($result) {
					/********************* Операции с модулями ********************/
					//Controller_Admin_Files::set_fields($Id, $_POST, 'faq');
					//Controller_Admin_Categories::set_fields($Id, $_POST, 'faq');
					/***********************************************************/
                    Request::initial()->redirect('admin/faq'.$this->parameters);
                }
            }
            $errors = $validation->errors('validation');
        }
        $data['content'] = $faq_obj->get_content($Id);
		//$doctors = $doctors_obj->get_all();
		
		/********************* Операции с модулями ********************/
		//$data['files_form'] = Controller_Admin_Files::get_fields($data['content'], 'faq');
		//$data['categories_form'] = Controller_Admin_Categories::get_fields($data['content'], 'faq');		
		/***********************************************************/
        $this->template->content = View::factory('admin/faq-edit', $data)
                ->bind('errors', $errors)
				->bind('doctors', $doctors)
                ->bind('post', $validation);
    }
	
    public function action_delete() {
        $Id = $this->request->param('id');
        $faq_obj = new Model_Faq();
		//$categories_obj = new Model_Categories();
		//$file_obj = new Model_File();
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
        if (isset($_POST['delete'])) {
			$childs = $faq_obj->get_childs($Id, 1);
            $result = $faq_obj->delete($Id);
            if ($result) {
				/********************* Операции с модулями ********************/
				//$file_obj->delete_files_by_content($Id, 'faq');
				//$categories_obj->delete_category_by_content($Id, 'faq');
				/***********************************************************/
				if($childs){
					foreach($childs as $value){
						$result2 = $faq_obj->delete($value['id']);
						if ($result2) {
							/********************* Операции с модулями ********************/
							//$file_obj->delete_files_by_content($Id, 'faq');
							//$categories_obj->delete_category_by_content($value['id'], 'faq');
							/***********************************************************/
						}
					}
				}
                Request::initial()->redirect('admin/faq'.$this->parameters);
            }
        }		
        $data['content'] = $faq_obj->get_content($Id);
        $this->template->content = View::factory('admin/faq-delete', $data);
    }
	
    public function unique_url($url) {
        return !DB::select(array(DB::expr('COUNT(alias)'), 'total'))
                        ->from('faq')
                        ->where('alias', '=', $url)
                        ->execute()
                        ->get('total');
    }
}
// End Controller_Admin_faq