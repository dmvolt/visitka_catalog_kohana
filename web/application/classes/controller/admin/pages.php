<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Pages extends Controller_Admin_Template {

    public function action_index() {
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
        $content = View::factory('admin/pages')
                ->bind('contents', $contents);
        $pages_obj = new Model_Pages();
        $contents = $pages_obj->get_all(1);
        $this->template->content = $content;
    }
	
    public function action_add() {
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
            $validation->rule('alias', array($this, 'unique_url'));
            $validation->labels(array('title' => $this->lang['text_name'], 'alias' => $this->lang['text_alias']));
			
            if ($validation->check()) {
                $add_data = array(
                    'descriptions' => Arr::get($_POST, 'descriptions', array()),                  
                    'alias' => Arr::get($_POST, 'alias', ''),                   
                    'weight' => Arr::get($_POST, 'weight', 0),
                    'status' => Arr::get($_POST, 'status', 0),
					'in_front' => Arr::get($_POST, 'in_front', 0),
                );
                $pages_obj = new Model_Pages();
                $Id = $pages_obj->add($add_data);
                if ($Id) {	
					/********************* Операции с модулями ********************/
					Controller_Admin_Files::set_fields($Id, $_POST, 'pages');
					Controller_Admin_Seo::set_fields($Id, $_POST, 'pages');
					/***********************************************************/				
                    Request::initial()->redirect('admin/pages');
                }
            } 
			$errors = $validation->errors('validation');
        }
		
		/********************* Операции с модулями ********************/
        $data['files_form'] = Controller_Admin_Files::get_fields(array(), 'pages');
		$data['seo_form'] = Controller_Admin_Seo::get_fields(array(), 'pages');
		/***********************************************************/
		
        $this->template->content = View::factory('admin/page-add', $data)->bind('errors', $errors)->bind('post', $validation);
    }
    public function action_edit() {
        $Id = $this->request->param('id');
        $pages_obj = new Model_Pages();
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
                    'status' => Arr::get($_POST, 'status', 0),
					'in_front' => Arr::get($_POST, 'in_front', 0),
                );
                $result = $pages_obj->edit($Id, $edit_data);
                if ($result) {
					
					/********************* Операции с модулями ********************/
					Controller_Admin_Files::set_fields($Id, $_POST, 'pages');
					Controller_Admin_Seo::set_fields($Id, $_POST, 'pages');
					/***********************************************************/
					
                    Request::initial()->redirect('admin/pages');
                } $errors = $validation->errors('validation');
            }
        }
        $data['content'] = $pages_obj->get_content($Id);
		/********************* Операции с модулями ********************/
        $data['files_form'] = Controller_Admin_Files::get_fields($data['content'], 'pages');
		$data['seo_form'] = Controller_Admin_Seo::get_fields($data['content'], 'pages');
		/***********************************************************/
        $this->template->content = View::factory('admin/page-edit', $data)->bind('errors', $errors)->bind('post', $validation);
    }
    public function action_delete() {
        $Id = $this->request->param('id');
        $pages_obj = new Model_Pages();
		$file_obj = new Model_File();
		$seo_obj = new Model_Seo();
        $menu_obj = new Model_Menu();
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
        if (isset($_POST['delete'])) {
            $result = $pages_obj->delete($Id);
            if ($result) {
				/********************* Операции с модулями ********************/
				$file_obj->delete_files_by_content($Id, 'pages');
                $menu_obj->delete_to_content_id($Id, 'pages');
				$seo_obj->delete_by_content($Id, 'pages');
				/***********************************************************/
                Request::initial()->redirect('admin/pages');
            }
        }
        $data['content'] = $pages_obj->get_content($Id);
        $this->template->content = View::factory('admin/page-delete', $data);
    }
    public function unique_url($url) {
        return !DB::select(array(DB::expr('COUNT(alias)'), 'total'))->from('pages')->where('alias', '=', $url)->execute()->get('total');
    }
}