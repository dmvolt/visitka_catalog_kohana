<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Kohana user guide and api browser.
 *
 * @package    Kohana/Userguide
 * @category   Controllers
 * @author     Kohana Team
 */
 
class Controller_Admin_Documents extends Controller_Admin_Template {

    public function action_index() {
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
		
		$documents_obj = new Model_Documents();
		$categories_obj = new Model_Categories();
		
		$catid = Arr::get($_GET, 'cat'); // Получение параметра cat из адресной строки
		
        $content = View::factory('admin/documents')
				->bind('parameters', $parameters)
                ->bind('contents', $contents)
				->bind('pagination', $pagination)
                ->bind('pagination2', $pagination2)
				->bind('cat_name', $cat_name)
                ->bind('parent', $catid)
                ->bind('group_cat', $group_cat);
		
		if ($catid) {
			$total = $documents_obj->get_total($catid, 1);   // Получение общего количества записей
			$result = Pagination::start($total);
			$pagination = Pagination::admin_navigation($result['page'], $total, $result['total_page'], $result['num']);
			$pagination2 = Pagination::admin_navigation2($result['page'], $total, $result['total_page'], $result['num']);
			$contents = $documents_obj->get_all_to_cat($catid, $result['start'], $result['num'], 'a.weight', 1);

			$cat_name = "Документы - " . $cats[$catid]['name'];
			
		} else {
			$total = $documents_obj->get_total(0, 1);   // Получение общего количества записей
			$result = Pagination::start($total);
			$pagination = Pagination::admin_navigation($result['page'], $total, $result['total_page'], $result['num']);
			$pagination2 = Pagination::admin_navigation2($result['page'], $total, $result['total_page'], $result['num']);
			$contents = $documents_obj->get_all(1, $result['start'], $result['num'], 'a.weight');
			
			$cat_name = "Документы";
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
		
		$documents_obj = new Model_Documents();
        if (isset($_POST['descriptions'][1]['title'])) {
            $v_data = array('descriptions' => $_POST['descriptions'], 'title' => $_POST['descriptions'][1]['title'], 'alias' => $_POST['alias'], 'link' => $_POST['link']);
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
					'parent_id' => Arr::get($_POST, 'parent_id', 0),
					'date' => Arr::get($_POST, 'date', ''),	
					'link' => Arr::get($_POST, 'link', ''),					
                    'alias' => Arr::get($_POST, 'alias', ''),
                    'weight' => Arr::get($_POST, 'weight', 0),
					'is_fine' => Arr::get($_POST, 'is_fine', 0),
                    'status' => Arr::get($_POST, 'status', 0),
                );
                $new_content_id = $documents_obj->add($add_data);
                if ($new_content_id) {
					
					/********************* Операции с модулями ********************/
					Controller_Admin_Files::set_fields($new_content_id, $_POST, 'documents');
					Controller_Admin_Seo::set_fields($new_content_id, $_POST, 'documents');
					/***********************************************************/
					
                    Request::initial()->redirect('admin/documents'.$this->parameters);
                }
            }
            $errors = $validation->errors('validation');
        }
		$parent_content = $documents_obj->get_all_parent();
		/********************* Операции с модулями ********************/
        $data['files_form'] = Controller_Admin_Files::get_fields(array(), 'documents');
		$data['seo_form'] = Controller_Admin_Seo::get_fields(array(), 'documents');		
		/***********************************************************/		
        $this->template->content = View::factory('admin/documents-add', $data)
				->bind('parent_content', $parent_content)
                ->bind('errors', $errors)
                ->bind('post', $validation);
    }
	
    public function action_edit() {
        $Id = $this->request->param('id');
        $documents_obj = new Model_Documents();
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
        if (isset($_POST['descriptions'][1]['title'])) {
            $v_data = array('descriptions' => $_POST['descriptions'], 'title' => $_POST['descriptions'][1]['title'], 'alias' => $_POST['alias'], 'link' => $_POST['link']);
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
					'parent_id' => Arr::get($_POST, 'parent_id', 0),
					'date' => Arr::get($_POST, 'date', ''),	
					'link' => Arr::get($_POST, 'link', ''),
                    'alias' => Arr::get($_POST, 'alias', ''),
                    'weight' => Arr::get($_POST, 'weight', 0),
					'is_fine' => Arr::get($_POST, 'is_fine', 0),
                    'status' => Arr::get($_POST, 'status', 0),
                );
               
                $result = $documents_obj->edit($Id, $edit_data);
                if ($result) {
				
					/********************* Операции с модулями ********************/
					Controller_Admin_Files::set_fields($Id, $_POST, 'documents');
					Controller_Admin_Seo::set_fields($Id, $_POST, 'documents');
					/***********************************************************/
					
                    Request::initial()->redirect('admin/documents'.$this->parameters);
                }
            }
            $errors = $validation->errors('validation');
        }
        $data['content'] = $documents_obj->get_content($Id);
		$parent_content = $documents_obj->get_all_parent();
		/********************* Операции с модулями ********************/
        $data['files_form'] = Controller_Admin_Files::get_fields($data['content'], 'documents');
		$data['seo_form'] = Controller_Admin_Seo::get_fields($data['content'], 'documents');
		/***********************************************************/
        $this->template->content = View::factory('admin/documents-edit', $data)
				->bind('parent_content', $parent_content)
                ->bind('errors', $errors)
                ->bind('post', $validation);
    }
	
    public function action_delete() {
        $Id = $this->request->param('id');
        $documents_obj = new Model_Documents();
		$file_obj = new Model_File();
		$seo_obj = new Model_Seo();
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
        if (isset($_POST['delete'])) {
            $result = $documents_obj->delete($Id);
			
			/********************* Операции с модулями ********************/
			$seo_obj->delete_by_content($Id, 'documents');
			$file_obj->delete_files_by_content($Id, 'documents');
			/***********************************************************/
		
            if ($result) {
                Request::initial()->redirect('admin/documents'.$this->parameters);
            }
        }
        $data['content'] = $documents_obj->get_content($Id);
        $this->template->content = View::factory('admin/documents-delete', $data);
    }
	
    public function unique_url($url) {
        return !DB::select(array(DB::expr('COUNT(alias)'), 'total'))
                        ->from('documents')
                        ->where('alias', '=', $url)
                        ->execute()
                        ->get('total');
    }
}
// End Controller_Admin_News