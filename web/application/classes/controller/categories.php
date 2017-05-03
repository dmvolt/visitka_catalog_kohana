<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Categories extends Controller_Template {

    public function action_services() {
	
		$categories_obj = new Model_Categories();
		$siteinfo_obj = new Model_Siteinfo();		
        $alias = $this->request->param('alias');
		
		$ok = false;
		$errors = false;
		
		if (isset($_POST['name'])) {
			$validation = Validation::factory($_POST);
			$validation->rule('name', 'not_empty');
			$validation->rule('name', 'max_length', array(':value', '64'));
			$validation->labels(array('name' => 'Ваше имя'));
			if ($validation->check()) {
				$name = Arr::get($_POST, 'name');
				$phone = Arr::get($_POST, 'phone');
				$email = Arr::get($_POST, 'email');
				$delivery = Arr::get($_POST, 'delivery');
				$address = Arr::get($_POST, 'address');
				$service = Arr::get($_POST, 'service');
				$comment = Arr::get($_POST, 'text');
				
				$info = $siteinfo_obj->get_siteinfo(1);
				//Отправка эл. почты администратору
				$from = $info['email'];
				$to = $info['email'];
				$subject = 'Заявка на услугу '.$service.' на сайте';
				$message = '<html><body>';
				$message .= 'Автор заявки: '.$name;
				$message .= '<br><br>Телефон для связи: '.$phone;
				$message .= '<br>E-mail: '.$email;
				$message .= '<br>Услуга: '.$service;
				
				if($delivery AND $address AND !empty($address)){
					$message .= '<br>Необходима доставка по адресу: '.$address;
				}
				
				$message .= '<br><br>Комментарий к заявке: '.$comment;
				$message .= '</body></html>';
				$headers = "Content-type: text/html; charset=utf-8 \r\n";
				$headers .= "From: <" . $from . ">\r\n";
				mail($to, $subject, $message, $headers);
				
				$ok = 'Ваша заявка успешно отправлена! Мы с Вами свяжемся в течение одного часа.';
			}
			$errors = $validation->errors('validation');
		}
		
		if($alias){
		
			$service = $categories_obj->getCategory(1, $alias);
			$edit_interface = Liteedit::get_interface($service[0]['id'], 'categories');
			$this->page_title = $service[0]['descriptions'][$this->lang_id]['title'];
			/****************************** SEO ******************************/	
			$seo_obj = new Model_Seo();
			$seo = $seo_obj->get_seo_to_content($service[0]['id'], 'categories');

			if($seo[$this->lang_id]['title'] != ''){
				$this->page_title = $seo[$this->lang_id]['title'];
			}

			$this->meta_description = $seo[$this->lang_id]['meta_d'];
			$this->meta_keywords = $seo[$this->lang_id]['meta_k'];
			/****************************** /SEO *****************************/
			
			$content = View::factory($this->template_directory . 'service')
					->bind('service', $service[0])
					->bind('errors', $errors)
					->bind('ok', $ok)
					->bind('edit_interface', $edit_interface);
			
		} else {
		
			$services = $categories_obj->getCategories(1, 0, 0);
			$this->page_title = 'Услуги';
			
			$content = View::factory($this->template_directory . 'services')
					->bind('errors', $errors)
					->bind('ok', $ok)
					->bind('services', $services);
		}
		
		$this->page_class = '';
		$this->page_footer = '';
		
        $this->template->content = $content;
    }
}
// End Controller_Categories