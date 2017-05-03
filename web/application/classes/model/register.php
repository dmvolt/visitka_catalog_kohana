<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Register {

    protected $errors = array();
    protected $tableName = 'users';

    public function getErrors() {
        return $this->errors;
    }

    public function reg($data = array()) {
        $vData = Arr::extract($data, array('login', 'email'));
        $validation = Validation::factory($vData);
        //$validation->rule('login', 'not_empty');
        $validation->rule('login', 'min_length', array(':value', '3'));
        $validation->rule('login', 'max_length', array(':value', '64'));
        $validation->rule('login', 'username_unique');
        $validation->rule('login', 'alpha_numeric');

        $validation->rule('email', 'not_empty');
        $validation->rule('email', 'email');
        $validation->rule('email', 'email_unique');

        if (!$validation->check()) {
            $this->errors = $validation->errors('regErrors');
            return FALSE;
        }

        //Генерируем пароль
        $genpass = Text::generatePassword(8);

        $auth = new Model_Auth();
        $hash_pass = $auth->hash_password($genpass);

        $result = DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName . ' (username, avatar, email, password, role_id, status) VALUES (:username, :avatar, :email, :password, :role_id, :status)')
                ->parameters(array(
                    ':username' => $login = (isset($data['login']) AND !empty($data['login'])) ? $data['login'] : $data['email'],
                    ':avatar' => $avatar = (isset($data['avatar'])) ? $data['avatar'] : 0,
                    ':email' => $data['email'],
                    ':password' => $hash_pass,
                    ':role_id' => $role = (isset($data['role_id'])) ? $data['role_id'] : 3,
                    ':status' => $status = (isset($data['status'])) ? $data['status'] : 1
                ))
                ->execute();

        if ($result) {
            $query = DB::query(Database::SELECT, 'SELECT id FROM `' . $this->tableName . '` WHERE `email` = :email')
                    ->parameters(array(
                        ':email' => $data['email'],
                    ))
                    ->execute();

            $userdata = $query->as_array();
            if (count($userdata) > 0) {
                $user_id = $userdata[0]['id'];
            } else {
                $user_id = 0;
            }
			
			$siteinfo = new Model_Siteinfo();
            $info = $siteinfo->get_siteinfo(1);

            //$checkout = new Model_Checkout();
            //$customer_id = $checkout->add_customerinfo($user_id, $data); /* Только для ИМ */

            $email_data['reg_data'] = "Ваш логин: " . $login . " Ваш пароль: " . $genpass;
            //Отправка эл. почты
            $from = $info['email'];
            $subject = Kohana::message('reg', 'subject_registration');
            //$message = Email::get_email_template(1, $email_data, 'user');   //  Загрузка управляемого через админку шаблона письма. (1 - ID шаблона регистрации нового пользователя)
            $message = 'Поздравляем, новый пользователь успешно зарегистрирован!<br>'.$email_data['reg_data'].'<br>Вы можете изменить пароль в панели управления сайтом в разделе - Пользователи.';
			
			$headers = "Content-type: text/html; charset=utf-8 \r\n";
			$headers .= "From: <" . $from . ">\r\n";

			mail($data['email'], $subject, $message, $headers);

            return $user_id; // $customer_id; /* Только для ИМ */
        } else {
            return FALSE;
        }
    }

    public function newpassword1($email) {
        $usertemp = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName . '` WHERE `email` = :email', TRUE)
                ->as_object()
                ->param(':email', $email)
                ->execute();

        if (!isset($usertemp[0]->email)) {
            return FALSE;
        }

        $genpass = Text::generatePassword(18);

        DB::query(Database::UPDATE, 'UPDATE ' . $this->tableName . ' SET `rempass` = :rempass WHERE `email` = :email')
                ->parameters(array(
                    ':rempass' => $genpass,
                    ':email' => $email,
                ))
                ->execute();
				
		$siteinfo = new Model_Siteinfo();
		$info = $siteinfo->get_siteinfo(1);

        //Отправка эл. почты
        $from = $info['email'];
        $subject = Kohana::message('reg', 'subject_pwrecovery');

        $email_data['pwrecovery_link'] = "<a href='" . FULLURL . "/auth/checkcode/" . $genpass . "'>" . FULLURL . "/auth/checkcode/" . $genpass . "</a>";
        //$message = Email::get_email_template(2, $email_data, 'user');   //  Загрузка управляемого через админку шаблона письма. (2 - ID шаблона восстановления пароля 1 этап)
        $message = 'Пожалуйста, перейдите по ссылке '.$email_data['pwrecovery_link'].'<br>Этим вы подтверждаете, что имеете доступ к указанному вами e-mail адресу.';
		
		$headers = "Content-type: text/html; charset=utf-8 \r\n";
		$headers .= "From: <" . $from . ">\r\n";

		mail($email, $subject, $message, $headers);

        return TRUE;
    }

    public function newpassword2($code) {
        $usertemp = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName . '` WHERE `rempass` = :code', TRUE)
                ->as_object()
                ->param(':code', $code)
                ->execute();

        if (!isset($usertemp[0]->email)) {
            return FALSE;
        }

        $genpass = Text::generatePassword(8);

        //Хеширование пароля
        $auth = new Model_Auth();
        $hash_pass = $auth->hash_password($genpass);

        DB::query(Database::UPDATE, 'UPDATE ' . $this->tableName . ' SET `password` = :password, `rempass` = :rempass WHERE `rempass` = :code')
                ->parameters(array(
                    ':password' => $hash_pass,
                    ':rempass' => NULL,
                    ':code' => $usertemp[0]->rempass,
                ))
                ->execute();
        $return_data = array(
            'login' => $usertemp[0]->username,
            'pass' => $genpass,
        );

        //Отправка эл. почты
        $email = $usertemp[0]->email;
        $login = $usertemp[0]->username;

        $email_data['reg_data'] = "Ваш логин: " . $login . " Ваш пароль: " . $genpass;
		
		$siteinfo = new Model_Siteinfo();
		$info = $siteinfo->get_siteinfo(1);

        $from = $info['email'];
        $subject = Kohana::message('reg', 'subject_newregdata');
       // $message = Email::get_email_template(3, $email_data, 'user');   //  Загрузка управляемого через админку шаблона письма. (3 - ID шаблона восстановления пароля 2 этап)
        $message = 'Поздравляем, вам присвоен временный пароль для входа в систему!<br>'.$email_data['reg_data'].'<br>После входа рекомендуется сменить пароль.';
		
		$headers = "Content-type: text/html; charset=utf-8 \r\n";
		$headers .= "From: <" . $from . ">\r\n";

		mail($email, $subject, $message, $headers);

        return $return_data;
    }

}