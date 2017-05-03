<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Services extends Controller_Template {

    public function action_service() {
        $alias = $this->request->param('alias');
        $content = View::factory($this->template_directory . 'service')
				->bind('edit_interface', $edit_interface)
                ->bind('service', $service);
        $services_obj = new Model_Services();
        $service = $services_obj->get_content($alias);
		
		if($service){
			$edit_interface = Liteedit::get_interface($service['id'], 'services');
			$this->page_title = $service['descriptions'][$this->lang_id]['title'];
			
			/****************************** SEO ******************************/	
			$seo_obj = new Model_Seo();
			$seo = $seo_obj->get_seo_to_content($service['id'], 'services');
			
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
	
    public function action_services() {
        $alias = $this->request->param('cat');
        $services_obj = new Model_Services();
        $categories_obj = new Model_Categories();
		$seo_obj = new Model_Seo();
	
		if($alias){		
			$catpage = $categories_obj->getCategory(0, $alias);						  
			$services = $services_obj->get_all_to_cat($catpage[0]['id']);
			$this->page_title = $catpage[0]['descriptions'][$this->lang_id]['title'];
		} else {
			$services = $services_obj->get_all();
			$this->page_title = 'Услуги';
			$modulinfo = Modulinfo::get_block('services');
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
		
		$content = View::factory($this->template_directory . 'services')
					->bind('modulinfo', $modulinfo)
					->bind('services', $services);
					
        $this->template->content = $content;
    }
}
// Services