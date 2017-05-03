<?php

defined('SYSPATH') or die('No direct script access.');

class Appointments {
    public static function get_block() {
		$doctors_obj = new Model_Doctors();	
        $doctors = $doctors_obj->get_all();	
        return View::factory(Data::_('template_directory') . 'appointments-block')->bind('doctors', $doctors);
    }
}