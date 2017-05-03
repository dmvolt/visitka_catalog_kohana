<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Appointments {

    protected $tableName = 'appointments';
	
    public function add($data = array()) {
        $result = DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName . ' (date, doctor_id, category_id, `name`, `contact`, `time`, weight, status) VALUES (:date, :doctor_id, :category_id, :name, :contact, :time, :weight, :status)')
				->parameters(array(		
					':weight' => Security::xss_clean($data['weight']),
					':doctor_id' => $data['doctor_id'],
					':category_id' => $data['category_id'],					
					':date' => Security::xss_clean($data['date']),	
					':name' => Security::xss_clean($data['name']),
					':contact' => Security::xss_clean($data['contact']),
					':time' => Security::xss_clean($data['time']),					
					':status' => Security::xss_clean($data['status']),
					))->execute();

        if ($result) {
			return $result[0];           
        } else {
            return FALSE;
        }
    }
	
    public function edit($Id, $data = array()) {
        DB::query(Database::UPDATE, 'UPDATE ' . $this->tableName . ' SET `date` = :date, `doctor_id` = :doctor_id, `category_id` = :category_id, `name` = :name, `contact` = :contact, `time` = :time, `weight` = :weight, `status` = :status WHERE `id` = :id')
				->parameters(array(
					':id' => $Id, 		
					':weight' => Security::xss_clean($data['weight']),
					':doctor_id' => $data['doctor_id'],
					':category_id' => $data['category_id'],					
					':date' => Security::xss_clean($data['date']),	
					':name' => Security::xss_clean($data['name']),
					':contact' => Security::xss_clean($data['contact']),
					':time' => Security::xss_clean($data['time']),					
					':status' => Security::xss_clean($data['status']),
					))->execute();
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
	
    public function get_all($is_adminka = 0, $start = 0, $num = 100) {	
		$contents = array();		
        if ($is_adminka) {
            $sql = "SELECT * FROM " . $this->tableName . " ORDER BY `weight`, `date` DESC LIMIT :start, :num";
        } else {
            $sql = "SELECT * FROM " . $this->tableName . " WHERE `status` = 1 ORDER BY `weight`, `date` DESC LIMIT :start, :num";
        }
		$result = DB::query(Database::SELECT, $sql)
			->parameters(array(
				':start' => (int) $start, 
				':num' => (int) $num,
			))->execute();
			
		if (count($result) > 0) {
            foreach ($result as $res) {
                $contents[] = $this->get_content($res['id']);
            }
        }
        return $contents;
    }
	
	public function get_all_to_cat($cat, $start = 0, $num = 100, $field = 'weight, date DESC', $is_adminka = 0) {
        $contents = array();
		if ($is_adminka) {
            $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE category_id = :category_id ORDER BY ' . $field . ' LIMIT :start, :num';
        } else {
            $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE status = 1 AND category_id = :category_id ORDER BY ' . $field . ' LIMIT :start, :num';
        }
        $query = DB::query(Database::SELECT, $sql)
                ->parameters(array(
                    ':category_id' => $cat, 
                    ':start' => (int) $start, 
                    ':num' => (int) $num,
                    ))
                ->execute();
        $result = $query->as_array();
        if (count($result) > 0) {
            foreach ($result as $res) {
                $contents[] = $this->get_content($res['id']);
            }
        }
        return $contents;
    }
	
    public function get_last($num = 1) {	
		$contents = array();
        $result = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName . " WHERE `status` = 1 ORDER BY `date` DESC LIMIT 0, ".$num)
				->execute();
		if (count($result) > 0) {
            foreach ($result as $res) {
                $contents[] = $this->get_content($res['id']);
            }
        }
        return $contents;		
    }
	
    public function get_content($id = '') {
        $sql = "SELECT * FROM " . $this->tableName . " WHERE `id` = :id";
        $query = DB::query(Database::SELECT, $sql, FALSE)
			->param(':id', (int) $id)
			->execute();
			
        $result = $query->as_array();
		
        if ($result){
            return $result[0]; 
		} else {
            return FALSE;
		}
    }
	
    public function get_total($is_adminka = 0) {
        if ($is_adminka) {
            $sql = "SELECT COUNT(id) AS total FROM " . $this->tableName;
        } else {
            $sql = "SELECT COUNT(id) AS total FROM " . $this->tableName . " WHERE status = 1";
        } $query = DB::query(Database::SELECT, $sql)->execute();
        $result = $query->as_array();
        $total = $result[0]['total'];
        return $total;
    }
}