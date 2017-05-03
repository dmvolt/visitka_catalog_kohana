<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Ajax extends Controller {

    public function action_emailunique() {	
		
        //$email = Arr::get($_POST, 'email', '');
        $validation = Validation::factory($_POST);
        $validation->rule('email', 'not_empty');
        $validation->rule('email', 'email');
        $validation->rule('email', 'email_unique');
        if ($validation->check()) {
            $res = 1;
        } else {
            $res = 0;
        }
        //$user = new Model_User();
        //$res = $user->email_unique($email);
        echo json_encode(array('result' => $res));
    }
	
    public function action_loginunique() {
		
        //$login = Arr::get($_POST, 'username', '');
        $validation = Validation::factory($_POST);
        //$validation->rule('username', 'not_empty');
        $validation->rule('username', 'min_length', array(':value', '3'));
        $validation->rule('username', 'max_length', array(':value', '64'));
        $validation->rule('username', 'username_unique');
        $validation->rule('username', 'alpha_numeric');
        if ($validation->check()) {
            $res = 1;
        } else {
            $res = 0;
        }
        //$user = new Model_User();
        //$res = $user->username_unique($login);
        echo json_encode(array('result' => $res));
    }
	
    public function action_checkOldPass() {
		
        $oldpass = Arr::get($_POST, 'oldpass', '');
        $id = Arr::get($_POST, 'user_id', 0);
        $user = new Model_User();
        $res = $user->checkOldPass($id, $oldpass);
        echo json_encode(array('result' => $res));
    }
	
    public function action_savenewpass() {
		
        $newpass1 = Arr::get($_POST, 'newpass1', '');
        $newpass2 = Arr::get($_POST, 'newpass2', '');
        $oldpass = Arr::get($_POST, 'oldpass', '');
        $id = Arr::get($_POST, 'user_id', 0);
        $user = new Model_User();
        $res = $user->save_new_pass($id, $oldpass, $newpass1, $newpass2);
        echo json_encode(array('result' => $res));
    }
	
    public function action_generatealias() {
		
        $name = Arr::get($_POST, 'name', '');
        $res = Text::transliteration($name);
        echo json_encode(array('result' => $res));
    }
	
    public function action_generateanons() {
		
        $name = Arr::get($_POST, 'name', '');
        $res = Text::limit_chars($name, 100);
        echo json_encode(array('result' => $res));
    }
	
    public function action_renum() {
		
        $num = Arr::get($_POST, 'num', 10);
        
        $pagination_num = $this->session->get('num', 0);
        if ($pagination_num) {
            $this->session->delete('num');
            $this->session->set('num', $num);
        } else {
            $this->session->set('num', $num);
        }
        $res = TRUE;
        echo json_encode(array('result' => $res));
    }
	
    public function action_getchild() {
		
        $category = new Model_Categories();
        $parrent = Arr::get($_POST, 'parrent', 0);
        if ($parrent) {
            $catsdata = $category->getCategories(2, $parrent, 0);
        }
        if (isset($catsdata) AND $catsdata) {
            $res = '';
            foreach ($catsdata as $key => $cat) {
                $res .= '<li name="' . $cat['id'] . '" class="';
                if (!$key) {
                    $res .= 'first';
                }
                $res .= '">' . $cat['menu'] . '</li>';
            }
        } else {
            $res = 0;
        }
        echo json_encode(array('result' => $res));
    }
	
	public function action_setpoll() {
		
        $poll_id = Arr::get($_POST, 'poll_id', 0);
        $poll_lang_id = Arr::get($_POST, 'poll_lang_id', 1);
        $poll_result = Arr::get($_POST, 'poll_result');
		
		$res = false;
		
		$news_obj = new Model_News();
		
		if($poll_result){
			$res = $news_obj->set_poll($poll_id, $poll_lang_id, $poll_result);
		}
        echo json_encode(array('result' => $res));
    }
}