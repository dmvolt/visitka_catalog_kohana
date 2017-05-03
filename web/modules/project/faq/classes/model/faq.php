<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Faq {

    protected $tableName = 'faq';
	protected $tableName2 = 'contents_categories';
	protected $tableDesc = 'contents_descriptions';
	
    public function add($data = array()) {
        $result = DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName . ' (date, parent_id, doctor_id, contact, group_id, weight, status) VALUES (:date, :parent_id, :doctor_id, :contact, :group_id, :weight, :status)')
				->parameters(array(		
					':weight' => Security::xss_clean($data['weight']),
					':parent_id' => $data['parent_id'],
					':doctor_id' => $data['doctor_id'],
					':contact' => $data['contact'],
					':group_id' => $data['group_id'],					
					':date' => Security::xss_clean($data['date']),					
					':status' => Security::xss_clean($data['status']),
					))->execute();

        if ($result) {
			if(isset($data['descriptions'])){
				foreach($data['descriptions'] as $lang_id => $value){
					DB::query(Database::INSERT, 'INSERT INTO `' . $this->tableDesc . '` (`content_id`, `lang_id`, `content_title`, `content_teaser`, `content_body`, `module`) VALUES (:content_id, :lang_id, :content_title, :content_teaser, :content_body, :module)')
						->parameters(array(
							':content_id' => $result[0],
							':lang_id' => $lang_id,
							':content_title' => Security::xss_clean($value['title']),
							':content_teaser' => '',
							':content_body' => Security::xss_clean($value['body']),
							':module' => 'faq',
						))->execute();
				}
			}
			return $result[0];           
        } else {
            return FALSE;
        }
    }
	
    public function edit($Id, $data = array()) {
        DB::query(Database::UPDATE, 'UPDATE ' . $this->tableName . ' SET `date` = :date, `group_id` = :group_id, `doctor_id` = :doctor_id, `weight` = :weight, `status` = :status WHERE `id` = :id')
				->parameters(array(
					':id' => $Id, 		
					':date' => Security::xss_clean($data['date']),
					':group_id' => $data['group_id'],
					':doctor_id' => $data['doctor_id'],
					':weight' => Security::xss_clean($data['weight']), 
					':status' => Security::xss_clean($data['status'])
					))->execute();
					
		if(isset($data['descriptions'])){
			foreach($data['descriptions'] as $lang_id => $value){
				$result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableDesc . '` WHERE `content_id` = :content_id AND `module` = :module AND `lang_id` = :lang_id')
                        ->parameters(array(
							':lang_id' => $lang_id,
                            ':content_id' => $Id,
							':module' => 'faq',
                        ))->execute();
						
				if(count($result)>0){
					DB::query(Database::UPDATE, 'UPDATE `' . $this->tableDesc . '` SET `content_title` = :content_title, `content_teaser` = :content_teaser, `content_body` = :content_body WHERE `content_id` = :content_id AND `lang_id` = :lang_id AND `module` = :module')
					->parameters(array(
						':content_id' => (int) $Id,
						':lang_id' => $lang_id,
						':content_title' => Security::xss_clean($value['title']),
						':content_teaser' => '',
						':content_body' => Security::xss_clean($value['body']),
						':module' => 'faq',
					))
					->execute();
				} else {
					DB::query(Database::INSERT, 'INSERT INTO `' . $this->tableDesc . '` (`content_id`, `lang_id`, `content_title`, `content_teaser`, `content_body`, `module`) VALUES (:content_id, :lang_id, :content_title, :content_teaser, :content_body, :module)')
						->parameters(array(
							':content_id' => (int) $Id,
							':lang_id' => $lang_id,
							':content_title' => Security::xss_clean($value['title']),
							':content_teaser' => '',
							':content_body' => Security::xss_clean($value['body']),
							':module' => 'faq',
						))
						->execute();
				}				
			}
		}
		return TRUE;      
    }
	
    public function delete($id) {
        $query = DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableName . ' WHERE `id` = :id')
				->param(':id', (int) $id)
				->execute();
		
		DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableDesc . ' WHERE `content_id` = :id AND `module` = :module')
                ->parameters(array(
					':id' => $id,
					':module' => 'faq',
                ))
                ->execute();
				
        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
	
    public function get_all($is_adminka = 0, $start = 0, $num = 100, $parent_id = 0) {	
		$contents = array();		
        if ($is_adminka) {
            $sql = "SELECT * FROM " . $this->tableName . " WHERE parent_id = :parent_id ORDER BY `weight`, `date` DESC LIMIT :start, :num";
        } else {
            $sql = "SELECT * FROM " . $this->tableName . " WHERE `status` = 1 AND parent_id = :parent_id ORDER BY `weight`, `date` DESC LIMIT :start, :num";
        }
		$result = DB::query(Database::SELECT, $sql)
			->parameters(array(
				':parent_id' => $parent_id,
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
	
	public function get_all_to_doctor($doctor_id, $is_adminka = 0, $start = 0, $num = 100, $parent_id = 0) {	
		$contents = array();		
        if ($is_adminka) {
            $sql = "SELECT * FROM " . $this->tableName . " WHERE parent_id = :parent_id AND doctor_id = :doctor_id ORDER BY `weight`, `date` DESC LIMIT :start, :num";
        } else {
            $sql = "SELECT * FROM " . $this->tableName . " WHERE `status` = 1 AND parent_id = :parent_id AND doctor_id = :doctor_id ORDER BY `weight`, `date` DESC LIMIT :start, :num";
        }
		$result = DB::query(Database::SELECT, $sql)
			->parameters(array(
				':doctor_id' => $doctor_id,
				':parent_id' => $parent_id,
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
	
	public function get_childs($id, $is_adminka = 0) {	
		$contents = array();		
        if ($is_adminka) {
            $sql = "SELECT * FROM " . $this->tableName . " WHERE `parent_id` = :id";
        } else {
            $sql = "SELECT * FROM " . $this->tableName . " WHERE `status` = 1 AND `parent_id` = :id";
        }
		$result = DB::query(Database::SELECT, $sql)
			->parameters(array(
				':id' => (int) $id,
			))->execute();
			
		if (count($result) > 0) {
            foreach ($result as $res) {
                $contents[] = $this->get_content($res['id']);
            }
			return $contents;
        } else {
			return false;
		}
    }
	
	public function get_all_to_cat($cat, $start = 0, $num = 100, $field = 'a.weight, a.date DESC', $parent_id = 0, $is_adminka = 0) {
        $contents = array();
		if ($is_adminka) {
            $sql = 'SELECT * FROM `' . $this->tableName2 . '` cc INNER JOIN ' . $this->tableName . ' a ON cc.content_id = a.id  WHERE cc.category_id = :category_id AND a.parent_id = :parent_id AND cc.module = :module ORDER BY ' . $field . ' LIMIT :start, :num';
        } else {
            $sql = 'SELECT * FROM `' . $this->tableName2 . '` cc INNER JOIN ' . $this->tableName . ' a ON cc.content_id = a.id  WHERE a.status = 1 AND cc.category_id = :category_id AND a.parent_id = :parent_id AND cc.module = :module ORDER BY ' . $field . ' LIMIT :start, :num';
        }
        $query = DB::query(Database::SELECT, $sql)
                ->parameters(array(
                    ':category_id' => $cat, 
					':parent_id' => $parent_id,
                    ':module' => 'faq',
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
        $result = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName . " WHERE parent_id = 0 AND `status` = 1 ORDER BY `date` DESC LIMIT 0, ".$num)
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
			$lang_result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableDesc . '` WHERE `content_id` = :content_id AND `module` = :module')
                        ->parameters(array(
                            ':content_id' => $id,
							':module' => 'faq',
                        ))->execute();
						
			if(count($lang_result)>0){
				foreach($lang_result as $value){
					$descriptions[$value['lang_id']] = array(
						'title' => $value['content_title'],
						'teaser' => $value['content_teaser'],
						'body' => $value['content_body'],
					);
				}
			}
			
			$languages = Kohana::$config->load('language');
			foreach($languages as $value){
				if(!isset($descriptions[$value['lang_id']])){
					$descriptions[$value['lang_id']] = array(
						'title' => '',
						'teaser' => '',
						'body' => '',
					);
				}
			}
			
			$file_obj = new Model_File();
			$files = $file_obj->get_files_by_content_id($id, 'faq');
			if (empty($files)) {
				$filename = false;
			} else {
				$filename = $files[0]['file']->filepathname;
			}
			
			$edit_interface = Liteedit::get_interface($id, 'faq', 'teaser', true);
			
			$contents = array(
				'id' => $result[0]['id'],
				'parent_id' => $result[0]['parent_id'],
				'date' => $result[0]['date'],
				'group_id' => $result[0]['group_id'],
				'doctor_id' => $result[0]['doctor_id'],
				'descriptions' => $descriptions,
				'contact' => $result[0]['contact'],				
				'weight' => $result[0]['weight'],
				'status' => $result[0]['status'],
				'thumb' => $filename,
				'images' => $files,
				'edit_interface' => $edit_interface,
			);
            return $contents; 
		} else {
            return FALSE;
		}
    }
	
	public function get_parent($id = '') {
        $sql = "SELECT category_id FROM " . $this->tableName2 . " WHERE `content_id` = :id  AND `module` = :module";
        $query = DB::query(Database::SELECT, $sql, FALSE)
                ->parameters(array(
                    ':id' => (int) $id, 
                    ':module' => 'faq',
                    ))
                ->execute();
        $result = $query->as_array();
        if (count($result) > 0) {
            foreach ($result as $item) {
                $result2[$item['category_id']] = $item['category_id'];
            } return $result2;
        } else {
            return FALSE;
        }
    }
	
    public function get_total($is_adminka = 0) {
        if ($is_adminka) {
            $sql = "SELECT COUNT(id) AS total FROM " . $this->tableName;
        } else {
            $sql = "SELECT COUNT(id) AS total FROM " . $this->tableName . " WHERE status = 1 AND parent_id = 0";
        } $query = DB::query(Database::SELECT, $sql)->execute();
        $result = $query->as_array();
        $total = $result[0]['total'];
        return $total;
    }
}