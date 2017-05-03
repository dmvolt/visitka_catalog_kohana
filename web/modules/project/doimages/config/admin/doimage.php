<?php

defined('SYSPATH') or die('No direct script access');

return array(
    'image_versions' => array(
		'preview' => array(
            'upload_dir' => DOCROOT . 'files/doimages/preview/',
            'upload_url' => FULLURL . '/files/doimages/preview/',
            'max_width' => 450,
            'max_height' => 350,
            'jpeg_quality' => 100
        ),
        'thumbnail' => array(
            'upload_dir' => DOCROOT . 'files/doimages/thumbnails/',
            'upload_url' => FULLURL . '/files/doimages/thumbnails/',
            'max_width' => 100,
            'max_height' => 100,
            'jpeg_quality' => 95
        ),
    ),
    'setting' => array(
        'upload_dir' => DOCROOT . 'files/doimages/',
        'upload_url' => FULLURL . '/files/doimages/',
        'param_name' => 'doimages',
    ),
);