<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Kohana user guide and api browser.
 *
 * @package    Kohana/Userguide
 * @category   Controllers
 * @author     Kohana Team
 */
class Controller_Admin_Banners extends Controller_Admin_Template {

    public function action_index() {
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);

        $content = View::factory('admin/banners')
                ->bind('contents', $contents);

        $banners_obj = new Model_Banners();
		
        $contents = $banners_obj->get_all(1);	
        $this->template->content = $content;
    }

    public function action_add() {
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
        
		$banners_obj = new Model_Banners();

        if (isset($_POST['title'])) {
            $add_data = array(
                'title' => Arr::get($_POST, 'title', ''),
                'display_pages' => Arr::get($_POST, 'display_pages', ''),
                'display_all' => Arr::get($_POST, 'display_all', 0),
                'status' => Arr::get($_POST, 'status', 0),
            );
           
            $new_banners_id = $banners_obj->add($add_data);

            if ($new_banners_id) {
				Controller_Admin_Files::set_fields($new_banners_id, $_POST, 'banners');
                Request::initial()->redirect('admin/banners');
            }
        }
        $data['files_form'] = Controller_Admin_Files::get_fields(array(), 'banners');
        $this->template->content = View::factory('admin/banners-add', $data);
    }

    public function action_edit() {
        $Id = $this->request->param('id');
        $banners_obj = new Model_Banners();
      
        $data['content'] = $banners_obj->get_content($Id);

        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);

        if (isset($_POST['title'])) {
            $edit_data = array(
                'title' => Arr::get($_POST, 'title', ''),
                'display_pages' => Arr::get($_POST, 'display_pages', ''),
                'display_all' => Arr::get($_POST, 'display_all', 0),
                'status' => Arr::get($_POST, 'status', 0),
            );

            $result = $banners_obj->edit($Id, $edit_data);

            if ($result) {
				Controller_Admin_Files::set_fields($Id, $_POST, 'banners');
                Request::initial()->redirect('admin/banners');
            }
        }
        $data['files_form'] = Controller_Admin_Files::get_fields($data['content'], 'banners');
        $this->template->content = View::factory('admin/banners-edit', $data);
    }

    public function action_delete() {
        $Id = $this->request->param('id');
        $banners_obj = new Model_Banners();
		$file_obj = new Model_File();

        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);

        if (isset($_POST['delete'])) {
            $result = $banners_obj->delete($Id);
			$file_obj->delete_files_by_content($Id, 'banners');
            if ($result) {
                Request::initial()->redirect('admin/banners');
            }
        }

        $data['content'] = $banners_obj->get_content($Id);
        $this->template->content = View::factory('admin/banners-delete', $data);
    }
}

// End Controller_Admin_Banners
