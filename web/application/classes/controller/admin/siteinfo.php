<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Siteinfo extends Controller_Admin_Template {

    public function action_index() {
	
        $this->session->delete('user_redirect');
        $this->session->set('user_redirect', $_SERVER['REQUEST_URI']);
        $siteinfo_obj = new Model_Siteinfo();
		
        if (isset($_POST['site_email'])) {
            $newsitedata = array(
                'descriptions' => Arr::get($_POST, 'descriptions', array()),
                'site_email' => Arr::get($_POST, 'site_email', ''),
				'site_email1' => Arr::get($_POST, 'site_email1', ''),
				'site_email2' => Arr::get($_POST, 'site_email2', ''),
				'site_email3' => Arr::get($_POST, 'site_email3', ''),
				'site_email4' => Arr::get($_POST, 'site_email4', ''),
				'site_email5' => Arr::get($_POST, 'site_email5', ''),
				'site_email6' => Arr::get($_POST, 'site_email6', ''),
				'site_email7' => Arr::get($_POST, 'site_email7', ''),
				'site_email8' => Arr::get($_POST, 'site_email8', ''),
				'site_email9' => Arr::get($_POST, 'site_email9', ''),
				'site_email10' => Arr::get($_POST, 'site_email10', ''),
                'site_tell' => Arr::get($_POST, 'site_tell', ''),
				'site_counter' => Arr::get($_POST, 'site_counter', ''),
				'site_map' => Arr::get($_POST, 'site_map', ''),
            );
            $result = $siteinfo_obj->edit(1, $newsitedata);
            if ($result) {
				/********************* Операции с модулями ********************/
				Controller_Admin_Seo::set_fields(1, $_POST, 'siteinfo');
				/***********************************************************/
                Request::initial()->redirect('admin/siteinfo');
            }
        }
        $data['content'] = $siteinfo_obj->get_siteinfo(1);
		/********************* Операции с модулями ********************/
		$data['seo_form'] = Controller_Admin_Seo::get_fields($data['content'], 'siteinfo');
		/***********************************************************/
        $this->template->content = View::factory('admin/siteinfo-edit', $data);
    }		
	
	public function action_edit() {	
		$Id = $this->request->param('id');       
		$siteinfo_obj = new Model_Siteinfo();        
		if (isset($_POST['site_email'])) {            
			$newsitedata = array(                
				'descriptions' => Arr::get($_POST, 'descriptions', array()),                
				'site_email' => Arr::get($_POST, 'site_email', ''),
				'site_email1' => Arr::get($_POST, 'site_email1', ''),
				'site_email2' => Arr::get($_POST, 'site_email2', ''),
				'site_email3' => Arr::get($_POST, 'site_email3', ''),
				'site_email4' => Arr::get($_POST, 'site_email4', ''),
				'site_email5' => Arr::get($_POST, 'site_email5', ''),
				'site_email6' => Arr::get($_POST, 'site_email6', ''),
				'site_email7' => Arr::get($_POST, 'site_email7', ''),
				'site_email8' => Arr::get($_POST, 'site_email8', ''),
				'site_email9' => Arr::get($_POST, 'site_email9', ''),
				'site_email10' => Arr::get($_POST, 'site_email10', ''),                
				'site_tell' => Arr::get($_POST, 'site_tell', ''),
				'site_counter' => Arr::get($_POST, 'site_counter', ''),
				'site_map' => Arr::get($_POST, 'site_map', ''),
			);            
			
			$result = $siteinfo_obj->edit($Id, $newsitedata);            
			
			if ($result) {				
				/********************* Операции с модулями ********************/				
				Controller_Admin_Seo::set_fields($Id, $_POST, 'siteinfo');				
				/***********************************************************/                
				
				Request::initial()->redirect('admin/siteinfo');            
			}        
		}        
		$data['content'] = $siteinfo_obj->get_siteinfo($Id);		
		/********************* Операции с модулями ********************/		
		$data['seo_form'] = Controller_Admin_Seo::get_fields($data['content'], 'siteinfo');		
		/***********************************************************/        
		$this->template->content = View::factory('admin/siteinfo-edit', $data);    
	}
}