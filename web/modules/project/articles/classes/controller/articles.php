<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Articles extends Controller_Template {

    public function action_article() {
        $alias = $this->request->param('alias');
        $content = View::factory($this->template_directory . 'article')
				->bind('edit_interface', $edit_interface)
                ->bind('article', $article);
        $articles_obj = new Model_Articles();
        $article = $articles_obj->get_content($alias);
		
		if($article){
			$edit_interface = Liteedit::get_interface($article['id'], 'articles');
			$this->page_title = $article['descriptions'][$this->lang_id]['title'];
			
			/****************************** SEO ******************************/	
			$seo_obj = new Model_Seo();
			$seo = $seo_obj->get_seo_to_content($article['id'], 'articles');
			
			if($seo[$this->lang_id]['title'] != ''){
				$this->page_title = $seo[$this->lang_id]['title'];
			}
			
			$this->meta_description = $seo[$this->lang_id]['meta_d'];
			$this->meta_keywords = $seo[$this->lang_id]['meta_k'];
			/****************************** /SEO *****************************/
		}

		$this->page_class = '';
		$this->page_footer = '<div class="footer-parallax"></div>';
        $this->template->content = $content;
    }
	
    public function action_articles() {
        $alias = $this->request->param('cat');
        $articles_obj = new Model_Articles();
        $categories_obj = new Model_Categories();
		$seo_obj = new Model_Seo();
	
		if($alias){		
			$catpage = $categories_obj->getCategory(0, $alias);						  
			$articles = $articles_obj->get_all_to_cat($catpage[0]['id']);
			$this->page_title = $catpage[0]['descriptions'][$this->lang_id]['title'];
		} else {
			$articles = $articles_obj->get_all_no_fine();
			$this->page_title = 'Новости';
			$modulinfo = Modulinfo::get_block('articles');
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
		
		$content = View::factory($this->template_directory . 'articles')
					->bind('modulinfo', $modulinfo)
					->bind('articles', $articles);
					
        $this->template->content = $content;
    }
}
// Articles