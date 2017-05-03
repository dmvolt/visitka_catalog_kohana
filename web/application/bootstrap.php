<?php

defined('SYSPATH') or die('No direct script access.');

// -- Environment setup --------------------------------------------------------
// Load the core Kohana class
require SYSPATH . 'classes/kohana/core' . EXT;

if (is_file(APPPATH . 'classes/kohana' . EXT)) {
    // Application extends the core
    require APPPATH . 'classes/kohana' . EXT;
} else {
    // Load empty core extension
    require SYSPATH . 'classes/kohana' . EXT;
}

define('FULLURL', Kohana::getFullUrl());  // Полный путь включая http:// ..... и т.д.
define('SCHEME', Kohana::getScheme());  // Полный путь включая http:// ..... и т.д.
define('HOST', Kohana::getHost());  // Полный путь включая http:// ..... и т.д.
/**
 * Set the default time zone.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/timezones
 */
date_default_timezone_set('Asia/Novosibirsk');
/**
 * Set the default locale.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');
/**
 * Enable the Kohana auto-loader.
 *
 * @see  http://kohanaframework.org/guide/using.autoloading
 * @see  http://php.net/spl_autoload_register
 */
spl_autoload_register(array('Kohana', 'auto_load'));
/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @see  http://php.net/spl_autoload_call
 * @see  http://php.net/manual/var.configuration.php#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');
// -- Configuration and initialization -----------------------------------------
/**
 * Set the default language
 */
I18n::lang('ru-ru');
/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *  PRODUCTION  - Готовый продукт
 *  STAGING     - Подготовка
 * 	TESTING     - Тестирование
 * 	DEVELOPMENT - Разработка
 * 	
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
Kohana::$environment = Kohana::PRODUCTION;

if (isset($_SERVER['KOHANA_ENV'])) {
    Kohana::$environment = constant('Kohana::' . strtoupper($_SERVER['KOHANA_ENV']));
}
/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 */
Kohana::init(array(
    'base_url' => '/',
    'index_file' => FALSE
));
/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH . 'logs'));
/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);
/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
    /********************* Системные модули ***********************/
    'cache' => MODPATH_SYS . 'cache', // Caching with multiple backends
    'codebench' => MODPATH_SYS . 'codebench', // Benchmarking tool
    'database' => MODPATH_SYS . 'database', // Database access
    'orm' => MODPATH_SYS . 'orm', // ORM
    'image' => MODPATH_SYS . 'image', // Image manipulation
	'captcha' => MODPATH_SYS . 'captcha', // Модуль Каптча
    'email' => MODPATH_SYS . 'email', // Email
    'unittest' => MODPATH_SYS . 'unittest', // Unit testing
    'userguide' => MODPATH_SYS . 'userguide', // User guide and API documentation
    'purifier' => MODPATH_SYS . 'purifier', // Protection against XSS attacks
	'sitemap' => MODPATH_SYS . 'sitemap', // sitemap.xml generation
    /********************* Модули проекта *************************/
    'menu' => MODPATH_PROJECT . 'menu', // Модуль Меню  
	'catalog'   => MODPATH_PROJECT.'catalog',   // Модуль Каталог
	//'services'   => MODPATH_PROJECT.'services',   // Модуль Услуги
	//'projects'   => MODPATH_PROJECT.'projects',   // Модуль Проекты
	'banners' => MODPATH_PROJECT . 'banners', // Модуль Баннер 
	//'documents'   => MODPATH_PROJECT.'documents',   // Модуль Документы
	//'articles'   => MODPATH_PROJECT.'articles',   // Модуль статей
	//'news'   => MODPATH_PROJECT.'news',   // Модуль Новости	
	'actions'   => MODPATH_PROJECT.'actions',   // Модуль Акции	
	
	'infoblock'   => MODPATH_PROJECT.'infoblock',   // Модуль Инфоблоки
	'modulinfo' => MODPATH_PROJECT . 'modulinfo', // Модуль Основная информация модуля
	
	'liteedit'   => MODPATH_PROJECT.'liteedit',   // Модуль быстрого редактирования контента на сайте
	'breadcrumbs' => MODPATH_PROJECT.'breadcrumbs',   // Модуль "Хлебные крошки"
	'search' => MODPATH_PROJECT.'search',   // Модуль Поиск
	'seo' => MODPATH_PROJECT . 'seo', // Модуль SEO
	'files' => MODPATH_PROJECT . 'files', // Модуль Файлы
	//'doimages' => MODPATH_PROJECT . 'doimages', // Модуль Дополнительные картинки (ДО/ПОСЛЕ)
	//'fields' => MODPATH_PROJECT . 'fields', // Модуль Дополнительные поля
	
	//'faq' => MODPATH_PROJECT . 'faq', // Модуль Вопрос-ответ
	
	//'reviews' => MODPATH_PROJECT . 'reviews', // Модуль Отзывы
	//'appointments' => MODPATH_PROJECT . 'appointments', // Модуль Заявки
	//'photos' => MODPATH_PROJECT . 'photos', // Модуль Фотогалерея
));
/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
//if (!Route::cache())
//    {
// Ответы (answers)
Route::set('answer_lang', '<lang>/answer', array('lang' => '[a-zA-Z]{2}'))
        ->defaults(array(
            'controller' => 'answer',
            'action' => 'answer',
        ));
		
Route::set('answer', 'answer')
        ->defaults(array(
            'controller' => 'answer',
            'action' => 'answer',
        ));
		
// Авторизация
Route::set('auth_lang', '<lang>/auth', array('lang' => '[a-zA-Z]{2}'))
        ->defaults(array(
            'controller' => 'auth',
            'action' => 'index',
        ));
		
Route::set('auth', 'auth')
        ->defaults(array(
            'controller' => 'auth',
            'action' => 'index',
        ));
		
// Магазины
/* Route::set('product_lang', '<lang>/services(/<alias>)', array('lang' => '[a-zA-Z]{2}', 'alias' => '[a-zA-Z0-9\-]+'))
        ->defaults(array(
            'controller' => 'categories',
            'action' => 'services',
        ));
		
Route::set('product', 'services(/<alias>)', array('alias' => '[a-zA-Z0-9\-]+'))
        ->defaults(array(
            'controller' => 'categories',
            'action' => 'services',
        )); */
		
// Админка
Route::set('admin_lang', 'admin/<lang>(/<controller>(/<action>(/<id>)))', array('lang' => '[a-zA-Z]{2}'))
        ->defaults(array(
           'directory' => 'admin',
            'controller' => 'front',
            'action' => 'index',
       ));
	   
Route::set('admin', 'admin(/<controller>(/<action>(/<id>)))')
        ->defaults(array(
           'directory' => 'admin',
            'controller' => 'front',
            'action' => 'index',
       ));
	   
// Страницы about, contacts и др.
// Получение адресов существующих страниц, для вставление в параметры роута
$sql = "SELECT * FROM pages";
$pages = DB::query(Database::SELECT, $sql)
        ->execute();
if (count($pages) > 0) {
    $parameters = '';
    foreach ($pages as $i => $page) {
        if ($i) {
            if ($page['alias'] != '') {
                $parameters .= '|' . $page['alias'] . '|' . $page['id'];
            } else {
                $parameters .= '|' . $page['id'];
            }
        } else {
            if ($page['alias'] != '') {
                $parameters .= $page['alias'] . '|' . $page['id'];
            } else {
                $parameters .= $page['id'];
            }
        }
    }
}

Route::set('pages_lang', '<lang>/<page>', array('lang' => '[a-zA-Z]{2}', 'page' => $parameters))
        ->defaults(array(
            'controller' => 'pages',
            'action' => 'page',
        ));
		
Route::set('pages', '<page>', array('page' => $parameters))
        ->defaults(array(
            'controller' => 'pages',
            'action' => 'page',
        ));
		
Route::set('error', 'error/<code>(/<message>)', array('code' => '[0-9]++', 'message' => '.+'))
        ->defaults(array(
                'controller' => 'error',
				'action' => 'index',
));
		
// По умолчанию - на заставку
Route::set('default_lang', '<lang>(/<controller>(/<action>(/<id>)))', array('lang' => '[a-zA-Z]{2}'))
        ->defaults(array(
            'controller' => 'front',
            'action' => 'index',
        ));
		
Route::set('default', '(<controller>(/<action>(/<id>)))')
        ->defaults(array(
            'controller' => 'front',
            'action' => 'index',
        ));
	        
//	Route::cache(TRUE);
//} 
 