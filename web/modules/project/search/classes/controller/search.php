<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Search extends Controller_Template {

    public function action_index() {

		$filtred_data = false;
        if (Arr::get($_GET, 'q')) {
            $q = Arr::get($_GET, 'q');
			
			substr(htmlspecialchars(trim(addslashes($q))), 0, 1000);
			
			$words = explode(' ', $q);
            $search_obj = new Model_Search();
            $search_data = $search_obj->get_filter_search($q);

			if($search_data){
				foreach($search_data as $value){

					if($value['module'] == 'catalog') {
						$result = Model::factory($value['module'])->get_content($value['content_id']);
						
						if($result){
							$filtred_data[$value['module']][] = array(
								'link' => '/catalog/g-'.$result['alias'],
								'content' => $result,
							);
						}
					}
				}
			}
        }

		$content = View::factory($this->template_directory . 'search')   
			->bind('words', $words)
			->bind('query', $q)
			->bind('articles', $filtred_data);
					
		$this->page_title = $this->lang['text_search_results'];
		$this->page_class = '';
		$this->page_footer = '';
		
        $this->template->content = $content;
    }
}