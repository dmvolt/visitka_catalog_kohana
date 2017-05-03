<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Ajaxappointments extends Controller {
	
	public function action_feedback() {
		
        $name = Arr::get($_POST, 'name', '');
        $contact = Arr::get($_POST, 'contact', '');
		$time = Arr::get($_POST, 'time', '');
		$category_id = Arr::get($_POST, 'category_id');
		$doctor_id = Arr::get($_POST, 'doctor_id');
		
        $validation = Validation::factory($_POST);
        $validation->rule('name', 'not_empty');
        $validation->rule('name', 'max_length', array(':value', '64'));
		
        $validation->rule('contact', 'not_empty');
		$validation->rule('contact', 'max_length', array(':value', '64'));
		
		$errors = '';
		$validation->labels(array(
			'name' => '-Имя-', 
			'contact' => '-Телефон или E-mail-'
		));
		
        if (!$validation->check()) {
		
            $res = false;
			$errors_arr = $validation->errors('validation');
			foreach($errors_arr as $error){
				$errors .= $error.'<br>';
			}
			
        } else {
		
            $siteinfo = new Model_Siteinfo();
			$appointments_obj = new Model_Appointments();
			$categories_obj = new Model_Categories();
			$doctors_obj = new Model_Doctors();
			
			$doctor_info = $doctors_obj->get_content($doctor_id);
			$cat_info = $categories_obj->getNode($category_id);
			
			if($doctor_info){
				$doctor_name = $doctor_info['descriptions'][1]['title'];
			} else {
				$doctor_name = 'Не выбран';
			}
			
			$add_data = array(
				'category_id' => $category_id,
				'doctor_id' => $doctor_id,
				'date' => date('d-m-Y'),
				'name' => $name,
				'time' => $time,
				'contact' => $contact,
				'weight' => 0,
				'status' => 1,
			);
			
			$result = $appointments_obj->add($add_data);
			
			if ($result) {
				$info = $siteinfo->get_siteinfo(1);
				//Отправка эл. почты администратору
				$from = $info['email'];
				$to = $info['email'];
				$subject = 'Запись на прием';
				$message = '<html><body>';
				$message .= 'Направление: '.$cat_info['descriptions'][1]['title'].'<br>Врач: '.$doctor_name.'<br>Имя: ' . $name . '<br>Время: ' . $time . '<br>Контактная информация: ' . $contact;
				$message .= '</body></html>';
				$headers = "Content-type: text/html; charset=utf-8 \r\n";
				$headers .= "From: <" . $from . ">\r\n";
				$result = mail($to, $subject, $message, $headers);
				$res = true;
			}
        }
        echo json_encode(array('result' => $res, 'errors' => $errors));
    }
	
	public function action_get_doctors() {
		
        $cat_id = Arr::get($_POST, 'cat_id');
		$res = '<option value="0" selected disabled>Выберите врача</option>';
		$doctors_obj = new Model_Doctors();
		$doctor_info = $doctors_obj->get_all_to_cat($cat_id);
		
		if(!empty($doctor_info)){
			foreach($doctor_info as $value){
				$res .= '<option value="'.$value['id'].'">'.$value['descriptions'][1]['title'].'</option>';
			}
		} else {
			$res = '<option value="0" selected disabled>В выбраном вами направлении врачей не найдено!</option>';
		}
			
        echo json_encode(array('result' => $res));
    }
}
// Ajaxappointments