<?php

defined('SYSPATH') or die('No direct script access.');

class Model_News {

    protected $tableName = 'news';
	protected $tableName2 = 'poll';
	protected $tableDesc = 'contents_descriptions';

    public function add($data = array()) {
        DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName . ' (date, `timestamp`, alias, weight, `type`, status) VALUES (:date, :timestamp, :alias, :weight, :type, :status)')
				->parameters(array(		
					':alias' => Security::xss_clean($data['alias']),
					':weight' => Security::xss_clean($data['weight']), 
					':date' => Security::xss_clean($data['date']),
					':timestamp' => time(), 
					':type' => Security::xss_clean($data['type']),
					':status' => Security::xss_clean($data['status'])
					))->execute();
					
        $query = DB::query(Database::SELECT, 'SELECT id FROM `' . $this->tableName . '` WHERE `alias` = :alias')
                ->parameters(array(
					':alias' => Security::xss_clean($data['alias']),
                ));
				
        $result = $query->execute();

        if (count($result) > 0) {
			if(isset($data['descriptions'])){
				foreach($data['descriptions'] as $lang_id => $value){
					DB::query(Database::INSERT, 'INSERT INTO `' . $this->tableDesc . '` (`content_id`, `lang_id`, `content_title`, `content_teaser`, `content_body`, `content_text_field`, `module`) VALUES (:content_id, :lang_id, :content_title, :content_teaser, :content_body, :content_poll, :module)')
						->parameters(array(
							':content_id' => (int) $result[0]['id'],
							':lang_id' => $lang_id,
							':content_title' => Security::xss_clean($value['title']),
							':content_teaser' => $value['teaser'],
							':content_body' => $value['body'],
							':content_poll' => Security::xss_clean($value['poll']),
							':module' => 'news',
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
        DB::query(Database::UPDATE, 'UPDATE ' . $this->tableName . ' SET `date` = :date, `alias` = :alias, `weight` = :weight, `type` = :type, `status` = :status WHERE `id` = :id')
				->parameters(array(
					':id' => $Id, 		
					':date' => Security::xss_clean($data['date']), 		
					':alias' => Security::xss_clean($data['alias']), 		
					':weight' => Security::xss_clean($data['weight']), 
					':type' => Security::xss_clean($data['type']),
					':status' => Security::xss_clean($data['status'])
					))->execute();
					
		if(isset($data['descriptions'])){
			foreach($data['descriptions'] as $lang_id => $value){
				$result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableDesc . '` WHERE `content_id` = :content_id AND `module` = :module AND `lang_id` = :lang_id')
                        ->parameters(array(
							':lang_id' => $lang_id,
                            ':content_id' => $Id,
							':module' => 'news',
                        ))->execute();
						
				if(count($result)>0){
					DB::query(Database::UPDATE, 'UPDATE `' . $this->tableDesc . '` SET `content_title` = :content_title, `content_teaser` = :content_teaser, `content_body` = :content_body, `content_text_field` = :content_poll WHERE `content_id` = :content_id AND `lang_id` = :lang_id AND `module` = :module')
					->parameters(array(
						':content_id' => (int) $Id,
						':lang_id' => $lang_id,
						':content_title' => Security::xss_clean($value['title']),
						':content_teaser' => $value['teaser'],
						':content_body' => $value['body'],
						':content_poll' => Security::xss_clean($value['poll']),
						':module' => 'news',
					))
					->execute();
				} else {
					DB::query(Database::INSERT, 'INSERT INTO `' . $this->tableDesc . '` (`content_id`, `lang_id`, `content_title`, `content_teaser`, `content_body`, `content_text_field`, `module`) VALUES (:content_id, :lang_id, :content_title, :content_teaser, :content_body, :content_poll, :module)')
						->parameters(array(
							':content_id' => (int) $Id,
							':lang_id' => $lang_id,
							':content_title' => Security::xss_clean($value['title']),
							':content_teaser' => $value['teaser'],
							':content_body' => $value['body'],
							':content_poll' => Security::xss_clean($value['poll']),
							':module' => 'news',
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
					':module' => 'news',
                ))
                ->execute();
				
        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function get_all($is_adminka = 0, $start = 0, $num = 100, $lang_id = 1, $query = '') {	
		$contents = array();		
        if ($is_adminka) {
            $sql = "SELECT * FROM " . $this->tableName . " ORDER BY `weight`, `date` DESC LIMIT :start, :num";
        } else {
            $sql = "SELECT * FROM " . $this->tableName . " WHERE `status` = 1".$query." ORDER BY `date` DESC LIMIT :start, :num";
        }

		$result = DB::query(Database::SELECT, $sql)
			->parameters(array(
				':start' => (int) $start, 
				':num' => (int) $num,
			))->execute();
			
		if (count($result) > 0) {
            foreach ($result as $res) {
                $contents[] = $this->get_content($res['id'], $lang_id);
            }
        }
        return $contents;
    }
	
/*** Get News * @return array */

    public function get_all_news($is_adminka = 0, $start = 0, $num = 100, $lang_id = 1) {	
		$contents = array();		
        if ($is_adminka) {
            $sql = "SELECT * FROM " . $this->tableName . " WHERE `type` = 0  ORDER BY `weight`, `timestamp` DESC LIMIT :start, :num";
        } else {
            $sql = "SELECT * FROM " . $this->tableName . " WHERE `status` = 1 AND `type` = 0 ORDER BY `weight`, `timestamp` DESC LIMIT :start, :num";
        }

		$result = DB::query(Database::SELECT, $sql)
			->parameters(array(
				':start' => (int) $start, 
				':num' => (int) $num,
			))->execute();
			
		if (count($result) > 0) {
            foreach ($result as $res) {
                $contents[] = $this->get_content($res['id'], $lang_id);
            }
        }
        return $contents;
    }
	
/*** Get Polls * @return array */

    public function get_all_polls($is_adminka = 0, $start = 0, $num = 100, $lang_id = 1) {	
		$contents = array();		
        if ($is_adminka) {
            $sql = "SELECT * FROM " . $this->tableName . " WHERE `type` = 1  ORDER BY `weight` LIMIT :start, :num";
        } else {
            $sql = "SELECT * FROM " . $this->tableName . " WHERE `status` = 1 AND `type` = 1 ORDER BY `weight` LIMIT :start, :num";
        }

		$result = DB::query(Database::SELECT, $sql)
			->parameters(array(
				':start' => (int) $start, 
				':num' => (int) $num,
			))->execute();
			
		if (count($result) > 0) {
            foreach ($result as $res) {
                $contents[] = $this->get_content($res['id'], $lang_id);
            }
        }
        return $contents;
    }

    public function get_last($num = 4) {	
		$contents = array();		
        $result = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName . " WHERE `status` = 1 ORDER BY `timestamp` DESC LIMIT 0, ".$num)
					->execute();
		
		if (count($result) > 0) {
            foreach ($result as $res) {
                $contents[] = $this->get_content($res['id']);
            }
        }
        return $contents;		
    }
	
	public function get_last_poll($num = 1, $lang_id = 1) {	
		$contents = array();		
        $result = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName . " WHERE `status` = 1 AND `type` = 1 LIMIT 0, ".$num)
					->execute();
		
		if (count($result) > 0) {
            foreach ($result as $res) {
                $contents[] = $this->get_content($res['id'], $lang_id);
            }
        }
        return $contents;		
    }

    public function get_content($id = '', $lang_id = 1) {
	
        $sql = "SELECT * FROM " . $this->tableName . " WHERE `id` = :id";
        $query = DB::query(Database::SELECT, $sql, FALSE)
			->param(':id', (int) $id)
			->execute();
			
        $result = $query->as_array();
		
        if ($result){
			$lang_result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableDesc . '` WHERE `content_id` = :content_id AND `module` = :module')
                        ->parameters(array(
                            ':content_id' => $id,
							':module' => 'news',
                        ))->execute();
						
			if(count($lang_result)>0){
				foreach($lang_result as $value){
					$descriptions[$value['lang_id']] = array(
						'title' => $value['content_title'],
						'teaser' => $value['content_teaser'],
						'body' => $value['content_body'],
						'poll' => $value['content_text_field'],
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
						'poll' => '',
					);
				}
			}
			
			$polls = false;
			
			if($result[0]['type']){
				if(!empty($descriptions[$lang_id]['poll'])){
					$polls_arr = explode(',', $descriptions[$lang_id]['poll']);
					if(is_array($polls_arr) AND count($polls_arr)>1){
						$polls = $polls_arr;
					}
				}
			}
			
			$file_obj = new Model_File();
			$files = $file_obj->get_files_by_content_id($id, 'news');

			if (empty($files)) {
				$filename = false;
			} else {
				$filename = $files[0]['file']->filepathname;
			}
			
			$edit_interface = Liteedit::get_interface($id, 'news', 'teaser', true);
			
			$contents = array(
				'id' => $result[0]['id'],
				'lang_id' => $lang_id,
				'date' => $result[0]['date'],
				'descriptions' => $descriptions,
				'alias' => $result[0]['alias'],
				'timestamp' => $result[0]['timestamp'],			
				'weight' => $result[0]['weight'],
				'status' => $result[0]['status'],
				'type' => $result[0]['type'],
				'polls' => $polls,
				'thumb' => $filename,
				'images' => $files,
				'edit_interface' => $edit_interface,
			);
            return $contents; 
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
	
	public function set_poll($poll_id = 0, $poll_lang_id = 1, $poll_result = '', $ip = '') {
        DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName2 . ' (lang_id, `news_id`, `result`, `ip`) VALUES (:lang_id, :news_id, :result, :ip)')
				->parameters(array(		
					':news_id' => $poll_id,
					':lang_id' => $poll_lang_id, 
					':result' => $poll_result,
					':ip' => $ip,
					))->execute();
		return true;
    }
	
	public function get_poll_result($id = 0, $poll = '', $lang_id = 1) {
        $result = DB::query(Database::SELECT, 'SELECT * FROM ' . $this->tableName2 . ' WHERE news_id = :news_id AND lang_id = :lang_id AND result = :result')
				->parameters(array(		
					':news_id' => $id,
					':lang_id' => $lang_id, 
					':result' => $poll,
					))->execute();
		return count($result);
    }
}