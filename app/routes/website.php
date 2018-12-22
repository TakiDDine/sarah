<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


use \App\Controllers\website\AuthController as auth;
use \App\Controllers\website\HomeController as home;
use \App\Controllers\website\ContactController as contact;
use \App\Controllers\website\WishListController as wish;
use \App\Controllers\website\StatiquePagesController as statique;
use \App\Controllers\website\ShopController as shop;
use \App\Controllers\website\BlogController as blog;
use \App\Controllers\website\CommentsController as comment;
use \App\Controllers\website\SearchController as search;
use \App\Controllers\FaqsController as faq;
use \App\Controllers\website\ProductController as product;
use \App\Controllers\website\CartController as cart;
use \App\Controllers\OrdersController as order;
use \App\Controllers\installController as install;
use \App\Controllers\website\PagesController as pages;




defined('BASEPATH') OR exit('No direct script access allowed');








/*
*  Website Front End Routes
*/
$app->group('/', function () use($app) {
    
        // website installer 
        $app->get('install[/]', install::class .':index')->setName('website.install');
        
        // Home Page
        $app->get('', home::class .':index')->setName('website.home');

        // Auth
        $app->get('login[/]', auth::class .':login_get')->setName('website.login');
        $app->post('login', auth::class .':login_post')->setName('website.login.post');
        $app->get('logout[/]', \App\Controllers\AuthController::class .':logout_user')->setName('website.logout');
        $app->any('register[/]', auth::class .':register')->setName('website.register');
        $app->any('reset', auth::class .':resetPassword')->setName('website.reset');
        $app->any('resetPassword', auth::class .':resetForm')->setName('website.resetpassword');
        $app->get('account[/]', auth::class .':account')->setName('website.account');

        $app->get('page/{id}', pages::class .':page')->setName('website.page');
    
        // Statique Pages
        $app->get('about-us[/]', statique::class .':about')->setName('website.about-us');
        $app->get('contact[/]', contact::class .':index')->setName('website.contact');
        $app->post('contact', contact::class .':create')->setName('website.contact.post');

        // Shopping System
        $app->get('shop[/]', shop::class .':index')->setName('website.shop');
        $app->get('collections/{slug}[/]', shop::class .':cat')->setName('website.shop.cats');
        $app->get('category/{slug}', shop::class .':index')->setName('website.category');
        $app->post('favorite/{id}', product::class .':favorite')->setName('website.favorite');
        $app->get('cart[/]', cart::class .':index')->setName('website.cart');
        $app->post('cart/{id}', cart::class .':add')->setName('cart.add');
        $app->get('cart/delete/{id}', cart::class .':delete')->setName('cart.delete');
        $app->get('product/{id}[/]', product::class .':index')->setName('website.product');
        $app->post('rate[/]', product::class .':rate')->setName('product.rate');
        $app->get('checkout', shop::class .':checkout')->setName('website.checkout');
        $app->post('checkout', order::class .':create')->setName('website.order');
        $app->get('wishlist-to-card[/]', wish::class .':alltocart')->setName('wishlist-to-card');
    

        // Wish List
        $app->get('wish-list[/]', wish::class .':index')->setName('website.wishlist');
        $app->get('wishlist/add/{id}[/]', wish::class .':add')->setName('wishlist.add');
        $app->get('wish-list/delete/{id}[/]', wish::class .':delete')->setName('wishlist.delete');

    
        // Blog Articles & comments
        $app->get('blog[/]', blog::class .':index')->setName('website.blog');
        $app->get('blog/{id}[/]', blog::class .':article')->setName('website.post');
        $app->post('comments', comment::class .':create')->setName('website.comment');
        $app->get('blog/categories/{id}', blog::class .':categorie')->setName('blog.categorie');
    

        // Search
        $app->get('search', search::class .':index')->setName('website.search');
    
        // Faq , Frequented Asked Questions
        $app->get('faqs', faq::class .':front')->setName('website.faqs');
   
})->add( new App\Middleware\downMiddleware($container) );
