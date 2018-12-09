<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

defined('BASEPATH') OR exit('No direct script access allowed');


/*
*  Admin Routes
*/
$app->group('/dashboard', function () use($app) {

    
    
    $app->get('/FileManager[/]', \App\Controllers\HomeController::class .':FileManager')->setName('FileManager');
    

    /*
    *    Statique Pages
    */
    $app->get('[/]', \App\Controllers\HomeController::class .':home')->setName('admin.index');
    $app->get('/statistiques[/]', \App\Controllers\StatiqueController::class .':statistiques')->setName('statistiques');
    $app->get('/account[/]', \App\Controllers\HomeController::class .':account')->setName('account');

    
    /*
    *    users System
    */
    $app->group('/users', function () use ($app) {
        $app->get('[/]', \App\Controllers\UsersController::class .':index')->setName('users');
        $app->any('/create[/]', \App\Controllers\UsersController::class .':create')->setName('users.create');
        $app->any('/mutliAction[/]', \App\Controllers\UsersController::class .':mutliAction')->setName('users.mutliAction');        
        $app->get('/export/csv[/]', \App\Controllers\UsersController::class .':export_csv')->setName('usersToCsv');
        $app->get('/export/pdf[/]', \App\Controllers\UsersController::class .':export_pdf')->setName('usersToPdf');
        $app->get('/blukdelete[/]', \App\Controllers\UsersController::class .':blukdelete')->setName('users.blukdelete');
        $app->any('/{username}[/]', \App\Controllers\UsersController::class .':edit')->setName('users.edit');
    });
    
    
    /*
    *    Ads System
    */
    $app->group('/ads', function () use ($app) {
        $app->get('[/]', \App\Controllers\AdsController::class .':index')->setName('ads');
        $app->any('/create[/]', \App\Controllers\AdsController::class .':create')->setName('ads.create');
        $app->get('/blukdelete[/]', \App\Controllers\AdsController::class .':blukdelete')->setName('ads.blukdelete');
        $app->any('/{id}[/]', \App\Controllers\AdsController::class .':show')->setName('ads.show');
        $app->get('/delete/{id}[/]', \App\Controllers\AdsController::class .':delete')->setName('ads.delete');
       
    });
    
    
    /*
    *   Mail System
    */
    $app->group('/mail', function () use ($app) {
        $app->get('[/]', \App\Controllers\MailController::class .':index')->setName('mail');
        $app->get('/{id}[/]', \App\Controllers\MailController::class .':show')->setName('getMail');
        $app->post('/{id}[/]', \App\Controllers\MailController::class .':Action')->setName('Mail.action');
        $app->get('blukdelete[/]', \App\Controllers\MailController::class .':blukdelete')->setName('Mail.blukdelete');
    });
    

    /*
    *   INBOX System
    */
    $app->group('/inbox', function () use ($app) {
        $app->get('[/]', \App\Controllers\EmailController::class .':index')->setName('inbox');
        $app->any('/create[/]', \App\Controllers\EmailController::class .':create')->setName('inbox.create');
        $app->any('/edit/{id}[/]', \App\Controllers\EmailController::class .':edit')->setName('inbox.edit');
        $app->any('/delete/{id}[/]', \App\Controllers\EmailController::class .':delete')->setName('inbox.delete');
        $app->any('/blukdelete[/]', \App\Controllers\EmailController::class .':blukdelete')->setName('inbox.blukdelete');
    });



    /*
    *    Settings System
    */
    $app->group('/settings', function () use ($app) {
        $app->get('[/]', \App\Controllers\settingsController::class .':index')->setName('settings');
        $app->post('', \App\Controllers\settingsController::class .':general')->setName('settings.general');
        $app->get('/social[/]', \App\Controllers\settingsController::class .':socialGet')->setName('settings.social');
        $app->post('/social[/]', \App\Controllers\settingsController::class .':socialPost')->setName('settings.social');
        $app->get('/users[/]', \App\Controllers\settingsController::class .':users')->setName('settings.users');
        $app->map(['GET', 'POST'],'/email[/]', \App\Controllers\settingsController::class .':email')->setName('settings.email');
        $app->get('/links[/]', \App\Controllers\settingsController::class .':links')->setName('settings.links');
        $app->any('/home[/]', \App\Controllers\settingsController::class .':home')->setName('settings.home');
        $app->any('/account[/]', \App\Controllers\settingsController::class .':account')->setName('settings.account');
        $app->any('/footer[/]', \App\Controllers\settingsController::class .':footer')->setName('settings.footer');
        $app->any('/others[/]', \App\Controllers\settingsController::class .':others')->setName('settings.others');
        $app->any('/connect[/]', \App\Controllers\settingsController::class .':connect')->setName('settings.connect');
    });
    
    
    
    /*
    *    Slider System
    */
    $app->group('/slider', function () use ($app) {
       $app->any('[/]', \App\Controllers\SliderController::class .':index')->setName('slider');
       $app->any('/create', \App\Controllers\SliderController::class .':create')->setName('slider.create');
       $app->any('/edit/{id}[/]', \App\Controllers\SliderController::class .':edit')->setName('slider.edit');
       $app->get('/delete/{id}[/]', \App\Controllers\SliderController::class .':delete')->setName('slider.delete');
    });
    
    $app->any('/beside-slider[/]', \App\Controllers\settingsController::class .':slider')->setName('beside-slider');


    
    /*
    *    Comments System
    */
    $app->group('/comments', function () use ($app) {
       $app->get('[/]', \App\Controllers\CommentsController::class .':index')->setName('comments');
       $app->any('/edit/{id}[/]', \App\Controllers\CommentsController::class .':edit')->setName('comments.edit');
       $app->any('/create[/]', \App\Controllers\CommentsController::class .':create')->setName('comments.create');
       $app->get('/delete/{id}[/]', \App\Controllers\CommentsController::class .':delete')->setName('comments.delete');
       $app->get('/blukdelete[/]', \App\Controllers\CommentsController::class .':blukdelete')->setName('comments.blukdelete');
    });


  
    /*
    *   Menu System
    */
    $app->group('/menus', function () use ($app) {
        $app->any('[/]', \App\Controllers\MenusController::class .':index')->setName('menus');
        $app->any('/create[/]', \App\Controllers\MenusController::class .':create')->setName('menus.create');
        $app->any('/edit/{id}[/]', \App\Controllers\MenusController::class .':edit')->setName('menus.edit');
        $app->any('/delete/{id}[/]', \App\Controllers\MenusController::class .':delete')->setName('menus.delete');
        $app->any('/blukdelete[/]', \App\Controllers\MenusController::class .':blukdelete')->setName('menus.blukdelete');
    });


    /*
    *   Statique Pages System
    */
    $app->get('/javascript-Disabled[/]', \App\Controllers\javascriptDisabled::class .':jsDisabled')->setName('javascript-Disabled');
    $app->get('/logs[/]', \App\Controllers\StatiqueController::class .':logs')->setName('logs');
    $app->get('/mailist[/]', \App\Controllers\MailListsController::class .':index')->setName('mailist');
    $app->post('/mailist/add[/]', \App\Controllers\MailListsController::class .':add')->setName('mailist.add');
    
    /*
    *    posts System
    */
    $app->group('/posts', function () use ($app) {
        $app->get('[/]', \App\Controllers\PostsController::class .':index')->setName('posts');
        $app->any('/create[/]', \App\Controllers\PostsController::class .':create')->setName('posts.create');
        $app->any('/edit/{id}[/]', \App\Controllers\PostsController::class .':edit')->setName('posts.edit');
        $app->get('/delete/{id}[/]', \App\Controllers\PostsController::class .':delete')->setName('posts.delete');
        $app->get('/duplicate/{id}[/]', \App\Controllers\PostsController::class .':duplicate')->setName('posts.duplicate');
        $app->get('/blukdelete[/]', \App\Controllers\PostsController::class .':blukdelete')->setName('posts.blukdelete');
        $app->any('/mutliAction[/]', \App\Controllers\PostsController::class .':mutliAction')->setName('posts.mutliAction');

        
        $app->group('/categories', function () use ($app) {
            $app->any('[/]', \App\Controllers\PostsCategoriesController::class .':index')->setName('posts.categories');
            $app->get('/edit/{id}[/]', \App\Controllers\PostsCategoriesController::class .':edit')->setName('posts.categories.edit');
            $app->post('/edit/{id}[/]', \App\Controllers\PostsCategoriesController::class .':edit')->setName('posts.categories.edit');
            $app->get('/delete/{id}[/]', \App\Controllers\PostsCategoriesController::class .':delete')->setName('posts.categories.delete');
        });
        
    });
    
    
    
    
    /*
    *   permissions System
    */
    $app->group('/permissions', function () use ($app) {
        $app->any('[/]', \App\Controllers\PermissionsController::class .':index')->setName('permissions');
        $app->post('/create[/]', \App\Controllers\PermissionsController::class .':create')->setName('permissions.create');
        $app->any('/edit/{id}[/]', \App\Controllers\PermissionsController::class .':edit')->setName('permissions.edit');
        $app->any('/delete/{id}[/]', \App\Controllers\PermissionsController::class .':delete')->setName('permissions.delete');
        $app->any('/blukdelete[/]', \App\Controllers\PermissionsController::class .':blukdelete')->setName('permissions.blukdelete');
    });
    
    
    
    
    
    
    
    
    
    
    
    
    
    /*
    *    Faqs System
    */
    $app->group('/faqs', function () use ($app) {
        $app->get('[/]', \App\Controllers\FaqsController::class .':index')->setName('faqs');
        $app->any('/create[/]', \App\Controllers\FaqsController::class .':create')->setName('faqs.create');
        $app->any('/edit/{id}[/]', \App\Controllers\FaqsController::class .':edit')->setName('faqs.edit');
        $app->get('/delete/{id}[/]', \App\Controllers\FaqsController::class .':delete')->setName('faqs.delete');
        $app->get('/duplicate/{id}[/]', \App\Controllers\FaqsController::class .':duplicate')->setName('faqs.duplicate');
        $app->get('/blukdelete[/]', \App\Controllers\FaqsController::class .':blukdelete')->setName('faqs.blukdelete');
        
        $app->group('/categories', function () use ($app) {
            $app->any('[/]', \App\Controllers\FaqsController::class .':categories')->setName('faqs.categories');
            $app->any('/edit/{id}[/]', \App\Controllers\FaqsController::class .':categories_edit')->setName('faqs.cat.edit');
            $app->any('/delete/{id}[/]', \App\Controllers\FaqsController::class .':categories_delete')->setName('faqs.cat.delete');
            $app->any('/create[/]', \App\Controllers\FaqsController::class .':categories_create')->setName('faqs.cat.create');
        });
        
    });
    
    
    /*
    ===========================================================================================================
    */
    
    /*
    *    Media System
    */
    $app->group('/media', function () use ($app) {
        $app->get('[/]', \App\Controllers\MediaController::class .':index')->setName('media');
        $app->any('/view/{id}[/]', \App\Controllers\MediaController::class .':view')->setName('media.view');
        $app->post('/upload[/]', \App\Controllers\MediaController::class .':upload')->setName('media.upload');
        $app->any('/delete[/]', \App\Controllers\MediaController::class .':delete')->setName('media.delete');
        $app->get('/blukdelete[/]', \App\Controllers\MediaController::class .':blukdelete')->setName('media.blukdelete');
        $app->any('/uploader[/]', \App\Controllers\MediaController::class .':modal_uploader')->setName('media.modal_uploader');
        $app->any('/download/{id}[/]', \App\Controllers\MediaController::class .':download')->setName('media.download');
    });
    
    
    /*
    *    Media System
    */
    $app->group('/emails', function () use ($app) {
        $app->get('[/]', \App\Controllers\EmailsController::class .':index')->setName('emails');
        $app->any('/create[/]', \App\Controllers\EmailsController::class .':send')->setName('emails.create');
        $app->any('/delete/{id}[/]', \App\Controllers\EmailsController::class .':delete')->setName('emails.delete');
        $app->get('blukdelete[/]', \App\Controllers\EmailsController::class .':blukdelete')->setName('emails.blukdelete');
    });
    
    /*
    *    Coupons System
    */
    $app->group('/coupons', function () use ($app) {
        $app->get('[/]', \App\Controllers\CouponsController::class .':index')->setName('coupons');
        $app->any('/create[/]', \App\Controllers\CouponsController::class .':create')->setName('coupons.create');
        $app->any('/edit/{id}[/]', \App\Controllers\CouponsController::class .':edit')->setName('coupons.edit');
        $app->any('/delete/{id}[/]', \App\Controllers\CouponsController::class .':delete')->setName('coupons.delete');
        $app->get('blukdelete[/]', \App\Controllers\CouponsController::class .':blukdelete')->setName('coupons.blukdelete');
    });
    
    /*
    ===========================================================================================================
    */
    
    
    /*
    *    Pages System
    */
    $app->group('/pages', function () use ($app) {
        $app->get('[/]', \App\Controllers\PagesController::class .':index')->setName('pages');
        $app->any('{id}[/]', \App\Controllers\PagesController::class .':create')->setName('pages.view');
        $app->any('/create[/]', \App\Controllers\PagesController::class .':create')->setName('pages.create');
        $app->any('/edit/{id}[/]', \App\Controllers\PagesController::class .':edit')->setName('pages.edit');
        $app->get('/delete/{id}[/]', \App\Controllers\PagesController::class .':delete')->setName('pages.delete');
        $app->get('/duplicate/{id}[/]', \App\Controllers\PagesController::class .':duplicate')->setName('pages.duplicate');
        $app->get('/blukdelete[/]', \App\Controllers\PagesController::class .':blukdelete')->setName('pages.blukdelete');
        $app->any('/mutliAction[/]', \App\Controllers\PagesController::class .':mutliAction')->setName('pages.mutliAction');
        
    });
    
    
    /*
    *    Orders System
    */
    $app->group('/orders', function () use ($app) {
        $app->get('[/]', \App\Controllers\OrdersController::class .':index')->setName('orders');
        $app->any('/view/{id}[/]', \App\Controllers\OrdersController::class .':edit')->setName('orders.edit');
        $app->any('/delete/{id}[/]', \App\Controllers\OrdersController::class .':delete')->setName('orders.delete');
        $app->get('blukdelete[/]', \App\Controllers\OrdersController::class .':blukdelete')->setName('orders.blukdelete');
    });
    
    

    
    
    
    
   
    
    /*
    *    Products system
    */
    $app->group('/products', function () use ($app) {
        $app->get('[/]', \App\Controllers\ProductsController::class .':index')->setName('products');
        $app->any('/create[/]', \App\Controllers\ProductsController::class .':create')->setName('products.create');
        $app->any('/edit/{id}[/]', \App\Controllers\ProductsController::class .':edit')->setName('products.edit');
        $app->get('/delete/{id}[/]', \App\Controllers\ProductsController::class .':delete')->setName('products.delete');
        $app->get('/duplicate/{id}[/]', \App\Controllers\ProductsController::class .':duplicate')->setName('products.duplicate');
        $app->get('/blukdelete[/]', \App\Controllers\ProductsController::class .':blukdelete')->setName('products.blukdelete');
        $app->group('/categories', function () use ($app) {
            $app->any('[/]', \App\Controllers\ProductsCategoriesController::class .':index')->setName('products.categories');
            $app->get('/edit/{id}[/]', \App\Controllers\ProductsCategoriesController::class .':edit')->setName('products.categories.edit');
            $app->post('/edit/{id}[/]', \App\Controllers\ProductsCategoriesController::class .':edit')->setName('products.categories.edit');
            $app->get('/delete/{id}[/]', \App\Controllers\ProductsCategoriesController::class .':delete')->setName('products.categories.delete');
        });
    });
    

    $app->get('/{404}[/]', \App\Controllers\HomeController::class .':home');


})->add( new App\Middleware\authMiddleware($container) );

    /*
    *    Authentication System
    */
    $app->group('/auth', function () use ($app) {
        $app->post('/login[/]', \App\Controllers\AuthController::class .':login')->setName('login');
        $app->get('/recover[/]', \App\Controllers\AuthController::class .':recover')->setName('recover');
        $app->post('/recover[/]', \App\Controllers\AuthController::class .':recover');
        $app->get('/logout[/]', \App\Controllers\AuthController::class .':logout')->setName('logout');
        $app->get('/reset[/]', \App\Controllers\AuthController::class .':resetPasswordGet')->setName('resetPassword');
        $app->post('/reset[/]', \App\Controllers\AuthController::class .':resetPasswordPost')->setName('postNewPassword');        
        $app->get('/rested', \App\Controllers\AuthController::class .':reseted')->setName('rested');        
    });


/*
*   Middlewares
*/
$app->add( new App\Middleware\flashMiddleware($container) );
$app->add( new App\Middleware\OldInputMidddleware($container) );


