<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Doimages {

    protected $tableName = 'doimages';
    protected $tableName2 = 'contents_doimages';
    protected $tableName3 = 'doimages_description';
    protected $errors = array();
    protected $session;
	
    public function __construct() {
        $this->session = Session::instance();
    }
	
    public function get_files_by_content_id($Id, $module = 'products', $is_image = 1) {
        $doimagesdata = array();
		
        $doimagesinfo = DB::query(Database::SELECT, 'SELECT * FROM ' . $this->tableName2 . ' WHERE `content_id` = :id AND `module` = :module ORDER BY `delta`', TRUE)
                ->as_object()
                ->parameters(array(
                    ':id' => $Id,
                    ':module' => $module
                ))
                ->execute();
        if ($doimagesinfo AND count($doimagesinfo)>0) {
            foreach ($doimagesinfo as $data) {
                $doimagesobject = DB::query(Database::SELECT, 'SELECT * FROM ' . $this->tableName . ' WHERE `id` = :id', TRUE)
                        ->as_object()
                        ->param(':id', $data->file_id)
                        ->execute();						
				$doimages_description = $this->get_files_description($data->file_id);
                $doimagesdata[] = array(
					'file' => $doimagesobject[0],
					'description' => $doimages_description,
				);
            }
        }
        return $doimagesdata;
    }
	
	public function get_files_by_content($Id, $module = 'products', $is_image = 1) {
        return DB::query(Database::SELECT, 'SELECT * FROM ' . $this->tableName2 . ' WHERE `content_id` = :id AND `is_image` = :is_image AND `module` = :module')
                ->parameters(array(
                    ':id' => $Id,
					':is_image' => $is_image,
                    ':module' => $module,
                ))
                ->execute();
    }
	
    public function get_files_by_session($is_image = 1) {
        $doimagesdata = array();
		
		$doimagesinfo = $this->session->get('add_doimages', 0);
        	
        if ($doimagesinfo) {
            foreach ($doimagesinfo as $data) {
                $doimagesobject = DB::query(Database::SELECT, 'SELECT * FROM ' . $this->tableName . ' WHERE `id` = :id', TRUE)
                        ->as_object()
                        ->param(':id', $data)
                        ->execute();
                $doimagesdata[] = array(
					'file' => $doimagesobject[0],
					'description' => false,
				);
            }
        }
        return $doimagesdata;
    }
	
    public function get_files_description($file_id) {
        $doimagesdescription = DB::query(Database::SELECT, 'SELECT * FROM ' . $this->tableName3 . ' WHERE `file_id` = :file_id', TRUE)
                ->as_object()
                ->param(':file_id', $file_id)
                ->execute();
		if(count($doimagesdescription)>0){
			foreach($doimagesdescription as $value){
				$descriptions[$value->lang_id] = array(
					'title' => $value->title,
					'link' => $value->link,
					'description' => $value->description,
				);
			}
		}
		$languages = Kohana::$config->load('language');
		foreach($languages as $value){
		if(!isset($descriptions[$value['lang_id']])){
				$descriptions[$value['lang_id']] = array(
					'title' => '',
					'link' => '',
					'description' => '',
				);
			}
		}
		if (isset($descriptions)) {
            return $descriptions;
        } else {
            return false;
        }
    }
	
    public function getErrors() {
        return $this->errors;
    }
	
    public function add($Id = 0, $module = 'products', $info = array()) {
	
        if ($Id != 0) {
            $max = DB::query(Database::SELECT, 'SELECT MAX(delta) AS maxdelta FROM ' . $this->tableName2 . ' WHERE `content_id` = :id AND `module` = :module', TRUE)
                    ->as_object()
                    ->parameters(array(
                        ':id' => $Id,
                        ':module' => $module
                    ))
                    ->execute();
        }
        foreach ($info as $delta => $data) {
            $result = DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName . ' (filename, filepathname, filesize, filetype, fileurl) VALUES (:filename, :filepathname, :filesize, :filetype, :fileurl)')
                    ->parameters(array(
                        ':filename' => Security::xss_clean($data->name),
                        ':filepathname' => Security::xss_clean($data->pathname),
                        ':filesize' => Security::xss_clean($data->size),
                        ':filetype' => Security::xss_clean($data->type),
                        ':fileurl' => Security::xss_clean($data->url)
                    ))
                    ->execute();

            if ($result) {
                if ($Id != 0) {
                    $query2 = DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName2 . ' (file_id, content_id, delta, is_image, module) VALUES (:file_id, :content_id, :delta, :is_image, :module)')
                            ->parameters(array(
                                ':content_id' => (int) $Id,
                                ':file_id' => $result[0],
                                ':delta' => ($max[0]->maxdelta + 1) + $delta,
								':is_image' => $data->is_image,
                                ':module' => $module
                            ))
                            ->execute();
                } else {
					if($data->is_image){
						$add_images_id[] = $result[0];
					}
                    
                }
            }
        }
		
		if (isset($add_images_id) AND !empty($add_images_id)) {
            $imagesinfo = $this->session->get('add_doimages', 0);
			
            if ($imagesinfo) {
                $this->session->delete('add_doimages');
                foreach ($imagesinfo as $doimagesid) {
                    $add_images_id[] = $doimagesid;
                }
            }
            $this->session->set('add_doimages', $add_images_id);
        }
        
        if ($result) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
	
	public function add_files_by_content($content_id, $file_id, $delta, $module = 'products', $is_image = 1) {
	
        DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName2 . ' (file_id, content_id, delta, is_image, module) VALUES (:file_id, :content_id, :delta, :is_image, :module)')
						->parameters(array(
							':content_id' => $content_id,
							':file_id' => $file_id,
							':delta' => $delta,
							':is_image' => $is_image,
							':module' => $module,
						))
						->execute();
        return true;
    }
	
    public function newsort($newsortstring) {
        if ($newsortstring) {
            $items = explode(',', $newsortstring);
        } else {
            $items = 0;
        }
        if (is_array($items)) {
            foreach ($items as $newdelta => $file_id) {
                DB::query(Database::UPDATE, 'UPDATE ' . $this->tableName2 . ' SET `delta` = :delta WHERE `file_id` = :file_id')
                        ->parameters(array(
                            ':file_id' => $file_id,
                            ':delta' => $newdelta,
                        ))
                        ->execute();
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }
	
    public function update_fileinfo($file_id, $data) {
		if(isset($data)){
			foreach($data as $lang_id => $value){
				$result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName3 . '` WHERE `file_id` = :file_id AND `lang_id` = :lang_id')
                        ->parameters(array(
							':lang_id' => $lang_id,
                            ':file_id' => $file_id,
                        ))->execute();
				if(count($result)>0){
					DB::query(Database::UPDATE, 'UPDATE `' . $this->tableName3 . '` SET `title` = :title, `description` = :description, `link` = :link WHERE `file_id` = :file_id AND `lang_id` = :lang_id')
						->parameters(array(
							':file_id' => $file_id,
							':lang_id' => $lang_id,
							':title' => isset($value['title'])?Security::xss_clean($value['title']):'',
							':description' => isset($value['description'])?Security::xss_clean($value['description']):'',
							':link' => isset($value['link'])?Security::xss_clean($value['link']):'',
						))
					->execute();
				} else {
					DB::query(Database::INSERT, 'INSERT INTO `' . $this->tableName3 . '` (`file_id`, `lang_id`, `title`, `description`, `link`) VALUES (:file_id, :lang_id, :title, :description, :link)')
						->parameters(array(
							':file_id' => $file_id,
							':lang_id' => $lang_id,
							':title' => isset($value['title'])?Security::xss_clean($value['title']):'',
							':description' => isset($value['description'])?Security::xss_clean($value['description']):'',
							':link' => isset($value['link'])?Security::xss_clean($value['link']):'',
						))
						->execute();
				}				
			}
		}
        return TRUE;
    }
	
    public function _upload_files($tempdoimagesname, $ext = NULL, $directory = NULL, $doimagesname = NULL, $is_image = 1) {
	
        $file = new stdClass();
		
		if($is_image){
			$image_versions = Kohana::$config->load('admin/doimage.image_versions');
			$image_setting = Kohana::$config->load('admin/doimage.setting');
			if ($directory == NULL) {
				$directory = $image_setting['upload_dir'];
			}
			if ($ext == NULL) {
				$ext = '.jpg';
			}
			
			if ($doimagesname == NULL) {
				$doimagesname = time();
				$doimagesname = $doimagesname.$ext;
			} else {
				$doimagesname = time().'_'.Text::transliteration($doimagesname, 1);
			}
			
			$im = Image::factory($tempdoimagesname);
			$im->save($directory . $doimagesname);
			$file->name = $doimagesname;
			$file->size = filesize($tempdoimagesname);
			$file->type = $im->mime;
			$file->url = $image_setting['upload_url'] . $doimagesname;
			$file->pathname = $doimagesname;
			$file->is_image = $is_image;
			
			foreach ($image_versions as $key => $options) {
				// Изменение размера и загрузка изображения
				$im = Image::factory($tempdoimagesname);
				if ($key == 'thumbnail') {
					$im->resize($options['max_width'], $options['max_height'], Image::HEIGHT); /* Высота изображения изменяется в точно заданный размер, а ширина согласно пропорции.*/
					$im->save($options['upload_dir'] . $doimagesname, $options['jpeg_quality']);
				} elseif ($key == 'preview') {
					if ($im->width > $im->height) {
						$im->resize($options['max_width']+50, $options['max_height']+50, Image::WIDTH); /* Ширина изображения изменяется в точно заданный размер, а высота согласно пропорции.*/
						$im->crop($options['max_width'], $options['max_height'], NULL, 0); /* Обрезать изображение наверху-в центре */
						$im->save($options['upload_dir'] . $doimagesname, $options['jpeg_quality']);
					} elseif($im->width < $im->height) {
						$im->resize($options['max_width']+50, $options['max_height']+50, Image::HEIGHT);
						$im->crop($options['max_width'], $options['max_height'], NULL, 0); /* Обрезать изображение наверху-в центре */
						$im->save($options['upload_dir'] . $doimagesname, $options['jpeg_quality']);
					} else {
						$im->resize($options['max_width']+50, $options['max_height']+50, Image::AUTO); /* Изображение изменяет размер согласно пропорции*/
						$im->crop($options['max_width'], $options['max_height'], NULL, 0); /* Обрезать изображение наверху-в центре */
						$im->save($options['upload_dir'] . $doimagesname, $options['jpeg_quality']);
					}
				}
			}
		}
        return $file;
    }
	
	public function delete_files_by_content($content_id, $module = 'products', $delete_files = 1){
		$query = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName2 . '` WHERE `content_id` = :id AND `module` = :module')
                ->parameters(array(
					':id' => (int) $content_id,
					':module' => $module,
                ));
        $result = $query->execute();
        if (count($result) > 0) {
            foreach ($result as $res) {
                $this->delete($res['file_id'], $content_id, $module, $delete_files);
            }
        }
	}
	
    public function delete($Id, $content_id, $module = 'products', $delete_files = 1) {
        $add_doimages_id = array();
        if ($content_id != 0) {
            DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableName2 . ' WHERE `file_id` = :id AND `content_id` = :content_id AND `module` = :module')
                    ->parameters(array(
                        ':id' => $Id,
                        ':content_id' => $content_id,
                        ':module' => $module,
                    ))->execute();
            $doimages_to_content = DB::query(Database::SELECT, 'SELECT * FROM ' . $this->tableName2 . ' WHERE `content_id` = :id AND `module` = :module ORDER BY `delta`', TRUE)
                    ->as_object()
                    ->parameters(array(
                        ':id' => $content_id,
                        ':module' => $module,
                    ))
                    ->execute();
            if (count($doimages_to_content) > 0) {
                foreach ($doimages_to_content as $newdelta => $value) {
                    DB::query(Database::UPDATE, 'UPDATE ' . $this->tableName2 . ' SET `file_id` = :file_id, `content_id` = :content_id, `delta` = :delta WHERE `file_id` = :file_id')
                           ->parameters(array(
                                ':file_id' => $value->file_id,
                                ':content_id' => $content_id,
                                ':delta' => $newdelta,
                            ))->execute();
                }
            }
            $result = DB::query(Database::SELECT, 'SELECT `file_id` FROM ' . $this->tableName2 . ' WHERE `file_id` = :id')
                        ->param(':id', $Id)
                        ->execute();
            if (count($result)==0){
                $doimagesobject = DB::query(Database::SELECT, 'SELECT * FROM ' . $this->tableName . ' WHERE `id` = :id', TRUE)
                        ->as_object()
                        ->param(':id', $Id)
						->execute();
                if ($delete_files) {
                    $image_versions = Kohana::$config->load('admin/doimage.image_versions');
					$images_setting = Kohana::$config->load('admin/doimage.setting');
					
                    $doimages_path = $image_setting['upload_dir'] . $doimagesobject[0]->filename;
                    is_file($doimages_path) && unlink($doimages_path);

					foreach ($image_versions as $options) {
						$doimages = $options['upload_dir'] . $doimagesobject[0]->filename;
						if (is_file($doimages)) {
							unlink($doimages);
						}
					}
                }
                $query = DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableName . ' WHERE `id` = :id')
                        ->param(':id', (int) $Id)
                        ->execute();
            }
        } else {
            $doimagesobject = DB::query(Database::SELECT, 'SELECT * FROM ' . $this->tableName . ' WHERE `id` = :id', TRUE)
                    ->as_object()
                   ->param(':id', $Id)
                   ->execute();
            if ($delete_files) {
			
                $image_versions = Kohana::$config->load('admin/doimage.image_versions');
                $image_setting = Kohana::$config->load('admin/doimage.setting');
				
                $doimages_path = $image_setting['upload_dir'] . $doimagesobject[0]->filename;
                is_file($doimages_path) && unlink($doimages_path);

				foreach ($image_versions as $options) {
					$doimages = $options['upload_dir'] . $doimagesobject[0]->filename;
					if (is_file($doimages)) {
						unlink($doimages);
					}
				}
            }
            $query = DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableName . ' WHERE `id` = :id')
                    ->param(':id', (int) $Id)
                    ->execute();          
            $doimagesinfo = $this->session->get('add_doimages', 0);
            $this->session->delete('add_doimages');
            if ($doimagesinfo) {
               foreach ($doimagesinfo as $doimagesid) {
                    if ($doimagesid != $Id) {
                        $add_doimages_id[] = $doimagesid;
                    }
                }
                $this->session->set('add_doimages', $add_doimages_id);
            }
        }
        return TRUE;
    }
	
	public function delete_by_filename($filename, $setting = false) {
		if($filename){
			if ($setting) {
				$image_versions = $setting['image_versions'];
				$image_setting = $setting['setting'];
			} else {
				$image_versions = Kohana::$config->load('admin/doimage.image_versions');
				$image_setting = Kohana::$config->load('admin/doimage.setting');
			}
			$doimages_path = $image_setting['upload_dir'] . $filename;
			$success = is_file($doimages_path) && unlink($doimages_path);
			if ($success) {
				foreach ($image_versions as $options) {
					$doimages = $options['upload_dir'] . $filename;
					if (is_file($doimages)) {
						unlink($doimages);
					}
				}
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
    }
	
    public function delete_description($Id) {
        DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableName3 . ' WHERE `file_id` = :file_id')
                ->param(':file_id', (int) $Id)
                ->execute();
        return TRUE;
    }
}