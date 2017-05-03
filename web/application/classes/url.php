<?php defined('SYSPATH') or die('No direct script access.');

class URL extends Kohana_URL {

	public static function site($uri = '', $protocol = NULL, $index = TRUE, $char_codding = TRUE)
	{
		// Chop off possible scheme, host, port, user and pass parts
		$path = preg_replace('~^[-a-z0-9+.]++://[^/]++/?~', '', trim($uri, '/'));

		if($char_codding){
			if ( ! UTF8::is_ascii($path))
			{
				// Encode all non-ASCII characters, as per RFC 1738
				$path = preg_replace('~([^/]+)~e', 'rawurlencode("$1")', $path);
			}
		}

		// Concat the URL
		return URL::base($protocol, $index).$path;
	}
	
	public static function imagepath($folder = '', $filename = '', $basepath = '/files') {
	
		$image_versions = Kohana::$config->load('admin/image.image_versions');

		clearstatcache();
		
		if($filename AND !empty($filename) AND file_exists(DOCROOT . 'files/'.$filename)){
		
			if($folder == 'thumbnails'){
			
				if(file_exists(DOCROOT . 'files/'.$filename) AND !file_exists(DOCROOT . 'files/thumbnails/'.$filename)){
					$im = Image::factory(DOCROOT . 'files/'.$filename);
					$im->resize($image_versions['thumbnail']['max_width'], $image_versions['thumbnail']['max_height'], Image::HEIGHT);
					if(!file_exists($image_versions['thumbnail']['upload_dir'])){
						mkdir($image_versions['thumbnail']['upload_dir'], 0755);
					}
					$im->save($image_versions['thumbnail']['upload_dir'] . $filename, $image_versions['thumbnail']['jpeg_quality']);
				}
				
			} elseif($folder == 'preview'){
			
				if(file_exists(DOCROOT . 'files/'.$filename) AND !file_exists(DOCROOT . 'files/preview/'.$filename)){
				
					$im = Image::factory(DOCROOT . 'files/'.$filename);
					$im->resize($image_versions['preview']['max_width'], $image_versions['preview']['max_height'], Image::WIDTH);
					
					if(!file_exists($image_versions['preview']['upload_dir'])){
						mkdir($image_versions['preview']['upload_dir'], 0755);
					}
					$im->save($image_versions['preview']['upload_dir'] . $filename, $image_versions['preview']['jpeg_quality']);
				}
				
			} elseif($folder == 'preview2'){
			
				if(file_exists(DOCROOT . 'files/'.$filename) AND !file_exists(DOCROOT . 'files/preview2/'.$filename)){
				
					$im = Image::factory(DOCROOT . 'files/'.$filename);
					$im->resize($image_versions['preview2']['max_width'], $image_versions['preview2']['max_height'], Image::AUTO);
					
					if(!file_exists($image_versions['preview2']['upload_dir'])){
						mkdir($image_versions['preview2']['upload_dir'], 0755);
					}
					$im->save($image_versions['preview2']['upload_dir'] . $filename, $image_versions['preview2']['jpeg_quality']);
				}
				
			} elseif($folder == 'preview3'){
			
				if(file_exists(DOCROOT . 'files/'.$filename) AND !file_exists(DOCROOT . 'files/preview3/'.$filename)){
				
					$im = Image::factory(DOCROOT . 'files/'.$filename);
					$bg = clone $im;
					$bg->crop(1, 1, 0, 0);
					$bg->resize($image_versions['preview3']['max_width'], $image_versions['preview3']['max_height'], Image::NONE);
					$im->resize($image_versions['preview3']['max_width'], $image_versions['preview3']['max_height']);
					$bg->watermark($im);
					
					if(!file_exists($image_versions['preview3']['upload_dir'])){
						mkdir($image_versions['preview3']['upload_dir'], 0755);
					}
					$bg->save($image_versions['preview3']['upload_dir'] . $filename, $image_versions['preview3']['jpeg_quality']);
				}
				
			} elseif($folder == 'icon'){
			
				if(file_exists(DOCROOT . 'files/'.$filename) AND !file_exists(DOCROOT . 'files/icon/'.$filename)){
					
					$im = Image::factory(DOCROOT . 'files/'.$filename);
					$im->resize($image_versions['icon']['max_width'], $image_versions['icon']['max_height'], Image::AUTO); /* Высота изображения изменяется в точно заданный размер, а ширина согласно пропорции.*/
					if(!file_exists($image_versions['icon']['upload_dir'])){
						mkdir($image_versions['icon']['upload_dir'], 0755);
					}
					$im->save($image_versions['icon']['upload_dir'] . $filename, $image_versions['icon']['jpeg_quality']);
				}
				
			} elseif($folder == 'colorbox'){
			
				if(file_exists(DOCROOT . 'files/'.$filename) AND !file_exists(DOCROOT . 'files/colorbox/'.$filename)){
					$im = Image::factory(DOCROOT . 'files/'.$filename);
					
					if ($im->width > $image_versions['colorbox']['max_width']) {
						$im->resize($image_versions['colorbox']['max_width'], $image_versions['colorbox']['max_height'], Image::AUTO);
					}
					if(!file_exists($image_versions['colorbox']['upload_dir'])){
						mkdir($image_versions['colorbox']['upload_dir'], 0755);
					}
					$im->save($image_versions['colorbox']['upload_dir'] . $filename, $image_versions['colorbox']['jpeg_quality']);
				}
				
			} elseif($folder == 'top'){
			
				if(file_exists(DOCROOT . 'files/'.$filename) AND !file_exists(DOCROOT . 'files/top/'.$filename)){
					$im = Image::factory(DOCROOT . 'files/'.$filename);
					
					if ($im->height > $image_versions['top']['max_height']) {
						$im->resize($image_versions['top']['max_width'], $image_versions['top']['max_height'], Image::HEIGHT);
					}
					if(!file_exists($image_versions['top']['upload_dir'])){
						mkdir($image_versions['top']['upload_dir'], 0755);
					}
					$im->save($image_versions['top']['upload_dir'] . $filename, $image_versions['top']['jpeg_quality']);
				}
			}
			return $basepath.'/'.$folder.'/'.$filename;
		} else {
			return $basepath.'/nophoto.jpg';
		}
	}
}