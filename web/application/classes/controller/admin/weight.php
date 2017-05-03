<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Weight extends Controller {

    public function action_update() {
        $weight_obj = new Model_Weight();
        
        $descriptions = Arr::get($_POST, 'descriptions', null);
        $name = Arr::get($_POST, 'name', null);
        $url = Arr::get($_POST, 'url', null);
        $alias = Arr::get($_POST, 'alias', null);
        $sku = Arr::get($_POST, 'sku', null);
        $price = Arr::get($_POST, 'price', null);
        $new_price = Arr::get($_POST, 'new_price', null);
        $quantity = Arr::get($_POST, 'quantity', null);
        $status = Arr::get($_POST, 'status', null);
        $weight = Arr::get($_POST, 'weight', null);
		
		$pos_x = Arr::get($_POST, 'pos_x', null);
		$pos_y = Arr::get($_POST, 'pos_y', null);
		
        $module = Arr::get($_POST, 'module', null);
        $parameters = Arr::get($_POST, 'parameters', '');

        if ($descriptions) {
            $weight_obj->new_title($descriptions, $module);
        }
        
        if ($name) {
            $weight_obj->new_name($name, $module);
        }
        
        if ($url) {
            $weight_obj->new_url($url, $module);
        }
        
        if ($alias) {
            $weight_obj->new_alias($alias, $module);
        }
        
        if ($sku) {
            $weight_obj->new_sku($sku, $module);
        }
        
        if ($price) {
            $weight_obj->new_price($price, $module);
        }
        
        if ($new_price) {
            $weight_obj->new_new_price($new_price, $module);
        }
        
        if ($quantity) {
            $weight_obj->new_quantity($quantity, $module);
        }
        
        if ($status) {
            $weight_obj->new_status($status, $module);
        }
        
        if($weight){
            $weight_obj->new_sort($weight, $module);
        }
		
		if($pos_x){
            $weight_obj->new_pos_x($pos_x, $module);
        }
		
		if($pos_y){
            $weight_obj->new_pos_y($pos_y, $module);
        }

        Request::initial()->redirect('admin/' . $module . $parameters);
    }
	
	public function action_multidelete() {
        $module = Arr::get($_POST, 'module', null);
        $parameters = Arr::get($_POST, 'parameters', '');
		$multidelete = Arr::get($_POST, 'multidelete');
		
		if ($multidelete AND $module) {
			$categories_obj = new Model_Categories();
			$file_obj = new Model_File();
			$seo_obj = new Model_Seo();
			foreach($multidelete as $Id){
				$result = Model::factory($module)->delete($Id);
				if($result){
					/********************* Операции с модулями ********************/
					$categories_obj->delete_category_by_content($Id, $module);
					$seo_obj->delete_by_content($Id, $module);
					$file_obj->delete_files_by_content($Id, $module);
					/***********************************************************/
				}
			}
        }
		$res = '/admin/' . $module . $parameters;
        echo json_encode(array('result' => $res));
    }
    
    public function action_orders_update() {
        $weight_obj = new Model_Weight();
        
        $product_sku = Arr::get($_POST, 'product_sku', null);
        $product_title = Arr::get($_POST, 'product_title', null);
        $product_options = Arr::get($_POST, 'product_options', null);
        $product_price = Arr::get($_POST, 'product_price', null);
        $product_qty = Arr::get($_POST, 'product_qty', null);
        $product_total = Arr::get($_POST, 'product_total', null);
        
        $order_id = Arr::get($_POST, 'order_id', 0);
        
        if ($product_sku) {
            $weight_obj->new_product_sku($product_sku, $order_id);
        }
        
        if ($product_title) {
            $weight_obj->new_product_title($product_title, $order_id);
        }
        
        if ($product_options) {
            $weight_obj->new_product_options($product_options, $order_id);
        }
        
        if ($product_price) {
            $weight_obj->new_product_price($product_price, $order_id);
        }
        
        if ($product_qty) {
            $weight_obj->new_product_qty($product_qty, $order_id);
        }
        
        if ($product_total) {
            $weight_obj->new_product_total($product_total, $order_id);
        }

        Request::initial()->redirect('admin/orders/edit/' . $order_id);
    }

}