<?php

defined('SYSPATH') or die('No direct script access.');

class Projects {

    public static function projects_block($num = 25) {
        $content = View::factory(Data::_('template_directory') . 'projects-block')
                ->bind('projects', $projects);
        $projects_obj = new Model_Projects();
        $projects = $projects_obj->get_last($num);
        return $content;
    }
	
	public static function projects_current_block($id, $num = 25) {
        $content = View::factory(Data::_('template_directory') . 'projects-block-menu')
                ->bind('projects', $projects);
        $projects_obj = new Model_Projects();
        $projects = $projects_obj->get_last_current($id, $num);
        return $content;
    }
	
	public static function projects_cat_block($catid) {
        $content = View::factory(Data::_('template_directory') . 'projects-cat-block')
                ->bind('projects', $projects);
        $projects_obj = new Model_Projects();
        $projects = $projects_obj->get_all_to_cat($catid);
        return $content;
    }
}
// Projects