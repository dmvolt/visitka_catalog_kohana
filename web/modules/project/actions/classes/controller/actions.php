<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Actions extends Controller_Template {

    public function action_action() {
        $alias = $this->request->param('alias');
        $content = View::factory($this->template_directory . 'action')
				->bind('edit_interface', $edit_interface)
                ->bind('action', $action);
        $actions_obj = new Model_Actions();
        $action = $actions_obj->get_content($alias);
		
		if($action){
			$edit_interface = Liteedit::get_interface($action['id'], 'actions');
			$this->page_title = $action['descriptions'][$this->lang_id]['title'];
			
			/****************************** SEO ******************************/	
			$seo_obj = new Model_Seo();
			$seo = $seo_obj->get_seo_to_content($action['id'], 'actions');
			
			if($seo[$this->lang_id]['title'] != ''){
				$this->page_title = $seo[$this->lang_id]['title'];
			}
			
			$this->meta_description = $seo[$this->lang_id]['meta_d'];
			$this->meta_keywords = $seo[$this->lang_id]['meta_k'];
			/****************************** /SEO *****************************/
			
			$this->page_class = '';
			$this->page_footer = '';
			$this->template->content = $content;
			
		} else {

			$this->auto_render = false; //не использовать главный шаблон вида "template"
			// Выполняем запрос, обращаясь к роутеру для обработки ошибок
			$attributes = array(
				'code'  => 404, // Ошибка по умолчанию
				'message' => 'Страница не найдена или не существует!'
			);
			echo Request::factory(Route::get('error')->uri($attributes))
				->execute()
				->send_headers()
				->body();
			$this->response->status(404);
			return;
		}
    }
	
    public function action_actions() {
        $alias = $this->request->param('cat');
        $actions_obj = new Model_Actions();
        $categories_obj = new Model_Categories();
		$seo_obj = new Model_Seo();
	
		if($alias){		
			$catpage = $categories_obj->getCategory(0, $alias);						  
			$actions = $actions_obj->get_all_to_cat($catpage[0]['id']);
			$this->page_title = $catpage[0]['descriptions'][$this->lang_id]['title'];
		} else {
			$actions = $actions_obj->get_all();
			$this->page_title = 'Специальные предложения';
			$modulinfo = Modulinfo::get_block('actions');
			if(!empty($modulinfo)){
				/****************************** SEO ******************************/	
				$seo = $seo_obj->get_seo_to_content($modulinfo[0]['id'], 'modulinfo');
				
				if($seo[$this->lang_id]['title'] != ''){
					$this->page_title = $seo[$this->lang_id]['title'];
				}
				
				$this->meta_description = $seo[$this->lang_id]['meta_d'];
				$this->meta_keywords = $seo[$this->lang_id]['meta_k'];
				/****************************** /SEO *****************************/
			}
		}
		
		$this->page_class = '';
		$this->page_footer = '';
		
		$content = View::factory($this->template_directory . 'actions')
					->bind('modulinfo', $modulinfo)
					->bind('actions', $actions);
					
        $this->template->content = $content;
    }
}
// Actions