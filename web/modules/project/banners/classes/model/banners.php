<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Banners {

    protected $tableName = 'banners';
    protected $session;
	
    public function __construct() {
        $this->session = Session::instance();
    }
	
    public function add($data = array()) {
        $data = Arr::extract($data, array('title', 'display_pages', 'display_all', 'status'));
        $vData = $data;
        $validation = Validation::factory($vData);
        $validation->rule('title', 'not_empty');
        $validation->rule('title', 'min_length', array(':value', '3'));
        $validation->rule('title', 'max_length', array(':value', '64'));
        if (!$validation->check()) {
            $this->errors = $validation->errors('catErrors');
            return FALSE;
        }
        DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName . ' (title, display_pages, display_all, status) VALUES (:title, :display_pages, :display_all, :status)')
                ->parameters(array(
                    ':title' => Security::xss_clean($data['title']),
                    ':display_pages' => $data['display_pages'],
                    ':display_all' => Security::xss_clean($data['display_all']),
                    ':status' => Security::xss_clean($data['status'])
                ))
                ->execute();
				
        $last_id = mysql_insert_id();
        if ($last_id) {
            return $last_id;
        } else {
            return FALSE;
        }
    }
	
    public function edit($Id, $data = array()) {
        $data = Arr::extract($data, array('title', 'display_pages', 'display_all', 'status'));
        $vData = $data;
        $validation = Validation::factory($vData);
        $validation->rule('title', 'not_empty');
        $validation->rule('title', 'min_length', array(':value', '3'));
        $validation->rule('title', 'max_length', array(':value', '64'));
        if (!$validation->check()) {
            $this->errors = $validation->errors('catErrors');
            return FALSE;
        }
        DB::query(Database::UPDATE, 'UPDATE ' . $this->tableName . ' SET `title` = :title, `display_pages` = :display_pages, `display_all` = :display_all, `status` = :status WHERE `id` = :id')
                ->parameters(array(
                    ':id' => $Id,
                    ':title' => Security::xss_clean($data['title']),
                    ':display_pages' => $data['display_pages'],
                    ':display_all' => Security::xss_clean($data['display_all']),
                    ':status' => Security::xss_clean($data['status'])
                ))
                ->execute();
		return TRUE;
    }
	
    public function delete($id) {
        $query = DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableName . ' WHERE `id` = :id')
                ->param(':id', (int) $id)
                ->execute();
        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
	
    public function get_all($is_adminka = 0) {
		$contents = array();
        if ($is_adminka) {
            $sql = "SELECT * FROM " . $this->tableName;
        } else {
            $sql = "SELECT * FROM " . $this->tableName . " WHERE `status` = 1";
        }
        $result = DB::query(Database::SELECT, $sql)
                        ->execute();
						
		if (count($result) > 0) {
            foreach ($result as $res) {
                $contents[] = $this->get_content($res['id']);
            }
        }
        return $contents;
    }
	
	public function get_last_content() {
        $sql = "SELECT * FROM " . $this->tableName . " WHERE `status` = 1 LIMIT 0,1";
        $query = DB::query(Database::SELECT, $sql, FALSE)
                ->execute();
        $result = $query->as_array();
        if (count($result)>0){
			$file_obj = new Model_File();
			$files = $file_obj->get_files_by_content_id($result[0]['id'], 'banners');
			
			$contents = array(
				'id' => $result[0]['id'],
				'title' => $result[0]['title'],
				'display_pages' => $result[0]['display_pages'],
				'display_all' => $result[0]['display_all'],			
				'status' => $result[0]['status'],
				'files' => $files,
				
			);
			return $contents;
		} else {
			return false;
		}   
    }
	
    public function get_content($id = '') {
        $sql = "SELECT * FROM " . $this->tableName . " WHERE `id` = :id";
        $query = DB::query(Database::SELECT, $sql, FALSE)
                ->param(':id', (int) $id)
                ->execute();
        $result = $query->as_array();
        if (count($result)>0){
			$file_obj = new Model_File();
			$files = $file_obj->get_files_by_content_id($id, 'banners');
			
			$contents = array(
				'id' => $result[0]['id'],
				'title' => $result[0]['title'],
				'display_pages' => $result[0]['display_pages'],
				'display_all' => $result[0]['display_all'],			
				'status' => $result[0]['status'],
				'files' => $files,
				
			);
			return $contents;
		} else {
			return false;
		}   
    }
}