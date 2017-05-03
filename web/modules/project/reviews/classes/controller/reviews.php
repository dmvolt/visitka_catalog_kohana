<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Reviews extends Controller_Template {

    public function action_review() {
        $id = $this->request->param('id');
        $content = View::factory($this->template_directory . 'review')
				->bind('edit_interface', $edit_interface)
                ->bind('article', $article);
        $reviews_obj = new Model_Reviews();
        $article = $reviews_obj->get_content($id);
		
		$edit_interface = Liteedit::get_interface($article['id'], 'reviews');
        $this->page_title = $article['descriptions'][$this->lang_id]['title'];
        $this->template->content = $content;
    }
	
    public function action_reviews() {
        $reviews_obj = new Model_Reviews();
		$seo_obj = new Model_Seo();
		$siteinfo_obj = new Model_Siteinfo();
		$file_obj = new Model_File();
		
		$reviews = array();
		$descriptions = array();
		
		$ok = false;
		$errors = false;
		
		if (isset($_POST['name'])) {
            $validation = Validation::factory($_POST);
            $validation->rule('name', 'not_empty');
            $validation->rule('name', 'max_length', array(':value', '64'));
			$validation->rule('text', 'not_empty');
            $validation->rule('text', 'max_length', array(':value', '2000'));
            $validation->labels(array('name' => 'Ваше имя', 'text' => 'Текст сообщения'));
            if ($validation->check()) {
				$descriptions[1]['title'] = Arr::get($_POST, 'name');
				$descriptions[1]['body'] = Arr::get($_POST, 'text');
                $add_data = array(
                    'descriptions' => $descriptions,
					'parent_id' => Arr::get($_POST, 'parent_id', 0),
                    'group_id' => Arr::get($_POST, 'group_id', 1),
					'date' => date('Y-m-d'),
                    'weight' => Arr::get($_POST, 'weight', 0),
                    'status' => Arr::get($_POST, 'status', 0),
                );
                $new_content_id = $reviews_obj->add($add_data);
                if ($new_content_id) {
				
					// Работа с Файлами
					if (isset($_FILES['image']['tmp_name']) AND !empty($_FILES['image']['tmp_name'])) {	
						$ext = '.' . File::ext_by_mime($_FILES['image']['type']);	
						list($width, $height) = getimagesize($_FILES['image']['tmp_name']);
						
						$result = array();
						
						if (empty($width) OR empty($height)){
							$is_image = 0;
						} else {
							$is_image = 1;
						}
						
						if($is_image){
							$result[0] = $file_obj->_upload_files($_FILES['image']['tmp_name'], $ext, null, $_FILES['image']['name'], $is_image);
							$file_obj->add($new_content_id, 'reviews', $result);
						}
					}
				
					$info = $siteinfo_obj->get_siteinfo(1);
					//Отправка эл. почты администратору
					$from = $info['email'];
					$to = $info['email'];
					$subject = 'Отзыв на сайте';
					$message = '<html><body>';
					$message .= $descriptions[1]['body'].'<br>Автор: '.$descriptions[1]['title'];
					$message .= '</body></html>';
					$headers = "Content-type: text/html; charset=utf-8 \r\n";
					$headers .= "From: <" . $from . ">\r\n";
					mail($to, $subject, $message, $headers);
					
                    $ok = 'Большое спасибо за ваш отзыв! Он будет опубликован на сайте после проверки модератором.';
                }
            }
            $errors = $validation->errors('validation');
			if(isset($_FILES['image']['tmp_name']) AND !empty($_FILES['image']['tmp_name']) AND !$is_image){
				$errors[] = 'Загруженный вами файл не является изображением!';
			}
        }
		
		$total = $reviews_obj->get_total();
		$result = Pagination::start($total);
		$pagination = Pagination::navigation($result['page'], $total, $result['total_page'], $result['num']);
		$content = $reviews_obj->get_all(0, $result['start'], $result['num'], 0);
	
		if($content){
			foreach($content as $item){
				$childs = $reviews_obj->get_childs($item['id']);
				$reviews[] = array(
					'id' => $item['id'],
					'parent_id' => $item['parent_id'],
					'date' => $item['date'],
					'thumb' => $item['thumb'],
					'descriptions' => $item['descriptions'],
					'answer' => $childs,
				);
			}
		}

		$parameters = '';
        $i = 0;
        
        if($result['page']){
            $parameters .= ($i) ? '&page='.$result['page'] : '?page='.$result['page'];
            $i++;
        }
		
		$this->page_title = 'Отзывы';
		$modulinfo = Modulinfo::get_block('reviews');
		if(!empty($modulinfo)){
			/****************************** SEO ******************************/	
			$seo = $seo_obj->get_seo_to_content($modulinfo[0]['id'], 'modulinfo');
			
			if($seo[$this->lang_id]['title'] != ''){
				$this->page_title = $seo[$this->lang_id]['title'];
			}
			
			$this->meta_description = $seo[$this->lang_id]['meta_d'];
			$this->meta_keywords = $seo[$this->lang_id]['meta_k'];
			/****************************** /SEO *****************************/
		}
		
		$content = View::factory($this->template_directory . 'reviews')
					->bind('pagination', $pagination)
					->bind('modulinfo', $modulinfo)
					->bind('errors', $errors)
					->bind('ok', $ok)
					->bind('reviews', $reviews);
					
        $this->template->content = $content;
    }
}
// Reviews