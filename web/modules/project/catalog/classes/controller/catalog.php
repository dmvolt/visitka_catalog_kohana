<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Catalog extends Controller_Template {

    public function action_good() {
	
		$alias = $this->request->param('alias');
		$cat1 = $this->request->param('cat1');
		$cat2 = $this->request->param('cat2');
		
        $content = View::factory($this->template_directory . 'good')
				->bind('edit_interface', $edit_interface)
				->bind('cat1', $cat1)
				->bind('cat2', $cat2)
                ->bind('good', $good);
				
        $catalog_obj = new Model_Catalog();
        $good = $catalog_obj->get_content($alias);
		
		if($good){
			$edit_interface = Liteedit::get_interface($good['id'], 'catalog');
			$this->page_title = $good['descriptions'][$this->lang_id]['title'];
			
			/****************************** SEO ******************************/	
			$seo_obj = new Model_Seo();
			$seo = $seo_obj->get_seo_to_content($good['id'], 'catalog');
			
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
	
    public function action_catalog() {
	
        $cat1 = $this->request->param('cat1');
		$cat2 = $this->request->param('cat2');
		$cat3 = $this->request->param('cat3');
		
        $catalog_obj = new Model_Catalog();
        $categories_obj = new Model_Categories();
		
		if($cat1 AND !$cat2 AND !$cat3){
			
			$catpage = $categories_obj->getCategory(0, $cat1);	
			
			$categories = $categories_obj->getCategories(1, $catpage[0]['id'], 0);
			
			$total = $catalog_obj->get_total($catpage[0]['id']);   // Получение общего количества записей
			$result = Pagination::start($total);
			$pagination = Pagination::navigation($result['page'], $total, $result['total_page'], $result['num']);
			$catalog = $catalog_obj->get_all_to_cat($catpage[0]['id'], $result['start'], $result['num'], 'a.weight');
			
			$this->page_title = $catpage[0]['descriptions'][$this->lang_id]['title'];
			
			$content = View::factory($this->template_directory . 'catalog-catalog')
					->bind('modulinfo', $modulinfo)
					->bind('pagination', $pagination)
					->bind('cat1', $cat1)
					->bind('cat2', $cat2)
					->bind('cat3', $cat3)
					->bind('catpage', $catpage)
					->bind('categories', $categories)
					->bind('catalog', $catalog);
					
		} if($cat1 AND $cat2 AND !$cat3){
			
			$catpage = $categories_obj->getCategory(0, $cat2);	
			
			$categories = $categories_obj->getCategories(1, $catpage[0]['id'], 0);
			
			$total = $catalog_obj->get_total($catpage[0]['id']);   // Получение общего количества записей
			$result = Pagination::start($total);
			$pagination = Pagination::navigation($result['page'], $total, $result['total_page'], $result['num']);
			$catalog = $catalog_obj->get_all_to_cat($catpage[0]['id'], $result['start'], $result['num'], 'a.weight');
			
			$this->page_title = $catpage[0]['descriptions'][$this->lang_id]['title'];
			
			$content = View::factory($this->template_directory . 'catalog-catalog')
					->bind('modulinfo', $modulinfo)
					->bind('pagination', $pagination)
					->bind('cat1', $cat1)
					->bind('cat2', $cat2)
					->bind('cat3', $cat3)
					->bind('catpage', $catpage)
					->bind('categories', $categories)
					->bind('catalog', $catalog);
					
		} elseif($cat1 AND $cat2 AND $cat3){
		
			$catpage = $categories_obj->getCategory(0, $cat3);	
			
			$total = $catalog_obj->get_total($catpage[0]['id']);   // Получение общего количества записей
			$result = Pagination::start($total);
			$pagination = Pagination::navigation($result['page'], $total, $result['total_page'], $result['num']);
			$catalog = $catalog_obj->get_all_to_cat($catpage[0]['id'], $result['start'], $result['num'], 'a.weight');
			
			
			$catalog = $catalog_obj->get_all_to_cat($catpage[0]['id']);
			$this->page_title = $catpage[0]['descriptions'][$this->lang_id]['title'];
			
			$content = View::factory($this->template_directory . 'catalog-catalog')
					->bind('modulinfo', $modulinfo)
					->bind('pagination', $pagination)
					->bind('cat1', $cat1)
					->bind('cat2', $cat2)
					->bind('cat3', $cat3)
					->bind('catpage', $catpage)
					->bind('categories', $categories)
					->bind('catalog', $catalog);
			
		} elseif(!$cat1 AND !$cat2 AND !$cat3){
		
			$catalog = $categories_obj->getCategories(1, 0, 0);
			$this->page_title = 'Каталог продукции';
			
			$content = View::factory($this->template_directory . 'catalog')
					->bind('modulinfo', $modulinfo)
					->bind('catalog', $catalog);
		}
        $this->template->content = $content;
    }
}
// Catalog