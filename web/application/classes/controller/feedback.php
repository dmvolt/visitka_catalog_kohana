<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Feedback extends Controller {

	public function action_feedback() {
		
        $name = Arr::get($_POST, 'name', '');
        $phone = Arr::get($_POST, 'phone', '');
		$email = Arr::get($_POST, 'email', '');
		$text = Arr::get($_POST, 'text', '');
		
        $validation = Validation::factory($_POST);
        $validation->rule('name', 'not_empty');
        $validation->rule('name', 'min_length', array(':value', '2'));
        $validation->rule('name', 'max_length', array(':value', '64'));
		
		$validation->rule('phone', 'max_length', array(':value', '64'));
		
		$validation->rule('email', 'not_empty');
		$validation->rule('email', 'email');
		
		$validation->rule('text', 'not_empty');
        $validation->rule('text', 'min_length', array(':value', '10'));
        $validation->rule('text', 'max_length', array(':value', '2000'));
		
		$errors = '';
		$validation->labels(array(
			'name' => '-Ваше имя-', 
			'phone' => '-Телефон-', 
			'email' => '-E-mail-', 
			'text' => '-Текст сообщения-'
		));
		
        if (!$validation->check()) {
            $res = false;
			$errors_arr = $validation->errors('validation');
			foreach($errors_arr as $error){
				$errors .= $error.'<br>';
			}
        } else {
            $siteinfo = new Model_Siteinfo();
            $info = $siteinfo->get_siteinfo(1);
            //Отправка эл. почты администратору
            $from = $info['email'];
            $to = $info['email'];
            $subject = 'Сообщение из формы обратной связи оставил(а) ' . $name;
            $message = '<html><body>';
            $message .= $text . '<br><br>Автор сообщения: ' . $name . '<br>Можно связаться:<br>E-mail - ' . $email;
			
			if(!empty($phone)){
				$message .= '<br>Номер телефона для связи - ' . $phone;
			}
			
            $message .= '</body></html>';
            $headers = "Content-type: text/html; charset=utf-8 \r\n";
            $headers .= "From: <" . $from . ">\r\n";
            $result = mail($to, $subject, $message, $headers);
            $res = true;
        }
        echo json_encode(array('result' => $res, 'errors' => $errors));
    }
	
	public function action_recall() {
		
        $name = Arr::get($_POST, 'name', '');
        $phone = Arr::get($_POST, 'phone', '');
		//$text = Arr::get($_POST, 'text', '');
		
        $validation = Validation::factory($_POST);
        $validation->rule('name', 'not_empty');
        $validation->rule('name', 'min_length', array(':value', '2'));
        $validation->rule('name', 'max_length', array(':value', '64'));
		
		$validation->rule('phone', 'not_empty');
		$validation->rule('phone', 'max_length', array(':value', '64'));
		
        /* $validation->rule('text', 'min_length', array(':value', '10'));
        $validation->rule('text', 'max_length', array(':value', '2000')); */
		
		$errors = '';
		$validation->labels(array(
			'name' => '-Ваше имя-', 
			'phone' => '-Телефон-',
			//'text' => '-Текст сообщения-'
		));
		
        if (!$validation->check()) {
            $res = false;
			$errors_arr = $validation->errors('validation');
			foreach($errors_arr as $error){
				$errors .= $error.'<br>';
			}
        } else {
            $siteinfo = new Model_Siteinfo();
            $info = $siteinfo->get_siteinfo(1);
            //Отправка эл. почты администратору
            $from = $info['email'];
            $to = $info['email'];
            $subject = 'Обратный звонок заказал(а) ' . $name;
            $message = '<html><body>';
            $message .= 'Имя: ' . $name;
			
			if(!empty($phone)){
				$message .= '<br>Номер телефона для связи - ' . $phone;
			}
			
            $message .= '</body></html>';
            $headers = "Content-type: text/html; charset=utf-8 \r\n";
            $headers .= "From: <" . $from . ">\r\n";
            $result = mail($to, $subject, $message, $headers);
            $res = true;
        }
        echo json_encode(array('result' => $res, 'errors' => $errors));
    }
	
	public function action_order() {
		
        $name = Arr::get($_POST, 'name', '');
        $phone = Arr::get($_POST, 'phone', '');
		$text = Arr::get($_POST, 'text', '');
		
        $validation = Validation::factory($_POST);
        $validation->rule('name', 'not_empty');
        $validation->rule('name', 'min_length', array(':value', '2'));
        $validation->rule('name', 'max_length', array(':value', '64'));
		
		$validation->rule('phone', 'not_empty');
		$validation->rule('phone', 'max_length', array(':value', '64'));
		
        $validation->rule('text', 'min_length', array(':value', '10'));
        $validation->rule('text', 'max_length', array(':value', '2000'));
		
		$errors = '';
		$validation->labels(array(
			'name' => '-Ваше имя-', 
			'phone' => '-Телефон-',
			'text' => '-Текст сообщения-'
		));
		
        if (!$validation->check()) {
            $res = false;
			$errors_arr = $validation->errors('validation');
			foreach($errors_arr as $error){
				$errors .= $error.'<br>';
			}
        } else {
            $siteinfo = new Model_Siteinfo();
            $info = $siteinfo->get_siteinfo(1);
            //Отправка эл. почты администратору
            $from = $info['email'];
            $to = $info['email'];
            $subject = 'Вызов замерщика заказал(а) ' . $name;
            $message = '<html><body>';
            $message .= $text . '<br><br>Автор сообщения: ' . $name;
			
			if(!empty($phone)){
				$message .= '<br>Номер телефона для связи - ' . $phone;
			}
			
            $message .= '</body></html>';
            $headers = "Content-type: text/html; charset=utf-8 \r\n";
            $headers .= "From: <" . $from . ">\r\n";
            $result = mail($to, $subject, $message, $headers);
            $res = true;
        }
        echo json_encode(array('result' => $res, 'errors' => $errors));
    }
}