<?php

defined('SYSPATH') or die('No direct script access.');

class Catalog {

	public static function left_menu_block() {
        $menu = array();
        $categories_obj = new Model_Categories();
        $main_cats = $categories_obj->getCategories(1, 0, 0);
        
        $current_alias = Request::current()->param('cat');
        
        if(isset($current_alias)){
            $parent_cat = $categories_obj->getCategory(0, $current_alias);
            if(count($parent_cat)>0){
                $current_parent_id = $parent_cat[0]['parent_id'];
            } else {
                $current_parent_id = null;
            }
        } else {
            $current_parent_id = null;
        }

        foreach ($main_cats as $value) {
            $children = $categories_obj->getCategories(1, $value['id'], 0);
            if($current_parent_id == $value['id']){
                $active = ' active';
            } elseif($value['alias'] == 'catalog' AND !$current_parent_id) {
                $active = ' active';
            } else {
                $active = '';
            }
            $menu[] = array(
                'id' => $value['id'],
                'descriptions' => $value['descriptions'],
                'alias' => $value['alias'],
                'parent_id' => $value['parent_id'],
                'active' => $active,
                'children' => $children,
            );
        }
        return View::factory(Data::_('template_directory') . 'left-menu-block')->set('menu', $menu);
    }

    public static function catalog_block($num = 25) {
        $content = View::factory(Data::_('template_directory') . 'catalog-block')
                ->bind('catalog', $catalog);
        $categories_obj = new Model_Categories();
        $catalog = $categories_obj->getCategories(1, 0, 0);
        return $content;
    }
	
	public static function catalog_current_block($id, $num = 25) {
        $content = View::factory(Data::_('template_directory') . 'catalog-block')
                ->bind('catalog', $catalog);
        $catalog_obj = new Model_Catalog();
        $catalog = $catalog_obj->get_last_current($id, $num);
        return $content;
    }
	
	public static function catalog_cat_block($catid) {
        $content = View::factory(Data::_('template_directory') . 'catalog-cat-block')
                ->bind('catalog', $catalog);
        $catalog_obj = new Model_Catalog();
        $catalog = $catalog_obj->get_all_to_cat($catid);
        return $content;
    }
}
// Catalog