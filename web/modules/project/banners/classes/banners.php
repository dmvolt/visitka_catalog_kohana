<?php

defined('SYSPATH') or die('No direct script access.');

class Banners {

    public static function get() {
        $banners_obj = new Model_Banners();
        $result = $banners_obj->get_last_content();
        $i = 0;
        if ($result['display_pages'] != '') {
            $pages = explode(',', $result['display_pages']);
            if (Request::current()->param('page') OR Request::current()->param('id') OR Request::current()->action()) {
                foreach ($pages as $path) {
                    if ((trim($path) == Request::current()->param('page')) OR
                            (trim($path) == Request::current()->param('id')) OR
                            (trim($path) == Request::current()->action()) OR
                            (trim($path) == Request::current()->controller())) {
                        $i++;
                    }
                }
            }
        }
        if ($result['display_all'] OR $i > 0) {
			return View::factory(Data::_('template_directory') . 'banners')->bind('banners_data', $result);           
        }
    }
	
	public static function get_bottom() {
        $banners_obj = new Model_Banners();
        $result = $banners_obj->get_content(6);
        $i = 0;
        if ($result['display_pages'] != '') {
            $pages = explode(',', $result['display_pages']);
            if (Request::current()->param('page') OR Request::current()->param('id') OR Request::current()->action()) {
                foreach ($pages as $path) {
                    if ((trim($path) == Request::current()->param('page')) OR
                            (trim($path) == Request::current()->param('id')) OR
                            (trim($path) == Request::current()->action()) OR
                            (trim($path) == Request::current()->controller())) {
                        $i++;
                    }
                }
            }
        }
        if ($result['display_all'] OR $i > 0) {
			return View::factory(Data::_('template_directory') . 'banners-bottom')->bind('banners_data', $result);           
        }
    }
}
// End Banners