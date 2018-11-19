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
  
    
 public function index($request,$response) {
       $wishlist = WishList::where('user_id',$_SESSION['auth-user'])->get()->toArray();
        $maincart = [];
        foreach($wishlist as $item ) {
            $product = Product::where('id',$item['productID'])->first()->toArray();
            $product['productID'] = $product['id'];
            $item['wishID'] = $item['id'];
            $mainwish[] =  array_merge($product,$item);
        }
   
       return $this->container->view->render($response,'website/wish-list.twig',['wishlist'=>$mainwish]);
    }
    
    
    public function alltocart($request,$response) {
     
       $wishlist = WishList::where('user_id',$_SESSION['auth-user'])->get()->toArray();
        
        
       foreach($wishlist as $item ) {
            Cart::create([
                'user_id' => $_SESSION['auth-user'],
                'productID' => $item['productID'] ,
                'quantity' => 1
            ]);
            $this->flash->addMessage('success','تم إضافة جميع المنتجات الى السلة');
            return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('website.wishlist'));

       }
        
    }
    
    public function add($request,$response,$args) {
        $id = rtrim($args['id'], '/');
        WishList::create([
            'user_id' => $_SESSION['auth-user'],
            'productID' => $id ,
        ]);
        $this->flash->addMessage('success','تم إضافة المنتوج إلى قائمة الأمنيات بنجاح');
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('website.wishlist',['id'=>$id]));
    }
    
    
    
    public function delete($request,$response,$args) {
        $id = rtrim($args['id'], '/');
        $wish = WishList::find($id);
        $wish->delete();
        $this->flash->addMessage('success','تم ازالة المنتوج من قائمة الأمنيات بنجاح');
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('website.product',['id'=>$id]));
    }
   
    
}

