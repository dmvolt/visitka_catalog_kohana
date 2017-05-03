<?php

defined('SYSPATH') or die('No direct script access.');

class Menu {

	public static function getmenu($dictionary) {
        $menu = false;
		$childs = false;
		$menu_obj = new Model_Menu();
        $url = $_SERVER['REQUEST_URI'];
		$group_menu = Kohana::$config->load('menu.group_menu');

        $menu1 = $menu_obj->get_menu_to_dictionary_id($dictionary);
		
		if($menu1){
			foreach($menu1 as $item1){
				$menu2 = $menu_obj->getChildren($item1['id']);
				if($menu2){
					foreach($menu2 as $item2){
						$menu3 = $menu_obj->getChildren($item2['id']);
						$childs[] = array(
							'id' => $item2['id'],
							'descriptions' => $item2['descriptions'],
							'url' => $item2['url'],
							'icon' => $item2['icon'],
							'dictionary_id' => $item2['dictionary_id'],
							'weight' => $item2['weight'],
							'childs' => $menu3,
						);
						$menu3 = false;
					}
				}
				$menu[] = array(
					'id' => $item1['id'],
					'descriptions' => $item1['descriptions'],
					'url' => $item1['url'],
					'icon' => $item1['icon'],
					'dictionary_id' => $item1['dictionary_id'],
					'weight' => $item1['weight'],
					'childs' => $childs,
				);
				$childs = false;
			}
		}
		
		return View::factory(Data::_('template_directory') . 'menu')
                ->set('menu', $menu)
                ->set('url', $url)
                ->set('group_menu', $group_menu[$dictionary]);
    }
	
	public static function left_menu_block($dictionary = 1) {
        $menu = false;
		$childs = false;
		$menu_obj = new Model_Menu();
        $url = $_SERVER['REQUEST_URI'];
		$group_menu = Kohana::$config->load('menu.group_menu');

        $menu1 = $menu_obj->get_menu_to_dictionary_id($dictionary);
		
		if($menu1){
			foreach($menu1 as $item1){
				$menu2 = $menu_obj->getChildren($item1['id']);
				if($menu2){
					foreach($menu2 as $item2){
						$menu3 = $menu_obj->getChildren($item2['id']);
						$childs[] = array(
							'id' => $item2['id'],
							'descriptions' => $item2['descriptions'],
							'url' => $item2['url'],
							'icon' => $item2['icon'],
							'dictionary_id' => $item2['dictionary_id'],
							'weight' => $item2['weight'],
							'children' => $menu3,
						);
						$menu3 = false;
					}
				}
				$menu[] = array(
					'id' => $item1['id'],
					'descriptions' => $item1['descriptions'],
					'url' => $item1['url'],
					'icon' => $item1['icon'],
					'dictionary_id' => $item1['dictionary_id'],
					'weight' => $item1['weight'],
					'children' => $childs,
				);
				$childs = false;
			}
		}
		
		return View::factory(Data::_('template_directory') . 'left-menu-block')
                ->set('menu', $menu)
                ->set('url', $url)
                ->set('group_menu', $group_menu[$dictionary]);
    }
	
	public static function get_block_menu($dictionary = 1, $template_postfix = '') {
		$menu_obj = new Model_Menu();
        $url = $_SERVER['REQUEST_URI'];

        $menu = $menu_obj->get_menu_to_dictionary_id($dictionary);
		
		return View::factory(Data::_('template_directory') . 'block_menu'.$template_postfix)
                ->set('menu', $menu)
                ->set('url', $url)
                ->set('dictionary', $dictionary);
    }

    

    public static function get_main_menu() {
        $menu = array();
        $category = new Model_Categories();
        $main_cats = $category->getCategories(1, 0, 0);
        
        $current_alias = Request::current()->param('cat');
        
        if(isset($current_alias)){
            $parent_cat = $category->getCategory(0, $current_alias);
            if(count($parent_cat)>0){
                $current_parent_id = $parent_cat[0]['parent_id'];
            } else {
                $current_parent_id = null;
            }
        } else {
            $current_parent_id = null;
        }

        foreach ($main_cats as $value) {
            $children = $category->getCategories(1, $value['id'], 0);
            if($current_parent_id == $value['id']){
                $active = 'class="active"';
            } elseif($value['alias'] == 'catalog' AND !$current_parent_id) {
                $active = 'class="active"';
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
        return View::factory(Data::_('template_directory') . 'main_menu')->set('menu', $menu);
    }
}