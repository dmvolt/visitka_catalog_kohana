<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Front extends Controller_Template {

    public function action_index() {
        $siteinfo_obj = new Model_Siteinfo();
        $info = $siteinfo_obj->get_siteinfo(1);
		$pages_obj = new Model_Pages();
		
		$edit_interface = Liteedit::get_interface($info['id'], 'siteinfo');

        $content = View::factory($this->template_directory . 'main')
				->bind('edit_interface', $edit_interface)
				->bind('page_anons', $page_anons)
                ->bind('info', $info);
						
		$page_anons['about'] = $pages_obj->get_content('about');
		$page_anons['arendatoram'] = $pages_obj->get_content('arendatoram');
        
        $this->page_title = 'Главная';
		$this->page_class = 'front';
		
		/****************************** SEO ******************************/	
		$seo_obj = new Model_Seo();
		$seo = $seo_obj->get_seo_to_content($info['id'], 'siteinfo');
		
		if($seo[$this->lang_id]['title'] != ''){
			$this->page_title = $seo[$this->lang_id]['title'];
		}
		
		$this->meta_description = $seo[$this->lang_id]['meta_d'];
		$this->meta_keywords = $seo[$this->lang_id]['meta_k'];
		/****************************** /SEO *****************************/
		
        $this->template->content = $content;
    }
}
// End Front