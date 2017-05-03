<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Photos extends Controller_Template {

    public function action_photo() {
        $alias = $this->request->param('alias');
        $content = View::factory($this->template_directory . 'photo')
				->bind('edit_interface', $edit_interface)
                ->bind('article', $article);
        $photos_obj = new Model_Photos();
        $article = $photos_obj->get_content($alias);
		
		if($article){
			$edit_interface = Liteedit::get_interface($article['id'], 'photos');
			$this->page_title = $article['descriptions'][$this->lang_id]['title'];
			
			/****************************** SEO ******************************/	
			$seo_obj = new Model_Seo();
			$seo = $seo_obj->get_seo_to_content($article['id'], 'photos');
			
			if($seo[$this->lang_id]['title'] != ''){
				$this->page_title = $seo[$this->lang_id]['title'];
			}
			
			$this->meta_description = $seo[$this->lang_id]['meta_d'];
			$this->meta_keywords = $seo[$this->lang_id]['meta_k'];
			/****************************** /SEO *****************************/
		}

		$this->page_class = '';
		$this->page_footer = '';
        $this->template->content = $content;
    }
	
    public function action_photos() {
        $alias = $this->request->param('cat');
        $photos_obj = new Model_Photos();
        $categories_obj = new Model_Categories();
		$seo_obj = new Model_Seo();
		
		$t = Arr::get($_GET, 't', 'photo');
		
		$is_photo = true;
		$is_video = false;
		
		if($t == 'video'){
			$is_photo = false;
			$is_video = true;
		}
	
		if($alias){		
			$catpage = $categories_obj->getCategory(0, $alias);						  
			$photos = $photos_obj->get_all_to_cat($catpage[0]['id']);
			$this->page_title = $catpage[0]['descriptions'][$this->lang_id]['title'];
		} else {
			$photos = $photos_obj->get_all();
			$this->page_title = 'Фотогалерея';
			$modulinfo = Modulinfo::get_block('photos');
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
		
		$content = View::factory($this->template_directory . 'photos')
					->bind('modulinfo', $modulinfo)
					->bind('is_photo', $is_photo)
					->bind('is_video', $is_video)
					->bind('photos', $photos);
					
        $this->template->content = $content;
    }
}
// Photos