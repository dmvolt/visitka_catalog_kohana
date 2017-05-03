<?php

defined('SYSPATH') or die('No direct script access.');

class Infoblock {

    public static function infoblock_block($num = 3, $type = 1) {

		if($type == 1){
			$content = View::factory(Data::_('template_directory') . 'infoblock-right')
                ->bind('infoblocks', $infoblocks);
		} elseif($type == 2){
			$content = View::factory(Data::_('template_directory') . 'infoblock-left')
                ->bind('infoblocks', $infoblocks);
		} else {
			$content = View::factory(Data::_('template_directory') . 'infoblock-right')
                ->bind('infoblocks', $infoblocks);
		}

        $infoblock_obj = new Model_Infoblock();
        $infoblocks = $infoblock_obj->get_last($num, $type);
        return $content;
    }

	public static function get_page_block($url) {

		$content = View::factory(Data::_('template_directory') . 'infoblock-page')
			->bind('infoblocks', $infoblocks);

        $infoblock_obj = new Model_Infoblock();
        $infoblocks = $infoblock_obj->get_blocks(3, $url);
        return $content;
    }
}
// Infoblock