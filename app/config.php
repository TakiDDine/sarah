<?php


/*
 * AFRASS 1.0.0 (2018-11-18, 19:18)
 *
 * Copyright (C) 2018 Soulaimane Takiddine 
 * SITE  : http://takiddine.com
 * EMAIL : takiddine.job@gmail.com
 * 
 */

defined('BASEPATH') OR exit('No direct script access allowed');

define('SCRIPTURL','http://sarah.local/');
define('SCRIPTDIR', BASEPATH.'/');

return  [
    
    'app' => [
        'version'            => '1.0',
        'debug'              => true,
    ],
    
    
    'db' => [
        'driver'             => 'mysql',
        'host'               => 'localhost',
        'name'               => 'site',
        'username'           => 'root',
        'password'           => '',
        'charset'            => 'utf8',
        'collation'          => 'utf8_general_ci',
        'strict'             => 'false',
        'prefix'             => 'na_'
    ],
    
        'views'              => '',
    
    'region' => [
            'time_format' => 'g:i a',
            'date_format' => 'm/d/Y',
            'datetime_separator' => ' ',
            'timezone' => null
    ],
    
    'admin'  => [
            'max_upload_size' => '5242880',
    ],
    
    
    
    'url' => [
        'base'               => SCRIPTURL,
        'ads'                => SCRIPTURL.'uploads/undetected/',
        'admin_assets'       => SCRIPTURL.'admin_assets/',
        'website_assets'     => SCRIPTURL.'assets/',
        'avatars'            => SCRIPTURL.'uploads/avatar/',
        'pages'              => SCRIPTURL.'uploads/pages/',
        'posts'              => SCRIPTURL.'uploads/posts/',
        'products'           => SCRIPTURL.'uploads/products/',
        'general'            => SCRIPTURL.'uploads/general/',
        'slider'             => SCRIPTURL.'uploads/slider/',    
        'media'              => SCRIPTURL.'uploads/media/',    
        'uploads'            => SCRIPTURL.'uploads/',    
    ],
    
    'dir' => [
        'base'               => SCRIPTDIR,
        'avatars'            => SCRIPTDIR.'public/uploads/avatar/',
        'products'           => SCRIPTDIR.'public/uploads/products/',
        'ads'                => SCRIPTDIR.'public/uploads/undetected/',
        'posts'              => SCRIPTDIR.'public/uploads/posts/',
        'pages'              => SCRIPTDIR.'public/uploads/pages/',
        'general'            => SCRIPTDIR.'public/uploads/general/',
        'slider'             => SCRIPTDIR.'public/uploads/slider/',
        'media'              => SCRIPTDIR.'public/uploads/media/',
    ] 

    
    
];