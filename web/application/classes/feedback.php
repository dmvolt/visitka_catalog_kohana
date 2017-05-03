<?php
defined('SYSPATH') or die('No direct script access.');
class Feedback {
	
	public static function feedback_contact_form() {
        return View::factory(Data::_('template_directory') . 'feedback');
    }
	
	public static function recall_form() {
        return View::factory(Data::_('template_directory') . 'recall-block');
    }
	
	public static function order_form() {
        return View::factory(Data::_('template_directory') . 'order-block');
    }
}
// End Feedback