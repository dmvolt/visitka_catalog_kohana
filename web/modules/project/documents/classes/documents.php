<?php

defined('SYSPATH') or die('No direct script access.');

class Documents {

    public static function documents_block($num = 25) {
        $content = View::factory(Data::_('template_directory') . 'documents-block')
                ->bind('documents', $documents);
        $documents_obj = new Model_Documents();
        $documents = $documents_obj->get_last($num);
        return $content;
    }
	
	public static function documents_current_block($id, $num = 25) {
        $content = View::factory(Data::_('template_directory') . 'documents-block')
                ->bind('documents', $documents);
        $documents_obj = new Model_Documents();
        $documents = $documents_obj->get_last_current($id, $num);
        return $content;
    }
	
	public static function documents_cat_block($catid) {
        $content = View::factory(Data::_('template_directory') . 'documents-cat-block')
                ->bind('documents', $documents);
        $documents_obj = new Model_Documents();
        $documents = $documents_obj->get_all_to_cat($catid);
        return $content;
    }
}
// Documents