<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Template extends Kohana_Controller_Template {

    public function before() {
	
        $this->template_directory = Kohana::$config->load('template.directory');
        $this->template = $this->template_directory . $this->template;
		
        parent::before();
        if ($this->session->get('redirect', 0)){
            if ($this->session->get('redirect', 0) == $_SERVER['REQUEST_URI']){
                $this->session->delete('redirect');
            } else {
                $redirect = $this->session->get('redirect', 0);
                $this->session->delete('redirect');
                Request::initial()->redirect($redirect);
            }
        }
		
        $siteinfo = new Model_Siteinfo();
        $info = $siteinfo->get_siteinfo(1);
		
        View::bind_global('logged', $this->logged);
        View::bind_global('lang_id', $this->lang_id);
        View::bind_global('lang_uri', $this->lang_uri);
        View::bind_global('is_admin', $this->is_admin);
        View::set_global('title', $info['descriptions'][$this->lang_id]['site_name']);
        View::bind_global('page_title', $this->page_title);
		
		View::bind_global('page_class', $this->page_class);
		View::bind_global('page_footer', $this->page_footer);
		
        View::bind_global('meta_description', $this->meta_description);
        View::bind_global('meta_keywords', $this->meta_keywords);
        View::set_global('description', $info['descriptions'][$this->lang_id]['body']);
        View::set_global('logo', Kohana::$config->load('site.logo'));
        View::set_global('slogan', $info['descriptions'][$this->lang_id]['site_slogan']);
		View::set_global('address', $info['descriptions'][$this->lang_id]['teaser']);
		View::set_global('licence', $info['descriptions'][$this->lang_id]['site_licence']);
        View::set_global('prodigy', Kohana::$config->load('site.prodigy'));
        View::set_global('copyright', $info['descriptions'][$this->lang_id]['site_copyright']);
        View::set_global('tell', $info['tell']);
		View::set_global('site_counter', $info['site_counter']);
		View::set_global('site_map', $info['site_map']);
        View::set_global('info_email', $info['email']);
        View::set_global(Kohana::$config->load('template.colors'));
		
        $this->template->styles = array(
			//'css/' . $this->template_directory . 'bootstrap.3.3.6.min',
			//'css/' . $this->template_directory . 'font-awesome.min',
			'css/' . $this->template_directory . 'neat-grey',
			//'css/' . $this->template_directory . 'blueimp-gallery.min',
			//'css/' . $this->template_directory . 'bootstrap-image-gallery.min',
			'js/' . $this->template_directory . 'vendor/fancybox/jquery.fancybox',
			'css/' . $this->template_directory . 'main',
			//'css/redactor',
		);
		
		$this->template->scripts_header = array(
			//'js/' . $this->template_directory . 'jquery-1.9.1',
			//'js/' . $this->template_directory . 'main',
		);
		
        $this->template->scripts_footer = array(
			'js/' . $this->template_directory . 'vendor/fancybox/jquery.fancybox.pack',
			'js/' . $this->template_directory . 'bootstrap.3.3.6.min',
			
			'js/' . $this->template_directory . 'jquery.validate.min',
			'js/' . $this->template_directory . 'jquery.maskedinput.min',
			
			'js/' . $this->template_directory . 'jquery.event.move',
			'js/' . $this->template_directory . 'jquery.mixitup.min',
			'js/' . $this->template_directory . 'responsive-slider',
			'js/' . $this->template_directory . 'responsive-calendar',
			//'js/' . $this->template_directory . 'jquery.blueimp-gallery.min',
			//'js/' . $this->template_directory . 'bootstrap-image-gallery.min',
			'js/' . $this->template_directory . 'reduce-menu',
			'js/' . $this->template_directory . 'match-height',
			'js/' . $this->template_directory . 'main',
		);
		
        $this->template->menu = Menu::getmenu(1);
		$this->template->footer_menu = Menu::get_block_menu(2, '_footer');
		$this->template->social_menu = Menu::get_block_menu(3, '_social');
		
		$this->template->language_block = Language::get_block($this->languages);
		$this->template->banner = Banners::get();
		$this->template->recall_block = Feedback::recall_form();
		$this->template->order_block = Feedback::order_form();
		//$this->template->banner_bottom = Banners::get_bottom();
		
        $this->template->login_block = Model_Auth::loginform();
		$this->template->bottom_script = Liteedit::get_script();
		$this->template->them_colors_styles = View::factory($this->template_directory . 'them_colors_styles');
    }
}