<?php defined('SYSPATH') or die('No direct script access.');

class Sitemap extends Kohana_Sitemap { 

	public static function build() {
		$urls=array(); // Здесь будут храниться собранные ссылки
		$nofollow=array(); // Здесь ссылки, которые не должны попасть в sitemap.xml
		$extensions = array();
		$urls[FULLURL]='0'; // Первой ссылкой будет главная страница сайта, ставим 0, т.к. она ещё не проверена
		$extensions[]='php';
		$extensions[]='aspx';
		$extensions[]='htm';
		$extensions[]='html';
		$extensions[]='asp';
		$extensions[]='cgi';
		$extensions[]='pl'; // Разрешённые расширения файлов, чтобы не вносить в карту сайта ссылки на медиа файлы. Также разрешены страницы без разрешения.
		
		$nofollow[]='?';
		$nofollow[]='#';
		$nofollow[]='/admin/';
		$nofollow[]='/auth/';
		$nofollow[]='/search/';
		$nofollow[]='/404/'; // Страницы имеющие часть такого пути - будут запрещены
 
        // Создаем экземпляр класса Sitemap.
        $sitemap_obj = new Sitemap;
 
        // Через этот объект мы будем добавлять все УРЛы к нашей карте.
        $url_obj = new Sitemap_URL;
		
		$pages = Sitemap::sitemap_geturls(FULLURL,$nofollow,$extensions,$urls);
 
        foreach ($pages as $lnk => $v) // для каждой ссылки в цикле
        {
			if($lnk == FULLURL){
				$priority = '1.0';
			} else {
				$priority = '0.9';
			}
          
            // Выставляем приоритет индексирования. У меня - для главной страницы - 1, для остальных - 0.9. 
            
            $url_obj->set_loc($lnk) // Добавляем саму ссылку. У меня в БД они относительные, поэтому я вставляю домен перед ссылкой
                        ->set_last_mod(time()) // Устанавливаем время последнего редактирования. У меня временем последнего редактирования страницы всегда ставится текущее время, чтобы поисковики всегда обновляли индекс
                        ->set_change_frequency('always') // Показываем, что страницу нужно индексировать всегда
                        ->set_priority($priority);
            $sitemap_obj->add($url_obj); // Добавляем ссылку
        }
 
        // Генерируем xml
        $response = urldecode($sitemap_obj->render());
 
        //Записываем в файл sitemap.xml в корне сайта
        file_put_contents('sitemap.xml', $response);
    }
	
	public static function sitemap_geturls($page, $nofollow, $extensions, $urls){
     
		//Получаем содержимое ссылки, если недоступна, то заканчиваем работу функции и удаляем эту страницу из списка
		$content=file_get_contents($page);
		
		if(!$content){unset($urls[$page]);return false;}
		 
		//Отмечаем ссылку как проверенную (мы на ней побывали)
		$url[$page]=1;
		 
		//Собираем все ссылки со страницы во временный массив, с помощью регулярного выражения. Будут собраны все ссылки из тега а, атрибута href (HrEf, HREF...)
		preg_match_all("/<[Aa][\s]{1}[^>]*[Hh][Rr][Ee][Ff][^=]*=[ '\"\s]*([^ \"'>\s#]+)[^>]*>/",$content,$links); 
		$link=$links[1];
		 
		//Обрабатываем полученные ссылки, отбрасываем "плохие", а потом и с них собираем...
		for ($i = 0; $i < count($link); $i++){
			if(count($urls)>49900){return false;} // Если слишком много ссылок в массиве, то пора прекращать нашу деятельность (читай спецификацию)
			//Если не установлена схема и хост ссылки, то ставим..
			if(!strstr($link[$i],FULLURL)){$link[$i]=FULLURL.$link[$i];}
			//Убираем якори у ссылок
			$link[$i]=preg_replace("/#.*/X", "",$link[$i]);
			//Узнаём информацию о ссылке
			$urlinfo=@parse_url($link[$i]);if(!isset($urlinfo['path'])){$urlinfo['path']=NULL;}
			//Если хост совсем не наш, ссылка на главную, на почту или мы её уже обрабатывали - то посылаем эту ссылку куда подальше...
			if((isset($urlinfo['host']) AND $urlinfo['host']!= HOST) OR $urlinfo['path']=='/' OR isset($urls[$link[$i]]) OR strstr($link[$i],'@')){continue;}
			//Если ссылка запрещена, то также скидываем её
			$nofoll=0;if($nofollow!=NULL){foreach($nofollow as $of){if(strstr($link[$i],$of)){$nofoll=1;break;}}}if($nofoll==1){continue;}
			//Если задано расширение ссылки и оно не разрешёно, то ссылка не проходит
			$path_arr = explode('.',$urlinfo['path']);
			$ext=end($path_arr);
			$noext=0;if($ext!='' AND strstr($urlinfo['path'],'.') AND count($extensions)!=0){$noext=1;foreach($extensions as $of){if($ext==$of){$noext=0;continue;}}}if($noext==1){continue;}
			//Заносим ссылку в массив и отмечаем непроверенной (с неё мы ещё не забирали ссылки)
			$urls[$link[$i]]=0;
			
			//Проверяем ссылки с этой страницы	
			$content2=file_get_contents($link[$i]);
			
			if(!$content2){unset($urls[$link[$i]]);return false;}
			 
			//Отмечаем ссылку как проверенную (мы на ней побывали)
			$url2[$link[$i]]=1;
			 
			//Собираем все ссылки со страницы во временный массив, с помощью регулярного выражения. Будут собраны все ссылки из тега а, атрибута href (HrEf, HREF...)
			preg_match_all("/<[Aa][\s]{1}[^>]*[Hh][Rr][Ee][Ff][^=]*=[ '\"\s]*([^ \"'>\s#]+)[^>]*>/",$content2,$links); 
			$link2=$links[1];
			 
			//Обрабатываем полученные ссылки, отбрасываем "плохие", а потом и с них собираем...
			for ($i2 = 0; $i2 < count($link2); $i2++){
				if(count($urls)>49900){return false;} // Если слишком много ссылок в массиве, то пора прекращать нашу деятельность (читай спецификацию)
				//Если не установлена схема и хост ссылки, то ставим..
				if(!strstr($link2[$i2],FULLURL)){$link2[$i2]=FULLURL.$link2[$i2];}
				//Убираем якори у ссылок
				$link2[$i2]=preg_replace("/#.*/X", "",$link2[$i2]);
				//Узнаём информацию о ссылке
				$urlinfo2=@parse_url($link2[$i2]);if(!isset($urlinfo2['path'])){$urlinfo2['path']=NULL;}
				//Если хост совсем не наш, ссылка на главную, на почту или мы её уже обрабатывали - то посылаем эту ссылку куда подальше...
				if((isset($urlinfo2['host']) AND $urlinfo2['host']!= HOST) OR $urlinfo2['path']=='/' OR isset($urls[$link2[$i2]]) OR strstr($link2[$i2],'@')){continue;}
				//Если ссылка запрещена, то также скидываем её
				$nofoll=0;if($nofollow!=NULL){foreach($nofollow as $of){if(strstr($link2[$i2],$of)){$nofoll=1;break;}}}if($nofoll==1){continue;}
				//Если задано расширение ссылки и оно не разрешёно, то ссылка не проходит
				$path_arr2 = explode('.',$urlinfo2['path']);
				$ext2=end($path_arr2);
				$noext2=0;if($ext2!='' AND strstr($urlinfo2['path'],'.') AND count($extensions)!=0){$noext2=1;foreach($extensions as $of){if($ext2==$of){$noext2=0;continue;}}}if($noext2==1){continue;}
				//Заносим ссылку в массив и отмечаем непроверенной (с неё мы ещё не забирали ссылки)
				$urls[$link2[$i2]]=0;
			}
		}
		return $urls;
	}
}