<?php

namespace App\Controllers\website;

use App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Classes\files;
use \App\Models\Ads;
use \App\Models\Menus;
use \App\Models\Slider;
use \App\Models\Product;
use \App\Models\options;
use \App\Models\ProductCategories;
use \App\Models\Cart;
use \App\Controllers\Controller as base;

class HomeController extends base{
    public function index($request,$response) {
       $ads = ads::All();
       $menus = Menus::All();
       $slider = Slider::All();
       $options =  new options();
        
        $maincart = [];
    if(isset($_SESSION['auth-user'])){   
            $cart = Cart::where('user_id',$_SESSION['auth-user'])->get()->toArray();
      
        
        $maincart = [];
        foreach($cart as $item ) {
           $product = Product::where('id',$item['productID'])->first();
            if($product) {
                $product = $product->toArray();
                $product['productID'] = $product['id'];
                $item['cartID'] = $item['id'];
                $maincart[] =  array_merge($product,$item);
            }
        }
    }
        
        
$BLOCK_CAT_1 = Product::where('categoryID','=', $options->get_option('BLOCK_CAT_1') )->get();
$BLOCK_CAT_2 = Product::where('categoryID','=', $options->get_option('BLOCK_CAT_2') )->get();
$BLOCK_CAT_3 = Product::where('categoryID','=', $options->get_option('BLOCK_CAT_3') )->get();
$BLOCK_CAT_4 = Product::where('categoryID','=', $options->get_option('BLOCK_CAT_4') )->get();
$BLOCK_CAT_5 = Product::where('categoryID','=', $options->get_option('BLOCK_CAT_5') )->get();
$BLOCK_CAT_6 = Product::where('categoryID','=', $options->get_option('BLOCK_CAT_6') )->get();
                
        
        
       $products = Product::All();

       $categories = ProductCategories::all();
       return $this->container->view->render($response,'website/index.twig',
                                             [
                                                'ads'=>$ads,
                                              'categories'=>$categories,
                                              'menus'=>$menus,
                                              'slider'=>$slider,
                                              'products'=>$products,
                                                'BLOCK_CAT_1' => $BLOCK_CAT_1,
                                                'BLOCK_CAT_2' => $BLOCK_CAT_2,
                                                'BLOCK_CAT_3' => $BLOCK_CAT_3,
                                                'BLOCK_CAT_4' => $BLOCK_CAT_4,
                                                'BLOCK_CAT_5' => $BLOCK_CAT_5,'cart'=>$maincart,
                                                'BLOCK_CAT_6' => $BLOCK_CAT_6
//                                                'cartcount' => count()
       ]
                                            );
        
        
        
    }
    
  
    
}

