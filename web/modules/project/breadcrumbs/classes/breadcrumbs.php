<?php

defined('SYSPATH') or die('No direct script access.');

class Breadcrumbs {

    public static function get_breadcrumbs($id = 0, $module = 'pages', $cat1 = false, $cat2 = false, $cat3 = false) {

        $breadcrumbs = array();
		$breadcrumbs[] = array(
			'name' => 'Главная',
			'href' => 'href="/"',
		);

		if($module != 'pages' AND $module != 'categories'){
			$modules = Kohana::modules();
			if (is_file($modules[$module] . 'config/menu' . EXT)) {
				require MODPATH_PROJECT . $module . '/config/menu' . EXT;
				$breadcrumbs[] = array(
					'name' => $menu['name'],
					'href' => 'href="'.$menu['href'].'"',
				);
			}
		} elseif($module == 'categories'){
			$breadcrumbs[] = array(
				'name' => 'Услуги',
				'href' => 'href="/services"',
			);
		}

		if($cat1){
			$categories_obj = new Model_Categories();
			$catpage1 = $categories_obj->getCategory(0, $cat1);

			$modules = Kohana::modules();
			if (is_file($modules[$module] . 'config/menu' . EXT)) {
				require MODPATH_PROJECT . $module . '/config/menu' . EXT;
				$breadcrumbs[] = array(
					'name' => $catpage1[0]['descriptions'][Data::_('lang_id')]['title'],
					'href' => 'href="'.$menu['href'].'/'.$catpage1[0]['alias'].'"',
				);
			}
		}
		
		if($cat2){
			$categories_obj = new Model_Categories();
			$catpage2 = $categories_obj->getCategory(0, $cat2);

			$modules = Kohana::modules();
			if (is_file($modules[$module] . 'config/menu' . EXT)) {
				require MODPATH_PROJECT . $module . '/config/menu' . EXT;
				$breadcrumbs[] = array(
					'name' => $catpage2[0]['descriptions'][Data::_('lang_id')]['title'],
					'href' => 'href="'.$menu['href'].'/'.$catpage1[0]['alias'].'/'.$catpage2[0]['alias'].'"',
				);
			}
		}
		
		if($cat3){
			$categories_obj = new Model_Categories();
			$catpage3 = $categories_obj->getCategory(0, $cat3);

			$modules = Kohana::modules();
			if (is_file($modules[$module] . 'config/menu' . EXT)) {
				require MODPATH_PROJECT . $module . '/config/menu' . EXT;
				$breadcrumbs[] = array(
					'name' => $catpage3[0]['descriptions'][Data::_('lang_id')]['title'],
					'href' => 'href="'.$menu['href'].'/'.$catpage1[0]['alias'].'/'.$catpage2[0]['alias'].'/'.$catpage3[0]['alias'].'"',
				);
			}
		}

        if ($id) {
			if($module == 'categories'){
				$result = Model::factory($module)->getNode($id);
			} else {
				$result = Model::factory($module)->get_content($id);
			}

            if ($result) {         
                $breadcrumbs[] = array(
                    'name' => $result['descriptions'][Data::_('lang_id')]['title'],
                    'href' => '',
                );
            }
        }
        return View::factory(Data::_('template_directory') . 'breadcrumbs')->set('breadcrumbs', $breadcrumbs);
    }
}
// Breadcrumbs