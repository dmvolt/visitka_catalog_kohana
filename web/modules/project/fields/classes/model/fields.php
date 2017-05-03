<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Fields {

    protected $tableName = 'fields';
    protected $tableName2 = 'contents_fields';

    public function add($Id, $add_data = array(), $module = 'pages') {
		$this->delete($Id, $module);
		if (!empty($add_data)) {
            foreach ($add_data as $data) {		
				DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName . ' (lang_id, field0, field1) VALUES (:lang_id, :field0, :field1)')
						->parameters(array(
							':field0' => (isset($data[0]) AND !empty($data[0])) ? Security::xss_clean($data[0]) : 'http://',
							':field1' => (isset($data[1]) AND !empty($data[1])) ? Security::xss_clean($data[1]) : 'Загрузить',
							':lang_id' => 1,
						))
						->execute();
						
				$fields_id = mysql_insert_id();
				
				if($fields_id){		
					DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName2 . ' (content_id, field_id, module) VALUES (:content_id, :field_id, :module)')
							->parameters(array(
								':content_id' => $Id,
								':field_id' => $fields_id,
								':module' => $module,
							))
							->execute();
				}
			}
			return TRUE;
		} else {
			return FALSE;
		}
    }

    public function delete($Id, $module = 'pages') {	
		$result = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName2 . " WHERE `content_id` = :content_id AND `module` = :module")
                    ->parameters(array(
                        ':content_id' => $Id,
                        ':module' => $module,
                    ))
                    ->execute();
					
		if($result AND count($result)>0){
			foreach($result as $value){
				DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableName . ' WHERE `id` = :id')
					->parameters(array(
						':id' => $value['field_id'],
					))
					->execute();
			}
		}
		
        DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableName2 . ' WHERE `content_id` = :content_id AND `module` = :module')
                ->parameters(array(
                    ':content_id' => $Id,
                    ':module' => $module,
                ))
                ->execute();  
		return TRUE;  
    }
	
	public function delete_by_content($Id, $module = 'pages') {	
		$result = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName2 . " WHERE `content_id` = :content_id AND `module` = :module")
                    ->parameters(array(
                        ':content_id' => $Id,
                        ':module' => $module,
                    ))
                    ->execute();
					
		if($result AND count($result)>0){
			foreach($result as $value){
				DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableName . ' WHERE `id` = :id')
					->parameters(array(
						':id' => $value['field_id'],
					))
					->execute();
			}
		}
		
        DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableName2 . ' WHERE `content_id` = :content_id AND `module` = :module')
                ->parameters(array(
                    ':content_id' => $Id,
                    ':module' => $module,
                ))
                ->execute();  
		return TRUE;  
    }

    public function get_fields_to_content($Id, $module = 'pages') {
	
		$result = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName2 . " WHERE `content_id` = :content_id AND `module` = :module")
				->parameters(array(
					':content_id' => $Id,
					':module' => $module,
				))
				->execute();
				
		if($result AND count($result)>0){
			foreach ($result as $value) {
				$result2 = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName . " WHERE `id` = :field_id")
						->param(':field_id', $value['field_id'])
						->execute();

				$fields[] = array(
					'id' => $value['field_id'],
					'field0' => $result2[0]['field0'],
					'field1' => $result2[0]['field1'],
				);
			}
		} else {
			$fields = false;
		}		
		return $fields;
    }
}