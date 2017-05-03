<?php

defined('SYSPATH') or die('No direct script access.');

class News {

    public static function news_block($num = 4) {
        $content = View::factory(Data::_('template_directory') . 'news-block')
                ->bind('last_news', $last_news);

        $news_obj = new Model_News();

        $last_news = $news_obj->get_last($num);

        return $content;
    }
}
// News