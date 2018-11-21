<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

defined('BASEPATH') OR exit('No direct script access allowed');


/*
*  Website Front End Routes
*/
$app->group('/', function () use($app) {
        
    
    
        // Home Page
        $app->get('', \App\Controllers\website\HomeController::class .':index')->setName('website.home');

        // contact us
        $app->get('contact[/]', \App\Controllers\website\ContactController::class .':index')->setName('website.contact');
        $app->post('contact', \App\Controllers\website\ContactController::class .':create')->setName('website.contact.post');

            $app->get('wishlist-to-card[/]', \App\Controllers\website\WishListController::class .':alltocart')->setName('wishlist-to-card');

    
    
        
        
        // Auth
        $app->get('login[/]', \App\Controllers\website\AuthController::class .':login_get')->setName('website.login');
        $app->post('login', \App\Controllers\website\AuthController::class .':login_post')->setName('website.login.post');
        $app->get('logout[/]', \App\Controllers\AuthController::class .':logout_user')->setName('website.logout');
        $app->get('register[/]', \App\Controllers\website\AuthController::class .':register_get')->setName('website.register');
        $app->post('register', \App\Controllers\website\AuthController::class .':register_post')->setName('website.register.post');
        $app->any('reset', \App\Controllers\website\AuthController::class .':resetPassword')->setName('website.reset');
        $app->any('resetPassword', \App\Controllers\website\AuthController::class .':resetForm')->setName('website.resetpassword');

        // Account
        $app->get('account[/]', \App\Controllers\website\AuthController::class .':account')->setName('website.account');

        // Statique Pages
//        $app->get('faqs[/]', \App\Controllers\website\StatiquePagesController::class .':faqs')->setName('website.faqs');
        $app->get('about-us[/]', \App\Controllers\website\StatiquePagesController::class .':about')->setName('website.about-us');

        // 
        $app->get('checkout', \App\Controllers\website\ShopController::class .':checkout')->setName('website.checkout');
        $app->post('checkout', \App\Controllers\OrdersController::class .':create')->setName('website.order');
    
    
    
    
    
        $app->get('cart[/]', \App\Controllers\website\CartController::class .':index')->setName('website.cart');
        $app->post('cart/{id}', \App\Controllers\website\CartController::class .':add')->setName('cart.add');
        $app->get('cart/delete/{id}', \App\Controllers\website\CartController::class .':delete')->setName('cart.delete');
        $app->get('product/{id}[/]', \App\Controllers\website\ProductController::class .':index')->setName('website.product');
        $app->post('rate[/]', \App\Controllers\website\ProductController::class .':rate')->setName('product.rate');
        
    
        $app->get('collections/{slug}[/]', \App\Controllers\website\ShopController::class .':cat')->setName('website.shop.cats');
       
        /*
        *   Shopping System
        */
        $app->group('shop', function () use ($app) {
            $app->get('[/]', \App\Controllers\website\ShopController::class .':index')->setName('website.shop');
        });
    
        $app->get('category/{slug}', \App\Controllers\website\ShopController::class .':index')->setName('website.category');
        $app->post('favorite/{id}', \App\Controllers\ProductsController::class .':favorite')->setName('website.favorite');

    
        // Wish List
        $app->get('wish-list[/]', \App\Controllers\website\WishListController::class .':index')->setName('website.wishlist');
        $app->get('wishlist/add/{id}[/]', \App\Controllers\website\WishListController::class .':add')->setName('wishlist.add');
        $app->get('wish-list/delete/{id}[/]', \App\Controllers\website\WishListController::class .':delete')->setName('wishlist.delete');

        // Blog Articles & comments
        $app->get('blog[/]', \App\Controllers\website\BlogController::class .':index')->setName('website.blog');
        $app->get('blog/{id}[/]', \App\Controllers\website\BlogController::class .':article')->setName('website.post');
        $app->post('comments', \App\Controllers\website\CommentsController::class .':create')->setName('website.comment');
        $app->get('blog/categories/{id}', \App\Controllers\website\BlogController::class .':categorie')->setName('blog.categorie');
    

        // Search
        $app->get('search', \App\Controllers\website\SearchController::class .':index')->setName('website.search');
    
        // Faq , Frequented Asked Questions
        $app->get('faqs', \App\Controllers\FaqsController::class .':front')->setName('website.faqs');

   
});


//$app->add( new App\Middleware\MinifierMiddleware($container) );




