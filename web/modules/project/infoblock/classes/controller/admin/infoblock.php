<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Kohana user guide and api browser.
 *
 * @package    Kohana/Userguide
 * @category   Controllers
 * @author     Kohana Team
 */
class Controller_Admin_Infoblock extends Controller_Admin_Template {

    public function action_index() {
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
		
		$infoblock_obj = new Model_Infoblock();
		
        $content = View::factory('admin/infoblock')
                ->bind('contents', $contents);

		$contents = $infoblock_obj->get_all(1, 0, 100, 'a.weight');

        $this->template->content = $content;
    }

    public function action_add() {
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
		
		$infoblock_obj = new Model_Infoblock();

        if (isset($_POST['descriptions'][1]['title'])) {
            $v_data = array('descriptions' => $_POST['descriptions'], 'title' => $_POST['descriptions'][1]['title']);
            $validation = Validation::factory($v_data);
            $validation->rule('title', 'not_empty');
            $validation->rule('title', 'min_length', array(':value', '2'));
            $validation->rule('title', 'max_length', array(':value', '128'));

            $validation->labels(array('title' => $this->lang['text_name']));

            if ($validation->check()) {
                $add_data = array(
                    'descriptions' => Arr::get($_POST, 'descriptions', array()),
					'date' => Arr::get($_POST, 'date', ''),
                    'weight' => Arr::get($_POST, 'weight', 0),
					'url' => Arr::get($_POST, 'url', ''),
					'type' => Arr::get($_POST, 'type', 1),
                    'status' => Arr::get($_POST, 'status', 0),
                );

                $new_content_id = $infoblock_obj->add($add_data);

                if ($new_content_id) {
					
					/********************* Операции с модулями ********************/
					Controller_Admin_Files::set_fields($new_content_id, $_POST, 'infoblock');
					/***********************************************************/
					
                    Request::initial()->redirect('admin/infoblock');
                }
            }
            $errors = $validation->errors('validation');
        }
		
		/********************* Операции с модулями ********************/
        $data['files_form'] = Controller_Admin_Files::get_fields(array(), 'infoblock');	
		/***********************************************************/		

        $this->template->content = View::factory('admin/infoblock-add', $data)
                ->bind('errors', $errors)
                ->bind('post', $validation);
    }

    public function action_edit() {
        $Id = $this->request->param('id');

        $infoblock_obj = new Model_Infoblock();

        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);

        if (isset($_POST['descriptions'][1]['title'])) {
            $v_data = array('descriptions' => $_POST['descriptions'], 'title' => $_POST['descriptions'][1]['title']);
            $validation = Validation::factory($v_data);
            $validation->rule('title', 'not_empty');
            $validation->rule('title', 'min_length', array(':value', '2'));
            $validation->rule('title', 'max_length', array(':value', '128'));

            $validation->labels(array('title' => $this->lang['text_name']));

            if ($validation->check()) {
                
                $edit_data = array(
                    'descriptions' => Arr::get($_POST, 'descriptions', array()), 
					'date' => Arr::get($_POST, 'date', ''),
                    'weight' => Arr::get($_POST, 'weight', 0),
					'url' => Arr::get($_POST, 'url', ''),
					'type' => Arr::get($_POST, 'type', 1),
                    'status' => Arr::get($_POST, 'status', 0),
                );
               
                $result = $infoblock_obj->edit($Id, $edit_data);

                if ($result) {
				
					/********************* Операции с модулями ********************/
					Controller_Admin_Files::set_fields($Id, $_POST, 'infoblock');
					/***********************************************************/
					
                    Request::initial()->redirect('admin/infoblock');
                }
            }
            $errors = $validation->errors('validation');
        }
        $data['content'] = $infoblock_obj->get_content($Id);
		
		/********************* Операции с модулями ********************/		
        $data['files_form'] = Controller_Admin_Files::get_fields($data['content'], 'infoblock');
		/***********************************************************/

        $this->template->content = View::factory('admin/infoblock-edit', $data)
                ->bind('errors', $errors)
                ->bind('post', $validation);
    }

    public function action_delete() {
        $Id = $this->request->param('id');
        $infoblock_obj = new Model_Infoblock();
		$file_obj = new Model_File();

        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);

        if (isset($_POST['delete'])) {
            $result = $infoblock_obj->delete($Id);
			
			/********************* Операции с модулями *****************/
			$file_obj->delete_files_by_content($Id, 'infoblock');
			/***********************************************************/
		
            if ($result) {
                Request::initial()->redirect('admin/infoblock');
            }
        }
        $data['content'] = $infoblock_obj->get_content($Id);
        $this->template->content = View::factory('admin/infoblock-delete', $data);
    }
}
// End Controller_Admin_Infoblock
