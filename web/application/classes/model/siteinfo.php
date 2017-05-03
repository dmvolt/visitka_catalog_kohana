<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Siteinfo {

    protected $tableName = 'siteinfo';
	protected $tableDesc = 'contents_descriptions';
	
    public function get_siteinfo($Id) {
	
		$content = array();
		
        $result = DB::query(Database::SELECT, 'SELECT * FROM ' . $this->tableName . ' WHERE `id` = :id', TRUE)
                ->as_object()
                ->param(':id', $Id)
                ->execute();
				
		$lang_result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableDesc . '` WHERE `content_id` = :content_id AND `module` = :module')
                        ->parameters(array(
                            ':content_id' => $Id,
							':module' => 'siteinfo',
                        ))->execute();
						
		if(count($lang_result)>0){
			foreach($lang_result as $value){
				$descriptions[$value['lang_id']] = array(
					'site_name' => $value['content_title'],
					'teaser' => $value['content_teaser'],
					'body' => $value['content_body'],
					'site_slogan' => $value['content_var_field1'],
					'site_copyright' => $value['content_var_field2'],
					'site_licence' => $value['content_text_field'],
				);
			}
			
		}
		
		$languages = Kohana::$config->load('language');
		foreach($languages as $value){
			if(!isset($descriptions[$value['lang_id']])){
				$descriptions[$value['lang_id']] = array(
					'site_name' => '',
					'teaser' => '',
					'body' => '',
					'site_slogan' => '',
					'site_copyright' => '',
					'site_licence' => '',
				);
			}
		}		
		
		$content = array(
			'id' => $result[0]->id,
			'email' => $result[0]->email,
			'email1' => $result[0]->email1,
			'email2' => $result[0]->email2,
			'email3' => $result[0]->email3,
			'email4' => $result[0]->email4,
			'email5' => $result[0]->email5,
			'email6' => $result[0]->email6,
			'email7' => $result[0]->email7,
			'email8' => $result[0]->email8,
			'email9' => $result[0]->email9,
			'email10' => $result[0]->email10,
			'tell' => $result[0]->tell,
			'site_counter' => $result[0]->counter,
			'site_map' => $result[0]->map,
			'descriptions' => $descriptions,
		);
        return $content;
    }
	
    public function edit($Id, $data = array()) {
        DB::query(Database::UPDATE, 'UPDATE ' . $this->tableName . ' SET email = :email, email1 = :email1, email2 = :email2, email3 = :email3, email4 = :email4, email5 = :email5, email6 = :email6, email7 = :email7, email8 = :email8, email9 = :email9, email10 = :email10, tell = :tell, `counter` = :counter, `map` = :map WHERE id = :id')
                ->parameters(array(     
                    ':email' => Security::xss_clean($data['site_email']),
					':email1' => Security::xss_clean($data['site_email1']),
					':email2' => Security::xss_clean($data['site_email2']),
					':email3' => Security::xss_clean($data['site_email3']),
					':email4' => Security::xss_clean($data['site_email4']),
					':email5' => Security::xss_clean($data['site_email5']),
					':email6' => Security::xss_clean($data['site_email6']),
					':email7' => Security::xss_clean($data['site_email7']),
					':email8' => Security::xss_clean($data['site_email8']),
					':email9' => Security::xss_clean($data['site_email9']),
					':email10' => Security::xss_clean($data['site_email10']),
                    ':tell' => Security::xss_clean($data['site_tell']),
					':counter' => $data['site_counter'],
					':map' => $data['site_map'],
                    ':id' => $Id,
                ))
                ->execute();
		if(isset($data['descriptions'])){
			foreach($data['descriptions'] as $lang_id => $value){
				$result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableDesc . '` WHERE `content_id` = :content_id AND `module` = :module AND `lang_id` = :lang_id')
						->parameters(array(
							':lang_id' => $lang_id,
							':content_id' => $Id,
							':module' => 'siteinfo',
						))->execute();
						
				if(count($result)>0){
					DB::query(Database::UPDATE, 'UPDATE `' . $this->tableDesc . '` SET `content_title` = :content_title, `content_teaser` = :content_teaser, `content_body` = :content_body, `content_var_field1` = :slogan, `content_var_field2` = :copyright, `content_text_field` = :licence WHERE `content_id` = :content_id AND `lang_id` = :lang_id AND `module` = :module')
					->parameters(array(
						':content_id' => (int) $Id,
						':lang_id' => $lang_id,
						':content_title' => Security::xss_clean($value['site_name']),
						':content_teaser' => Security::xss_clean($value['teaser']),
						':content_body' => Security::xss_clean($value['body']),
						':slogan' => Security::xss_clean($value['site_slogan']),
						':licence' => Security::xss_clean($value['site_licence']),
						':copyright' => Security::xss_clean($value['site_copyright']),
						':module' => 'siteinfo',
					))
					->execute();
				} else {
					DB::query(Database::INSERT, 'INSERT INTO `' . $this->tableDesc . '` (`content_id`, `lang_id`, `content_title`, `content_teaser`, `content_body`, `content_var_field1`, `content_var_field2`, `content_text_field`, `module`) VALUES (:content_id, :lang_id, :content_title, :content_teaser, :content_body, :slogan, :copyright, :licence, :module)')
						->parameters(array(
							':content_id' => (int) $Id,
							':lang_id' => $lang_id,
							':content_title' => Security::xss_clean($value['site_name']),
							':content_teaser' => Security::xss_clean($value['teaser']),
							':content_body' => Security::xss_clean($value['body']),
							':slogan' => Security::xss_clean($value['site_slogan']),
							':licence' => Security::xss_clean($value['site_licence']),
							':copyright' => Security::xss_clean($value['site_copyright']),
							':module' => 'siteinfo',
						))
						->execute();
				}			
			}
		}
		return TRUE;
    }
}