<?php

defined('SYSPATH') or die('No direct script access.');

class Pages {

    public static function front_block() {
        $content = View::factory(Data::_('template_directory') . 'pages-block')
                ->bind('pages', $pages);
        $pages_obj = new Model_Pages();
        $pages = $pages_obj->get_in_front_pages();
        return $content;
    }
}
// Pages