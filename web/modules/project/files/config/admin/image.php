<?php

defined('SYSPATH') or die('No direct script access');

return array(
    'image_versions' => array(
		'icon' => array(
            'upload_dir' => DOCROOT . 'files/icon/',
            'upload_url' => FULLURL . '/files/icon/',
            'max_width' => 40,
            'max_height' => 40,
            'jpeg_quality' => 100
        ),
		'top' => array(
            'upload_dir' => DOCROOT . 'files/top/',
            'upload_url' => FULLURL . '/files/top/',
            'max_width' => 670,
            'max_height' => 430,
            'jpeg_quality' => 100
        ),
        'colorbox' => array(
            'upload_dir' => DOCROOT . 'files/colorbox/',
            'upload_url' => FULLURL . '/files/colorbox/',
            'max_width' => 900,
            'max_height' => 700,
            'jpeg_quality' => 100
        ),
		'preview' => array(
            'upload_dir' => DOCROOT . 'files/preview/',
            'upload_url' => FULLURL . '/files/preview/',
            'max_width' => 230,
            'max_height' => 150,
            'jpeg_quality' => 100
        ),
        'preview2' => array(
            'upload_dir' => DOCROOT . 'files/preview2/',
            'upload_url' => FULLURL . '/files/preview2/',
            'max_width' => 460,
            'max_height' => 295,
            'jpeg_quality' => 100
        ),
		'preview3' => array(
            'upload_dir' => DOCROOT . 'files/preview3/',
            'upload_url' => FULLURL . '/files/preview3/',
            'max_width' => 500,
            'max_height' => 335,
            'jpeg_quality' => 100
        ),
        'thumbnail' => array(
            'upload_dir' => DOCROOT . 'files/thumbnails/',
            'upload_url' => FULLURL . '/files/thumbnails/',
            'max_width' => 100,
            'max_height' => 100,
            'jpeg_quality' => 95
        ),
    ),
    'setting' => array(
        'upload_dir' => DOCROOT . 'files/',
        'upload_url' => FULLURL . '/files/',
        'param_name' => 'files',
    ),
);