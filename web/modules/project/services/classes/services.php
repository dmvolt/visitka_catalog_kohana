<?php

defined('SYSPATH') or die('No direct script access.');

class Services {

    public static function services_block($num = 25) {
        $content = View::factory(Data::_('template_directory') . 'services-block')
                ->bind('services', $services);
        $services_obj = new Model_Services();
        $services = $services_obj->get_last($num);
        return $content;
    }
	
	public static function services_current_block($id, $num = 25) {
        $content = View::factory(Data::_('template_directory') . 'services-block-menu')
                ->bind('services', $services);
        $services_obj = new Model_Services();
        $services = $services_obj->get_last_current($id, $num);
        return $content;
    }
	
	public static function services_cat_block($catid) {
        $content = View::factory(Data::_('template_directory') . 'services-cat-block')
                ->bind('services', $services);
        $services_obj = new Model_Services();
        $services = $services_obj->get_all_to_cat($catid);
        return $content;
    }
}
// Services