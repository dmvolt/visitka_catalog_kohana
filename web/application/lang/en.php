<?php

defined('SYSPATH') or die('No direct script access.');

$lang_array = array(
    'text_page_not_found' => 'Sorry, page not found.',
	'text_edit' => 'Edit',	'text_full_edit' => 'Full edit',
	'text_save' => 'Save',
	'text_entry_captcha' => 'Please, enter the combination of letters and numbers from the image',
	'text_login_field' => 'Your login...',
	'text_login' => 'Login',
	'text_password_field' => 'Your password...',
	'text_reg' => 'Registration',
	'text_pass_recovery' => 'Forgot your password?',
	'text_logout' => 'Logout',
	'text_login_welcome' => 'Welcome ',
	'text_old_browser_warning' => 'You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">update your browser</a> to view this page.',
	'text_link_preview' => '<< Preview',
	'text_preview' => 'Preview post',
	'text_link_next' => 'Next >>',
	'text_next' => 'Next post',
	'text_error_404' => 'Want to try again? Return to the previous page or visit the <a href="/front">home page</a>.',
	'text_error_500' => 'Want to try again? Return to the previous page or visit the <a href="/front">home page</a>.',
	'text_error_503' => 'Want to try again? Return to the previous page or visit the <a href="/front">home page</a>.',
	
	'text_our_products' => 'Our products',
	
	'text_contact_form' => 'Contact us',
	'text_contact_form_name' => 'Name',
	'text_contact_form_phone' => 'Phone',
	'text_contact_form_email' => 'E-mail',
	'text_contact_form_city' => 'City',
	'text_contact_form_message' => 'Message',
	'text_contact_form_notice' => '<b>Note:</b> Fields marked with an asterisk (<span class = "r">*</span>), are required.',
	'text_contact_form_submit' => 'Submit',
);

View::set_global($lang_array);