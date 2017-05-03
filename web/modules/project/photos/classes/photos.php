<?php

defined('SYSPATH') or die('No direct script access.');

class Photos {

    public static function photos_block($num = 25) {
        $content = View::factory(Data::_('template_directory') . 'photos-block')
                ->bind('photos', $photos);
        $photos_obj = new Model_Photos();
        $photos = $photos_obj->get_last($num);
        return $content;
    }
	
	public static function photos_current_block($id, $num = 25) {
        $content = View::factory(Data::_('template_directory') . 'photos-block')
                ->bind('photos', $photos);
        $photos_obj = new Model_Photos();
        $photos = $photos_obj->get_last_current($id, $num);
        return $content;
    }
	
	public static function photos_cat_block($catid) {
        $content = View::factory(Data::_('template_directory') . 'photos-cat-block')
                ->bind('photos', $photos);
        $photos_obj = new Model_Photos();
        $photos = $photos_obj->get_all_to_cat($catid);
        return $content;
    }
}
// Photos