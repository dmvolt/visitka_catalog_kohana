<?php

defined('SYSPATH') or die('No direct script access.');

class Model_User {

    protected $tableName = 'users';
    protected $errors = array();

    public function username_unique($username) {
        $usertemp = DB::query(Database::SELECT, 'SELECT * FROM ' . $this->tableName . ' WHERE `username` = :username', TRUE)
                ->as_object()
                ->param(':username', $username)
                ->execute();

        if (isset($usertemp[0]->username)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function email_unique($email) {
        $usertemp = DB::query(Database::SELECT, 'SELECT * FROM ' . $this->tableName . ' WHERE `email` = :email', TRUE)
                ->as_object()
                ->param(':email', $email)
                ->execute();

        if (isset($usertemp[0]->email)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function displayusername($Id = 0) {
        if ($Id == 0) {
            $auth = new Model_Auth();
            $userId = $auth->get_user();
        } else {
            $userId = $Id;
        }

        $usertemp = DB::query(Database::SELECT, 'SELECT * FROM ' . $this->tableName . ' WHERE `id` = :id', TRUE)
                ->as_object()
                ->param(':id', $userId)
                ->execute();

        return $usertemp[0]->username;
    }

    public function get_users($data = array()) {
        $sql = "SELECT * FROM " . $this->tableName;

        if (!empty($data) AND ($data['role_id'] != 0 OR !empty($data['email']))) {
            $sql .= " WHERE";

            if ($data['role_id'] != 0) {
                $sql .= " role_id = " . $data['role_id'];
            }

            if ($data['role_id'] != 0 AND !empty($data['email'])) {
                $sql .= " AND";
            }

            if (!empty($data['email'])) {
                $sql .= " LCASE(email) LIKE '" . $data['email'] . "%'";
            }
        }

        return DB::query(Database::SELECT, $sql)
                        ->execute();
    }

    public function get_userdata($Id) {
        return DB::query(Database::SELECT, 'SELECT * FROM ' . $this->tableName . ' WHERE `id` = :id', TRUE)
                        ->as_object()
                        ->param(':id', $Id)
                        ->execute();
    }
    
    public function get_email($role_id) {
        return DB::query(Database::SELECT, 'SELECT id, email FROM ' . $this->tableName . ' WHERE `role_id` = :role_id', TRUE)
                        ->as_object()
                        ->param(':role_id', $role_id)
                        ->execute();
    }

    public function checkOldPass($id, $oldpass) {
        // Create a hashed password
        $auth = new Model_Auth();
        $password = $auth->hash($oldpass);

        $user = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName . '` WHERE `password` = :password', TRUE)
                ->as_object()
                ->parameters(array(
                    ':password' => $password,
                ))
                ->execute();
        if (isset($user[0]->id)) {
            if ($user[0]->id == $id) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public function save_new_pass($id, $oldpass, $newpass1, $newpass2) {
        $vData = array("oldpass" => $oldpass, "newpass1" => $newpass1, "newpass2" => $newpass2);

        $validation = Validation::factory($vData);
        $validation->rule('oldpass', 'not_empty');
        $validation->rule('oldpass', 'alpha_numeric');
        $validation->rule('newpass1', 'not_empty');
        $validation->rule('newpass1', 'alpha_numeric');
        $validation->rule('newpass1', 'matches', array(':validation', 'newpass1', 'newpass2'));

        if (!$validation->check()) {
            $this->errors = $validation->errors('catErrors');
            return FALSE;
        }

        $auth = new Model_Auth();

        $query = DB::query(Database::UPDATE, 'UPDATE ' . $this->tableName . ' SET `password` = :password WHERE `id` = :id')
                ->parameters(array(
                    ':password' => $auth->hash_password($newpass1),
                    ':id' => $id,
                ))
                ->execute();

        return TRUE;
    }

    public function getErrors() {
        return $this->errors;
    }

    public function edit($Id, $data = array()) {
        $vData = Arr::extract($data, array('login', 'email'));
        $validation = Validation::factory($vData);
        //$validation->rule('login', 'not_empty');
        $validation->rule('login', 'min_length', array(':value', '3'));
        $validation->rule('login', 'max_length', array(':value', '64'));
        //$validation->rule('login', 'username_unique');
        $validation->rule('login', 'alpha_numeric');

        $validation->rule('email', 'not_empty');
        $validation->rule('email', 'email');
        //$validation->rule('email', 'email_unique');

        if (!$validation->check()) {
            $this->errors = $validation->errors();
            return FALSE;
        }

        $result = DB::query(Database::UPDATE, 'UPDATE ' . $this->tableName . ' SET username = :username, avatar = :avatar, email = :email, role_id = :role_id, status = :status WHERE id = :id')
                ->parameters(array(
                    ':username' => $login = (isset($data['login']) AND !empty($data['login'])) ? $data['login'] : $data['email'],
                    ':avatar' => $avatar = (isset($data['avatar'])) ? $data['avatar'] : 0,
                    ':email' => $data['email'],
                    //':password'  => $hash_pass,
                    ':role_id' => $role = (isset($data['role_id'])) ? $data['role_id'] : 3,
                    ':status' => $status = (isset($data['status'])) ? $data['status'] : 1,
                    ':id' => (int) $Id,
                ))
                ->execute();

        if ($result) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function delete($Id) {
        $query = DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableName . ' WHERE `id` = :id')
                ->param(':id', (int) $Id)
                ->execute();

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
