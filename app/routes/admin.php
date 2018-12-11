<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Controllers as admin;

// make namespace short
use \App\Controllers\AuthController as auth;
use \App\Controllers\UsersController as users;
use \App\Controllers\MenusController as menus;
use \App\Controllers\CommentsController as comment;
use \App\Controllers\MediaController as media;
use \App\Controllers\PagesController as pages;
use \App\Controllers\FaqsController as faqs;
use \App\Controllers\AdsController as ads;
use \App\Controllers\PostsController as posts;
use \App\Controllers\PostsCategoriesController as postscats;
use \App\Controllers\EmailController as inbox;
use \App\Controllers\MailController as mail;
use \App\Controllers\settingsController as settings;
use \App\Controllers\PermissionsController as role;
use \App\Controllers\CouponsController as copons;
use \App\Controllers\ProductsController as products;
use \App\Controllers\ProductsCategoriesController as productscats;
use \App\Controllers\OrdersController as orders;
use \App\Controllers\EmailsController as emails;
use \App\Controllers\SliderController as slider;



// security , disable direct access
defined('BASEPATH') or exit('No direct script access allowed');


/*
*  Admin Routes
*/
$app->group('/dashboard', function () use($app) {

    
    // Dashboard index
    $this->get('[/]', admin\HomeController::class .':home')->setName('admin.index');
    
    
    // users System
    $this->group('/users', function () {
        $this->get('[/]', users::class .':index')->setName('users');
        $this->any('/create[/]', users::class .':create')->setName('users.create');
        $this->any('/mutliAction[/]', users::class .':mutliAction')->setName('users.mutliAction');        
        $this->get('/export/csv[/]', users::class .':export_csv')->setName('usersToCsv');
        $this->get('/export/pdf[/]', users::class .':export_pdf')->setName('usersToPdf');
        $this->get('/blukdelete[/]', users::class .':blukdelete')->setName('users.blukdelete');
        $this->any('/{username}[/]', users::class .':edit')->setName('users.edit');
    });
    
    
    // Menu System
    $this->group('/menus', function (){
        $this->any('[/]', menus::class .':index')->setName('menus');
        $this->any('/create[/]', menus::class .':create')->setName('menus.create');
        $this->any('/edit/{id}[/]', menus::class .':edit')->setName('menus.edit');
        $this->any('/delete/{id}[/]', menus::class .':delete')->setName('menus.delete');
        $this->any('/blukdelete[/]', menus::class .':blukdelete')->setName('menus.blukdelete');
    });
    
    
    // Comments System
    $this->group('/comments', function (){
       $this->get('[/]', comment::class .':index')->setName('comments');
       $this->any('/edit/{id}[/]', comment::class .':edit')->setName('comments.edit');
       $this->any('/create[/]', comment::class .':create')->setName('comments.create');
       $this->get('/delete/{id}[/]', comment::class .':delete')->setName('comments.delete');
       $this->get('/blukdelete[/]', comment::class .':blukdelete')->setName('comments.blukdelete');
    });
    
    
    // Media System
    $this->group('/media', function (){
        $this->get('[/]', media::class .':index')->setName('media');
        $this->any('/view/{id}[/]', media::class .':view')->setName('media.view');
        $this->post('/upload[/]', media::class .':upload')->setName('media.upload');
        $this->any('/delete[/]', media::class .':delete')->setName('media.delete');
        $this->get('/blukdelete[/]', media::class .':blukdelete')->setName('media.blukdelete');
        $this->any('/uploader[/]', media::class .':modal_uploader')->setName('media.modal_uploader');
        $this->any('/download/{id}[/]', media::class .':download')->setName('media.download');
    });
    
    
    // Pages System
    $this->group('/pages', function (){
        $this->get('[/]', pages::class .':index')->setName('pages');
        $this->any('{id}[/]', pages::class .':create')->setName('pages.view');
        $this->any('/create[/]', pages::class .':create')->setName('pages.create');
        $this->any('/edit/{id}[/]', pages::class .':edit')->setName('pages.edit');
        $this->get('/delete/{id}[/]', pages::class .':delete')->setName('pages.delete');
        $this->get('/duplicate/{id}[/]', pages::class .':duplicate')->setName('pages.duplicate');
        $this->get('/blukdelete[/]', pages::class .':blukdelete')->setName('pages.blukdelete');
        $this->any('/mutliAction[/]', pages::class .':mutliAction')->setName('pages.mutliAction');
    });
    
    
    // Ads System
    $this->group('/ads', function () {
        $this->get('[/]', ads::class .':index')->setName('ads');
        $this->any('/create[/]', ads::class .':create')->setName('ads.create');
        $this->get('/blukdelete[/]', ads::class .':blukdelete')->setName('ads.blukdelete');
        $this->any('/{id}[/]', ads::class .':show')->setName('ads.show');
        $this->get('/delete/{id}[/]', ads::class .':delete')->setName('ads.delete');
    });
    
    
    // Faqs System
    $this->group('/faqs', function (){
        $this->get('[/]', faqs::class .':index')->setName('faqs');
        $this->any('/create[/]', faqs::class .':create')->setName('faqs.create');
        $this->any('/edit/{id}[/]', faqs::class .':edit')->setName('faqs.edit');
        $this->get('/delete/{id}[/]', faqs::class .':delete')->setName('faqs.delete');
        $this->get('/duplicate/{id}[/]', faqs::class .':duplicate')->setName('faqs.duplicate');
        $this->get('/blukdelete[/]', faqs::class .':blukdelete')->setName('faqs.blukdelete');
        
        // Faqs Categories
        $this->group('/categories', function (){
            $this->any('[/]', faqs::class .':categories')->setName('faqs.categories');
            $this->any('/edit/{id}[/]', faqs::class .':categories_edit')->setName('faqs.cat.edit');
            $this->any('/delete/{id}[/]', faqs::class .':categories_delete')->setName('faqs.cat.delete');
            $this->any('/create[/]', faqs::class .':categories_create')->setName('faqs.cat.create');
        });
    });
    
    
    //  posts System
    $this->group('/posts', function (){
        $this->get('[/]', posts::class .':index')->setName('posts');
        $this->any('/create[/]', posts::class .':create')->setName('posts.create');
        $this->any('/edit/{id}[/]', posts::class .':edit')->setName('posts.edit');
        $this->get('/delete/{id}[/]', posts::class .':delete')->setName('posts.delete');
        $this->get('/duplicate/{id}[/]', posts::class .':duplicate')->setName('posts.duplicate');
        $this->get('/blukdelete[/]', posts::class .':blukdelete')->setName('posts.blukdelete');
        $this->any('/mutliAction[/]', posts::class .':mutliAction')->setName('posts.mutliAction');

        // posts categories
        $this->group('/categories', function (){
            $this->any('[/]', postscats::class .':index')->setName('posts.categories');
            $this->get('/edit/{id}[/]', postscats::class .':edit')->setName('posts.categories.edit');
            $this->post('/edit/{id}[/]', postscats::class .':edit')->setName('posts.categories.edit');
            $this->get('/delete/{id}[/]', postscats::class .':delete')->setName('posts.categories.delete');
        });
    });
    
    
    // inbox System
    $this->group('/inbox', function (){
        $this->get('[/]', inbox::class .':index')->setName('inbox');
        $this->any('/create[/]', inbox::class .':create')->setName('inbox.create');
        $this->any('/edit/{id}[/]', inbox::class .':edit')->setName('inbox.edit');
        $this->any('/delete/{id}[/]', inbox::class .':delete')->setName('inbox.delete');
        $this->any('/blukdelete[/]', inbox::class .':blukdelete')->setName('inbox.blukdelete');
    });
    
    
    // Mail System
    $this->group('/mail', function (){
        $this->get('[/]', mail::class .':index')->setName('mail');
        $this->get('/{id}[/]', mail::class .':show')->setName('getMail');
        $this->post('/{id}[/]', mail::class .':Action')->setName('Mail.action');
        $this->get('blukdelete[/]', mail::class .':blukdelete')->setName('Mail.blukdelete');
    });
    
    
    // Settings System
    $this->group('/settings', function (){
        $this->get('[/]', settings::class .':index')->setName('settings');
        $this->post('', settings::class .':general')->setName('settings.general');
        $this->get('/social[/]', settings::class .':socialGet')->setName('settings.social');
        $this->post('/social[/]', settings::class .':socialPost')->setName('settings.social');
        $this->get('/users[/]', settings::class .':users')->setName('settings.users');
        $this->map(['GET', 'POST'],'/email[/]', settings::class .':email')->setName('settings.email');
        $this->get('/links[/]', settings::class .':links')->setName('settings.links');
        $this->any('/home[/]', settings::class .':home')->setName('settings.home');
        $this->any('/account[/]', settings::class .':account')->setName('settings.account');
        $this->any('/footer[/]', settings::class .':footer')->setName('settings.footer');
        $this->any('/others[/]', settings::class .':others')->setName('settings.others');
        $this->any('/connect[/]', settings::class .':connect')->setName('settings.connect');
    });
    
    
    // permissions System
    $this->group('/permissions', function (){
        $this->any('[/]', role::class .':index')->setName('permissions');
        $this->post('/create[/]', role::class .':create')->setName('permissions.create');
        $this->any('/edit/{id}[/]', role::class .':edit')->setName('permissions.edit');
        $this->any('/delete/{id}[/]', role::class .':delete')->setName('permissions.delete');
        $this->any('/blukdelete[/]', role::class .':blukdelete')->setName('permissions.blukdelete');
    });
    
    
    // Coupons System
    $this->group('/coupons', function (){
        $this->get('[/]', copons::class .':index')->setName('coupons');
        $this->any('/create[/]', copons::class .':create')->setName('coupons.create');
        $this->any('/edit/{id}[/]', copons::class .':edit')->setName('coupons.edit');
        $this->any('/delete/{id}[/]', copons::class .':delete')->setName('coupons.delete');
        $this->get('blukdelete[/]', copons::class .':blukdelete')->setName('coupons.blukdelete');
    });
    
    
    // Products system
    $this->group('/products', function (){
        $this->get('[/]', products::class .':index')->setName('products');
        $this->any('/create[/]', products::class .':create')->setName('products.create');
        $this->any('/edit/{id}[/]', products::class .':edit')->setName('products.edit');
        $this->get('/delete/{id}[/]', products::class .':delete')->setName('products.delete');
        $this->get('/duplicate/{id}[/]', products::class .':duplicate')->setName('products.duplicate');
        $this->get('/blukdelete[/]', products::class .':blukdelete')->setName('products.blukdelete');
        
        // products cateogies
        $this->group('/categories', function (){
            $this->any('[/]', productscats::class .':index')->setName('products.categories');
            $this->any('/edit/{id}[/]', productscats::class .':edit')->setName('products.categories.edit');
            $this->get('/delete/{id}[/]', productscats::class .':delete')->setName('products.categories.delete');
        });
    });
    
    
    // Orders System
    $this->group('/orders', function (){
        $this->get('[/]', orders::class .':index')->setName('orders');
        $this->any('/edit/{id}[/]', orders::class .':edit')->setName('orders.edit');
        $this->any('/delete/{id}[/]', orders::class .':delete')->setName('orders.delete');
        $this->get('blukdelete[/]', orders::class .':blukdelete')->setName('orders.blukdelete');
    });
    
    
    // Slider System
    $this->group('/slider', function (){
       $this->any('[/]', slider::class .':index')->setName('slider');
       $this->any('/create', slider::class .':create')->setName('slider.create');
       $this->any('/edit/{id}[/]', slider::class .':edit')->setName('slider.edit');
       $this->get('/delete/{id}[/]', slider::class .':delete')->setName('slider.delete');
       $this->any('/beside-slider[/]', settings::class .':slider')->setName('beside-slider');
    });


    // Statique Pages System
    $this->get('/account[/]', admin\HomeController::class .':account')->setName('account');
    $this->get('/javascript-Disabled[/]', admin\javascriptDisabled::class .':jsDisabled')->setName('javascript-Disabled');
    $this->get('/logs[/]', admin\StatiqueController::class .':logs')->setName('logs');
    $this->get('/mailist[/]', admin\MailListsController::class .':index')->setName('mailist');
    $this->post('/mailist/add[/]', admin\MailListsController::class .':add')->setName('mailist.add');
    $this->get('/FileManager[/]', admin\HomeController::class .':FileManager')->setName('FileManager');



})->add( new App\Middleware\authMiddleware($container) );

    /*
    *    Authentication System
    */
    $app->group('/auth', function (){
        $this->post('/login[/]', auth::class .':login')->setName('login');
        $this->any('/recover[/]', auth::class .':recover')->setName('recover');
        $this->get('/logout[/]', auth::class .':logout')->setName('logout');
        $this->get('/reset[/]', auth::class .':resetPasswordGet')->setName('resetPassword');
        $this->post('/reset[/]', auth::class .':resetPasswordPost')->setName('postNewPassword');        
        $this->get('/rested', auth::class .':reseted')->setName('rested');        
    });


/*
*   Middlewares
*/
$app->add( new App\Middleware\flashMiddleware($container) );
$app->add( new App\Middleware\OldInputMidddleware($container) );


