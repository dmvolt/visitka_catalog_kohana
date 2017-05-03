<?php

defined('SYSPATH') or die('No direct script access.');

class Reviews {
    public static function front_block($num = 2) {

        $reviews_obj = new Model_Reviews();		
			
        $content = $reviews_obj->get_last($num);		
        return View::factory(Data::_('template_directory') . 'reviews-front-block')->bind('content', $content);
    }
}