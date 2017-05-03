<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Seo extends Controller {
	
	public function action_sitemap() {
		Sitemap::build();
		Request::initial()->redirect('/');
    }
}