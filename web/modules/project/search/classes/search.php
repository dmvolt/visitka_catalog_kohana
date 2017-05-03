<?php

defined('SYSPATH') or die('No direct script access.');

class Search {

    public static function get_search_block() {
		$data['q'] = Arr::get($_GET, 'q', '');
        return View::factory(Data::_('template_directory') . 'search_block', $data);
    }
	
	public static function get_filter_block() {
	
		$group_tags = Kohana::$config->load('tags.group_tags');
		$tags_obj = new Model_Tags();
		
		foreach($group_tags as $group_id => $value){
			$data['tags_'.$group_id]['info'] = $value;
			$data['tags_'.$group_id]['content'] = $tags_obj->get_all($group_id, Data::_('lang_id'));
		}
		
		$data['price_diapazon'] = Kohana::$config->load('filter.price_diapazon');

		$data['filter']['f1'] = Arr::get($_GET, 'f1', '');
		$data['filter']['f2'] = Arr::get($_GET, 'f2', '');
		$data['filter']['f3'] = Arr::get($_GET, 'f3', '');
		$data['filter']['f4'] = Arr::get($_GET, 'f4', '');
		
		$data['filter']['pr1'] = Arr::get($_GET, 'pr1', $data['price_diapazon']['min']);
		$data['filter']['pr2'] = Arr::get($_GET, 'pr2', $data['price_diapazon']['max']);
		
        return View::factory(Data::_('template_directory') . 'filter_block', $data);
    }
}
// Search