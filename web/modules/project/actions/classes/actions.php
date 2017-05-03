<?php

defined('SYSPATH') or die('No direct script access.');

class Actions {

    public static function actions_block($num = 25) {
        $content = View::factory(Data::_('template_directory') . 'actions-block')
                ->bind('actions', $actions);
        $actions_obj = new Model_Actions();
        $actions = $actions_obj->get_last($num);
        return $content;
    }
	
	public static function actions_current_block($id, $num = 25) {
        $content = View::factory(Data::_('template_directory') . 'actions-block-menu')
                ->bind('actions', $actions);
        $actions_obj = new Model_Actions();
        $actions = $actions_obj->get_last_current($id, $num);
        return $content;
    }
	
	public static function actions_cat_block($catid) {
        $content = View::factory(Data::_('template_directory') . 'actions-cat-block')
                ->bind('actions', $actions);
        $actions_obj = new Model_Actions();
        $actions = $actions_obj->get_all_to_cat($catid);
        return $content;
    }
}
// Actions