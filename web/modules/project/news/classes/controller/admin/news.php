<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Kohana user guide and api browser.
 *
 * @package    Kohana/Userguide
 * @category   Controllers
 * @author     Kohana Team
 */
class Controller_Admin_News extends Controller_Admin_Template {

    public function action_index() {
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);

        $content = View::factory('admin/news')
				->bind('parameters', $this->parameters)
                ->bind('contents', $contents);

        $news_obj = new Model_News();
        $contents = $news_obj->get_all(1);

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
                    'date' => Arr::get($_POST, 'date', ''),
                    'alias' => Arr::get($_POST, 'alias', ''),
                    'weight' => Arr::get($_POST, 'weight', 0),
					'type' => Arr::get($_POST, 'type', 0),
                    'status' => Arr::get($_POST, 'status', 0),
                );

                $news_obj = new Model_News();
                $new_content_id = $news_obj->add($add_data);

                if ($new_content_id) {
					/********************* Операции с модулями ********************/
					Controller_Admin_Files::set_fields($new_content_id, $_POST, 'news');
					Controller_Admin_Seo::set_fields($new_content_id, $_POST, 'news');
					/***********************************************************/
                    Request::initial()->redirect('admin/news');
                }
            }
            $errors = $validation->errors('validation');
        }
		/********************* Операции с модулями ********************/
        $data['files_form'] = Controller_Admin_Files::get_fields(array(), 'news');	
		$data['seo_form'] = Controller_Admin_Seo::get_fields(array(), 'news');
		/***********************************************************/
        $this->template->content = View::factory('admin/news-add', $data)
                ->bind('errors', $errors)
                ->bind('post', $validation);
    }

    public function action_edit() {
        $Id = $this->request->param('id');
        $news_obj = new Model_News();

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
                    'date' => Arr::get($_POST, 'date', ''),
                    'alias' => Arr::get($_POST, 'alias', ''),
                    'weight' => Arr::get($_POST, 'weight', 0),
					'type' => Arr::get($_POST, 'type', 0),
                    'status' => Arr::get($_POST, 'status', 0),
                );
				
                $result = $news_obj->edit($Id, $edit_data);

                if ($result) {
					/********************* Операции с модулями ********************/
					Controller_Admin_Files::set_fields($Id, $_POST, 'news');
					Controller_Admin_Seo::set_fields($Id, $_POST, 'news');
					/***********************************************************/
                    Request::initial()->redirect('admin/news');
                }
            }
            $errors = $validation->errors('validation');
        }
        $data['content'] = $news_obj->get_content($Id);
		
		/********************* Операции с модулями ********************/
        $data['files_form'] = Controller_Admin_Files::get_fields($data['content'], 'news');	
		$data['seo_form'] = Controller_Admin_Seo::get_fields($data['content'], 'news');
		/***********************************************************/

        $this->template->content = View::factory('admin/news-edit', $data)
                ->bind('errors', $errors)
                ->bind('post', $validation);
    }

    public function action_delete() {
        $Id = $this->request->param('id');
        $news_obj = new Model_News();
		$file_obj = new Model_File();
		$seo_obj = new Model_Seo();

        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);

        if (isset($_POST['delete'])) {
            $result = $news_obj->delete($Id);
            if ($result) {
				/********************* Операции с модулями ********************/
				$file_obj->delete_files_by_content($Id, 'news');
				$seo_obj->delete_by_content($Id, 'news');
				/***********************************************************/
                Request::initial()->redirect('admin/news');
            }
        }		
        $data['content'] = $news_obj->get_content($Id);
        $this->template->content = View::factory('admin/news-delete', $data);
    }

    public function unique_url($url) {
        return !DB::select(array(DB::expr('COUNT(alias)'), 'total'))
                        ->from('news')
                        ->where('alias', '=', $url)
                        ->execute()
                        ->get('total');
    }
}
// End Controller_Admin_News
