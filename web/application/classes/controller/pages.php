<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Pages extends Controller_Template {

    public function action_page() {
        $alias = $this->request->param('page'); // Получение параметра page из адресной строки

        $content = View::factory($this->template_directory . 'pages')
				->bind('edit_interface', $edit_interface)
                ->bind('page', $page);

        $pages_obj = new Model_Pages();  // Создание экземпляра объекта модели
        $page = $pages_obj->get_content($alias); // Создание экземпляра объекта модели с выборкой из метода
		
		if($page){
			$edit_interface = Liteedit::get_interface($page['id']);
			$this->page_title = $page['descriptions'][$this->lang_id]['title'];
			/****************************** SEO ******************************/	
			$seo_obj = new Model_Seo();
			$seo = $seo_obj->get_seo_to_content($page['id'], 'pages');

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
}
// End Pages