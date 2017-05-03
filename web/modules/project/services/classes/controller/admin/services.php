<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Kohana user guide and api browser.
 *
 * @package    Kohana/Userguide
 * @category   Controllers
 * @author     Kohana Team
 */
 
class Controller_Admin_Services extends Controller_Admin_Template {

    public function action_index() {
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
		
		$services_obj = new Model_Services();
		$categories_obj = new Model_Categories();
		
		$catid = Arr::get($_GET, 'cat'); // Получение параметра cat из адресной строки
		
        $content = View::factory('admin/services')
				->bind('parameters', $parameters)
                ->bind('contents', $contents)
				->bind('pagination', $pagination)
                ->bind('pagination2', $pagination2)
				->bind('cat_name', $cat_name)
                ->bind('parent', $catid)
                ->bind('group_cat', $group_cat);
		
		$group_cat = Kohana::$config->load('menu.group_cat');
        foreach ($group_cat as $group) {
            if ($group['dictionary_id'] == 1) {
                $result = $categories_obj->getCategories($group['dictionary_id'], 0, 2);
                if ($result) {
                    foreach ($result as $item) {
                        $cats[$item['id']] = array(
                            'name' => $item['descriptions'][1]['title'],
                        );
                    }
                }
            }
        }
		
		if ($catid) {
			$total = $services_obj->get_total($catid, 1);   // Получение общего количества записей
			$result = Pagination::start($total);
			$pagination = Pagination::admin_navigation($result['page'], $total, $result['total_page'], $result['num']);
			$pagination2 = Pagination::admin_navigation2($result['page'], $total, $result['total_page'], $result['num']);
			$contents = $services_obj->get_all_to_cat($catid, $result['start'], $result['num'], 'a.weight', 1);

			$cat_name = "Услуги - " . $cats[$catid]['name'];
			
		} else {
			$total = $services_obj->get_total(0, 1);   // Получение общего количества записей
			$result = Pagination::start($total);
			$pagination = Pagination::admin_navigation($result['page'], $total, $result['total_page'], $result['num']);
			$pagination2 = Pagination::admin_navigation2($result['page'], $total, $result['total_page'], $result['num']);
			$contents = $services_obj->get_all(1, $result['start'], $result['num'], 'a.weight');
			
			$cat_name = "Услуги";
		}
		
		if (count($contents) < 1) {
			$cat_name = "В данной категории нет материалов";
		}
			
		$parameters = '';
        $i = 0;
        if($catid){
            $parameters .= ($i) ? '&cat='.$catid : '?cat='.$catid;
            $i++;
        }
        if($result['page']){
            $parameters .= ($i) ? '&page='.$result['page'] : '?page='.$result['page'];
            $i++;
        }
        $this->template->content = $content;
    }
	
    public function action_add() {
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
		
		$services_obj = new Model_Services();
        if (isset($_POST['descriptions'][1]['title'])) {
            $v_data = array('descriptions' => $_POST['descriptions'], 'title' => $_POST['descriptions'][1]['title'], 'alias' => $_POST['alias']);
            $validation = Validation::factory($v_data);
            $validation->rule('title', 'not_empty');
            $validation->rule('title', 'min_length', array(':value', '2'));
            $validation->rule('title', 'max_length', array(':value', '128'));
            $validation->rule('alias', 'not_empty');
            $validation->rule('alias', 'alpha_dash');
            $validation->rule('alias', 'max_length', array(':value', '128'));
            $validation->rule('alias', array($this, 'unique_url'));
            $validation->labels(array('title' => $this->lang['text_name'], 'alias' => $this->lang['text_alias']));
            if ($validation->check()) {
                $add_data = array(
                    'descriptions' => Arr::get($_POST, 'descriptions', array()),			
                    'alias' => Arr::get($_POST, 'alias', ''),
                    'weight' => Arr::get($_POST, 'weight', 0),
					'is_fine' => Arr::get($_POST, 'is_fine', 0),
                    'status' => Arr::get($_POST, 'status', 0),
                );
                $new_content_id = $services_obj->add($add_data);
                if ($new_content_id) {
					
					/********************* Операции с модулями ********************/
					//Controller_Admin_Categories::set_fields($new_content_id, $_POST, 'services');
					Controller_Admin_Files::set_fields($new_content_id, $_POST, 'services');
					Controller_Admin_Seo::set_fields($new_content_id, $_POST, 'services');
					/***********************************************************/
					
                    Request::initial()->redirect('admin/services'.$this->parameters);
                }
            }
            $errors = $validation->errors('validation');
        }
		
		/********************* Операции с модулями ********************/
		//$data['categories_form'] = Controller_Admin_Categories::get_fields(array(), 'services');
        $data['files_form'] = Controller_Admin_Files::get_fields(array(), 'services');
		$data['seo_form'] = Controller_Admin_Seo::get_fields(array(), 'services');		
		/***********************************************************/		
        $this->template->content = View::factory('admin/services-add', $data)
                ->bind('errors', $errors)
                ->bind('post', $validation);
    }
	
    public function action_edit() {
        $Id = $this->request->param('id');
        $services_obj = new Model_Services();
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
        if (isset($_POST['descriptions'][1]['title'])) {
            $v_data = array('descriptions' => $_POST['descriptions'], 'title' => $_POST['descriptions'][1]['title'], 'alias' => $_POST['alias']);
            $validation = Validation::factory($v_data);
            $validation->rule('title', 'not_empty');
            $validation->rule('title', 'min_length', array(':value', '2'));
            $validation->rule('title', 'max_length', array(':value', '128'));
            $validation->rule('alias', 'not_empty');
            $validation->rule('alias', 'alpha_dash');
            $validation->rule('alias', 'max_length', array(':value', '128'));
            $validation->labels(array('title' => $this->lang['text_name'], 'alias' => $this->lang['text_alias']));
            if ($validation->check()) {
                
                $edit_data = array(
                    'descriptions' => Arr::get($_POST, 'descriptions', array()), 					
                    'alias' => Arr::get($_POST, 'alias', ''),
                    'weight' => Arr::get($_POST, 'weight', 0),
					'is_fine' => Arr::get($_POST, 'is_fine', 0),
                    'status' => Arr::get($_POST, 'status', 0),
                );
               
                $result = $services_obj->edit($Id, $edit_data);
                if ($result) {
				
					/********************* Операции с модулями ********************/
					//Controller_Admin_Categories::set_fields($Id, $_POST, 'services');
					Controller_Admin_Files::set_fields($Id, $_POST, 'services');
					Controller_Admin_Seo::set_fields($Id, $_POST, 'services');
					/***********************************************************/
					
                    Request::initial()->redirect('admin/services'.$this->parameters);
                }
            }
            $errors = $validation->errors('validation');
        }
        $data['content'] = $services_obj->get_content($Id);
		
		/********************* Операции с модулями ********************/
		//$data['categories_form'] = Controller_Admin_Categories::get_fields($data['content'], 'services');
        $data['files_form'] = Controller_Admin_Files::get_fields($data['content'], 'services');
		$data['seo_form'] = Controller_Admin_Seo::get_fields($data['content'], 'services');
		/***********************************************************/
        $this->template->content = View::factory('admin/services-edit', $data)
                ->bind('errors', $errors)
                ->bind('post', $validation);
    }
	
    public function action_delete() {
        $Id = $this->request->param('id');
        $services_obj = new Model_Services();
		//$categories_obj = new Model_Categories();
		$file_obj = new Model_File();
		$seo_obj = new Model_Seo();
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
        if (isset($_POST['delete'])) {
            $result = $services_obj->delete($Id);
			
			/********************* Операции с модулями ********************/
			//$categories_obj->delete_category_by_content($Id, 'services');
			$seo_obj->delete_by_content($Id, 'services');
			$file_obj->delete_files_by_content($Id, 'services');
			/***********************************************************/
		
            if ($result) {
                Request::initial()->redirect('admin/services'.$this->parameters);
            }
        }
        $data['content'] = $services_obj->get_content($Id);
        $this->template->content = View::factory('admin/services-delete', $data);
    }
	
    public function unique_url($url) {
        return !DB::select(array(DB::expr('COUNT(alias)'), 'total'))
                        ->from('services')
                        ->where('alias', '=', $url)
                        ->execute()
                        ->get('total');
    }
}
// End Controller_Admin_News