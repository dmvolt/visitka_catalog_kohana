<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Pages {

    protected $errors = array();
    protected $tableName = 'pages';
	protected $tableDesc = 'contents_descriptions';
    protected $tableName3 = 'contents_files';
	
    public function getMaterialsByCategory($category_id) {
        return DB::select()
                        ->from('materials')
                        ->where('category_id', '=', $category_id)
                        ->execute()
                        ->as_array();
    }
	
    public function add($data = array()) {
        $query = DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName . ' (alias, weight, status, in_front) VALUES (:alias, :weight, :status, :in_front)')
                ->parameters(array(
                    ':alias' => Security::xss_clean($data['alias']),
                    ':weight' => Security::xss_clean($data['weight']),
                    ':status' => Security::xss_clean($data['status']),
					':in_front' => Security::xss_clean($data['in_front']),
                ))
                ->execute();
       
        $result = DB::query(Database::SELECT, "SELECT id FROM " . $this->tableName . " WHERE `alias` = :alias")
                    ->param(':alias', Security::xss_clean($data['alias']))
                    ->execute();
        if ($result) {		
			if(isset($data['descriptions'])){
				foreach($data['descriptions'] as $lang_id => $value){
					DB::query(Database::INSERT, 'INSERT INTO `' . $this->tableDesc . '` (`content_id`, `lang_id`, `content_title`, `content_teaser`, `content_body`, `module`) VALUES (:content_id, :lang_id, :content_title, :content_teaser, :content_body, :module)')
						->parameters(array(
							':content_id' => (int) $result[0]['id'],
							':lang_id' => $lang_id,
							':content_title' => Security::xss_clean($value['title']),
							':content_teaser' => '',
							':content_body' => $value['body'],
							':module' => 'pages',
						))
						->execute();
				}
			}
            return $result[0]['id'];
        } else {
            return FALSE;
        }
    }
	
    public function edit($Id, $data = array()) {
        DB::query(Database::UPDATE, 'UPDATE ' . $this->tableName . ' SET `alias` = :alias, `weight` = :weight, `status` = :status, `in_front` = :in_front WHERE `id` = :id')
                ->parameters(array(
                    ':id' => $Id,
                    ':alias' => Security::xss_clean($data['alias']),
                    ':weight' => Security::xss_clean($data['weight']),
                    ':status' => Security::xss_clean($data['status']),
					':in_front' => Security::xss_clean($data['in_front']),
                ))
                ->execute();
				
		if(isset($data['descriptions'])){
			foreach($data['descriptions'] as $lang_id => $value){
				$result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableDesc . '` WHERE `content_id` = :content_id AND `module` = :module AND `lang_id` = :lang_id')
                        ->parameters(array(
							':lang_id' => $lang_id,
                            ':content_id' => $Id,
							':module' => 'pages',
                        ))->execute();
						
				if(count($result)>0){
					DB::query(Database::UPDATE, 'UPDATE `' . $this->tableDesc . '` SET `content_title` = :content_title, `content_teaser` = :content_teaser, `content_body` = :content_body WHERE `content_id` = :content_id AND `lang_id` = :lang_id AND `module` = :module')
					->parameters(array(
						':content_id' => (int) $Id,
						':lang_id' => $lang_id,
						':content_title' => Security::xss_clean($value['title']),
						':content_teaser' => '',
						':content_body' => $value['body'],
						':module' => 'pages',
					))
					->execute();
				} else {
					DB::query(Database::INSERT, 'INSERT INTO `' . $this->tableDesc . '` (`content_id`, `lang_id`, `content_title`, `content_teaser`, `content_body`, `module`) VALUES (:content_id, :lang_id, :content_title, :content_teaser, :content_body, :module)')
						->parameters(array(
							':content_id' => (int) $Id,
							':lang_id' => $lang_id,
							':content_title' => Security::xss_clean($value['title']),
							':content_teaser' => '',
							':content_body' => $value['body'],
							':module' => 'pages',
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
					':module' => 'pages',
                ))
                ->execute();
        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    /**
     * Get all articles
     * @return array
     */
    public function get_all($is_adminka = 0) {
		$contents = array();		
        if ($is_adminka) {
            $sql = "SELECT * FROM " . $this->tableName . " ORDER BY weight";
        } else {
            $sql = "SELECT * FROM " . $this->tableName . " WHERE `status` = 1 ORDER BY weight";
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
	
	public function get_in_front_pages() {
		$contents = array();		
		$result = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName . " WHERE `status` = 1 AND `in_front` = 1 ORDER BY weight")
			->execute();
		
		if (count($result) > 0) {
            foreach ($result as $res) {
                $contents[] = $this->get_content($res['id']);
            }
        }
        return $contents;    
    }
	
    public function get_content($id = '') {
        if (is_numeric($id)) {
            $sql = "SELECT * FROM " . $this->tableName . " WHERE `id` = :id";
            $query = DB::query(Database::SELECT, $sql, FALSE)
                    ->param(':id', (int) $id)
                    ->execute();
        } else {
            $sql = "SELECT * FROM " . $this->tableName . " WHERE `alias` = :alias";
            $query = DB::query(Database::SELECT, $sql, FALSE)
                    ->param(':alias', $id)
                    ->execute();
        }
        $result = $query->as_array();
        if ($result){
		
			$lang_result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableDesc . '` WHERE `content_id` = :content_id AND `module` = :module')
                        ->parameters(array(
                            ':content_id' => $result[0]['id'],
							':module' => 'pages',
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
			$files = $file_obj->get_files_by_content_id($result[0]['id'], 'pages');
			if (empty($files)) {
				$filename = false;
			} else {
				$filename = $files[0]['file']->filepathname;
			}
			
			$edit_interface = Liteedit::get_interface($result[0]['id'], 'pages', 'teaser', true);
			
			$contents = array(
				'id' => $result[0]['id'],				
				'descriptions' => $descriptions,
				'alias' => $result[0]['alias'],				
				'weight' => $result[0]['weight'],				
				'status' => $result[0]['status'],
				'in_front' => $result[0]['in_front'],
				'thumb' => $filename,
				'images' => $files,
				'edit_interface' => $edit_interface,
			);
		
            return $contents;
        } else {
            return FALSE;
		}
    }
}