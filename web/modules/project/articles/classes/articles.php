<?php

defined('SYSPATH') or die('No direct script access.');

class Articles {

    public static function articles_block($num = 25) {
        $content = View::factory(Data::_('template_directory') . 'articles-block')
                ->bind('articles', $articles);
        $articles_obj = new Model_Articles();
        $articles = $articles_obj->get_last($num);
        return $content;
    }
	
	public static function articles_current_block($id, $num = 25) {
        $content = View::factory(Data::_('template_directory') . 'articles-block')
                ->bind('articles', $articles);
        $articles_obj = new Model_Articles();
        $articles = $articles_obj->get_last_current($id, $num);
        return $content;
    }
	
	public static function articles_cat_block($catid) {
        $content = View::factory(Data::_('template_directory') . 'articles-cat-block')
                ->bind('articles', $articles);
        $articles_obj = new Model_Articles();
        $articles = $articles_obj->get_all_to_cat($catid);
        return $content;
    }
}
// Articles