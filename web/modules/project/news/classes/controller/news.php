<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_News extends Controller_Template {

    public function action_new() {
        $id = $this->request->param('id'); // Получение параметра id из адресной строки

        $content = View::factory($this->template_directory . 'news')
				->bind('edit_interface', $edit_interface)
                ->bind('news', $one_news);

        $news_obj = new Model_News();  // Создание экземпляра объекта модели
        $one_news = $news_obj->get_content($id); // Создание экземпляра объекта модели с выборкой из метода
		
		if($one_news){
			$edit_interface = Liteedit::get_interface($one_news['id'], 'news');
			$this->page_title = $one_news['descriptions'][$this->lang_id]['title'];
		}

		$this->page_footer = '<div class="footer-parallax"></div>';
		$this->page_class = '';

        $this->template->content = $content;
    }

    public function action_news() {
		
		$query = '';
		$year = '';
		
		$y = Arr::get($_GET, 'y'); // Получение параметра y(год) из адресной строки
		
		if($y AND !empty($y)){
			$query = ' AND `date` LIKE "' . $y . '%" ';
			$year = ' - '.$y.'г.';
		}

        $content = View::factory($this->template_directory . 'all-news')
                ->bind('all_news', $all_news)
				->bind('year', $year)
				->bind('pagination', $pagination);

        $news_obj = new Model_News();  // Создание экземпляра объекта модели
        $total = $news_obj->get_total();
        $result = Pagination::start($total);                                                                  
        $pagination = Pagination::navigation($result['page'], $total, $result['total_page'], $result['num']); 
        $all_news = $news_obj->get_all(0, $result['start'], $result['num'], $this->lang_id, $query);

        $this->page_title = $this->lang['text_all_news'];
		$this->page_footer = '<div class="footer-parallax"></div>';
		$this->page_class = '';
        
		$this->template->content = $content;
    }

}

// Controller_News