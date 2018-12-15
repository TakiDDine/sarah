<?php

namespace App\Controllers\website;

use App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Classes\files;
use \App\Models\Emails;
use \App\Models\WishList;
use \App\Models\Product;
use \App\Models\Cart;

class WishListController extends \App\Controllers\Controller{
  
    
    // display all my wishlist Products
    public function index($request,$response) {
       $wishlist = WishList::whereUser_id($_SESSION['auth-user'])->get()->toArray();
        $maincart = [];
        foreach($wishlist as $item ) {
            $product = Product::where('id',$item['productID'])->first()->toArray();
            $product['productID'] = $product['id'];
            $item['wishID'] = $item['id'];
            $mainwish[] =  array_merge($product,$item);
        }
   
       return $this->view->render($response,'website/wish-list.twig',['wishlist'=>$mainwish]);
    }
    
    
    // add all the products to wish list
    public function alltocart($request,$response) {
       $wishlist = WishList::where('user_id',$_SESSION['auth-user'])->get()->toArray();
       foreach($wishlist as $item ) {
            Cart::create([
                'user_id' => $_SESSION['auth-user'],
                'productID' => $item['productID'] ,
                'quantity' => 1
            ]);
            $this->flashsuccess('تم إضافة جميع المنتجات الى السلة');
           return $response->withRedirect($this->router->pathFor('website.wishlist'));
       }
    }
    
    
    // add the product to the wishlist
    public function add($request,$response,$args) {
        
        // get the product id
        $id = rtrim($args['id'], '/');
        
        // add product to wish list
        WishList::create([ 'user_id' => $_SESSION['auth-user'], 'productID' => $id ]);
        
        // flash success & redirect
        $this->flashsuccess('تم إضافة المنتوج إلى قائمة الأمنيات بنجاح');
        return $response->withRedirect($this->router->pathFor('website.wishlist',['id'=>$id]));
    }
    
    
    // delete the product from wishlist
    public function delete($request,$response,$args) {
        $id = rtrim($args['id'], '/');
        $wish = WishList::find($id);
        if($wish){
            $wish->delete();
            $this->flashsuccess('تم ازالة المنتوج من قائمة الأمنيات بنجاح');
        }
        return $response->withRedirect($this->router->pathFor('website.product',['id'=>$id]));
    }
   
    
}

