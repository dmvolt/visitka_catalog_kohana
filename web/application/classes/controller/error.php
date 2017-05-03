<?php
defined('SYSPATH') or die('No direct script access.');
class Controller_Error extends Controller_Template {
	public function action_index()
    {
		$status = $this->request->param('code');
		
		if (Request::$initial !== Request::$current)
        {
            $message = rawurldecode($this->request->param('message'));
        }
	
        $this->template->content = View::factory('errors/' . $status)->bind('message', $message);
		$this->page_title = 'Извините, страница не найдена';
		$this->page_class = 'err-404';
        $this->response->status($status);
    }
}