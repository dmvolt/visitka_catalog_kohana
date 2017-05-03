<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Projects extends Controller_Template {

    public function action_project() {
        $alias = $this->request->param('alias');
        $content = View::factory($this->template_directory . 'project')
				->bind('edit_interface', $edit_interface)
                ->bind('project', $project);
        $projects_obj = new Model_Projects();
        $project = $projects_obj->get_content($alias);
		
		if($project){
			$edit_interface = Liteedit::get_interface($project['id'], 'projects');
			$this->page_title = $project['descriptions'][$this->lang_id]['title'];
			
			/****************************** SEO ******************************/	
			$seo_obj = new Model_Seo();
			$seo = $seo_obj->get_seo_to_content($project['id'], 'projects');
			
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
	
    public function action_projects() {
        $alias = $this->request->param('cat');
        $projects_obj = new Model_Projects();
        $categories_obj = new Model_Categories();
		$seo_obj = new Model_Seo();
	
		if($alias){		
			$catpage = $categories_obj->getCategory(0, $alias);						  
			$projects = $projects_obj->get_all_to_cat($catpage[0]['id']);
			$this->page_title = $catpage[0]['descriptions'][$this->lang_id]['title'];
		} else {
			$projects = $projects_obj->get_all();
			$this->page_title = 'Проекты';
			$modulinfo = Modulinfo::get_block('projects');
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
		$this->page_footer = '<div class="footer-parallax"></div>';
		
		$content = View::factory($this->template_directory . 'projects')
					->bind('modulinfo', $modulinfo)
					->bind('projects', $projects);
					
        $this->template->content = $content;
    }
}
// Projects