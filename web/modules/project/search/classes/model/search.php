<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Search {

    protected $tableDesc = 'contents_descriptions';
	
    public function get_filter_search($data) {
		$sql = "SELECT content_id, module, lang_id FROM `" . $this->tableDesc . "` WHERE `lang_id` = :lang_id AND `module` != 'menu'  AND `module` != 'infoblock'  AND `module` != 'siteinfo'";
        $implode = array();
        $words = explode(' ', $data);
        $sql .= " AND ((";
        /*         * ********************************* Поиск в поле "content_title" ********************************* */
        foreach ($words as $word) {
            $implode[] = " content_title LIKE '%" . trim($word) . "%'";
        }
        if ($implode) {
            $sql .= " " . implode(" OR ", $implode) . "";
        }
        $sql .= ")";
        /*********************************** Поиск в поле "content_teaser" ********************************* */
        $implode = array();
        $sql .= " OR (";
        foreach ($words as $word) {
            $implode[] = " content_teaser LIKE '%" . $word . "%'";
        }
        if ($implode) {
            $sql .= " " . implode(" AND ", $implode) . "";
        }
        $sql .= ")";
		
		/*********************************** Поиск в поле "content_body" ********************************* */
        $implode = array();
        $sql .= " OR (";
        foreach ($words as $word) {
            $implode[] = " content_body LIKE '%" . $word . "%'";
        }
        if ($implode) {
            $sql .= " " . implode(" AND ", $implode) . "";
        }
        $sql .= ")";
		
		/*********************************** Поиск в поле "content_text_field" ********************************* */
        $implode = array();
        $sql .= " OR (";
        foreach ($words as $word) {
            $implode[] = " content_text_field LIKE '%" . $word . "%'";
        }
        if ($implode) {
            $sql .= " " . implode(" AND ", $implode) . "";
        }
        $sql .= "))";
        
        $query = DB::query(Database::SELECT, $sql)
                ->parameters(array(
                    ':lang_id' => Data::_('lang_id'),
                ))
                ->execute();
        $result = $query->as_array();
		
        if(count($result)>0){
			return $result;
		} else {
			return false;
		}
    }
	
    public function get_total($filter_name, $search_table) {
        $sql = "SELECT COUNT(id) AS total FROM `" . $search_table . "` WHERE `status` = :status";
        $implode = array();
        $words = explode(' ', $filter_name);
        $sql .= " AND ((";
        /*         * ********************************* Поиск в поле "title" ********************************* */
        foreach ($words as $word) {
            $implode[] = " title LIKE '%" . $word . "%'";
        }
        if ($implode) {
            $sql .= " " . implode(" AND ", $implode) . "";
        }
        $sql .= ")";
        /*         * ********************************* Поиск в поле "body" ********************************* */
        $implode = array();
        $sql .= " OR (";
        foreach ($words as $word) {
            $implode[] = " body LIKE '%" . $word . "%'";
        }
        if ($implode) {
            $sql .= " " . implode(" AND ", $implode) . "";
        }
        $sql .= ")";
        /*         * ********************************* Поиск в поле "sku" ********************************* */
        $implode = array();
        $sql .= " OR (";
        foreach ($words as $word) {
            $implode[] = " sku LIKE '%" . $word . "%'";
        }
        if ($implode) {
            $sql .= " " . implode(" AND ", $implode) . "";
        }
        $sql .= "))";
        $query = DB::query(Database::SELECT, $sql)
                ->parameters(array(
                    ':status' => 1,
                ))
                ->execute();
        $result = $query->as_array();
        $total = $result[0]['total'];
        return $total;
    }
}