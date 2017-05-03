<?php

defined('SYSPATH') or die('No direct script access.');

class Categories {
	
	public static function get_front_block($num = 4) {
		$categories_obj = new Model_Categories();
        $cats = $categories_obj->getCategories(1, 0, 0, $num);
        return View::factory(Data::_('template_directory') . 'cat-front-block')->set('cats', $cats);
    }
	
	public static function get_plans_block() {
		$categories_obj = new Model_Categories();
        $cats = $categories_obj->getCategories(1, 0, 0);
        return View::factory(Data::_('template_directory') . 'cat-plans-block')->set('cats', $cats);
    }
	
	public static function get_plans_front_block() {
		$categories_obj = new Model_Categories();
        $cats = $categories_obj->getCategories(2, 0, 0);
        return View::factory(Data::_('template_directory') . 'plans-front-block')->set('cats', $cats);
    }
}
// End Categories