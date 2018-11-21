<?php

/*!
 * AFRASS 1.0.0 (2018-11-18, 19:18)
 * http://takiddine.com
 * MIT licensed
 *
 * Copyright (C) 2018 Soulaimane Takiddine , http://takiddine.com
 */

defined('BASEPATH') OR exit('No direct script access allowed');

define('SCRIPTURL','http://sarah.local/');
define('SCRIPTDIR', BASEPATH.'/');

return  [
    
    'app' => [
        'version'            => '1.0',
        'debug'              => 'true',
    ],
    
    'db' => [
        'driver'             => 'mysql',
        'host'               => 'localhost',
        'name'               => 'site',
        'username'           => 'root',
        'password'           => '',
        'charset'            => 'utf8',
        'collation'          => 'utf8_general_ci'
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
    ],  
    
    'app' => [
        'mode'               => '',
        'sandbox_cliend_id'  => '',
        'sandbox_secret_id'  => '',
        'live_cliend_id'     => '',
        'live_secret_id'     => '',
    ],
    
];