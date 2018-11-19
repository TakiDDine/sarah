<?php

namespace App\Controllers\website;

use App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Classes\files;
use \App\Models\Product;
use \App\Models\Cart;
use \App\Models\ProductCategories;

class ShopController extends \App\Controllers\Controller{
    
    public function index($request,$response) {
            $searchview     = false;
            $count          = Product::count();   
            $page           = ($request->getParam('page', 0) > 0) ? $request->getParam('page') : 1;
            $limit          = 12; 
            $lastpage       = (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit));    
            $skip           = ($page - 1) * $limit;
            $products          =  Product::skip($skip)->take($limit)->orderBy('created_at', 'desc')->get();

            
            if($request->getParam('search')){
               $search = $request->getParam('search');
               $products  = Product::orderBy('created_at', 'desc')
                    ->where('name', 'LIKE', "%$search%")
                    ->orWhere('description', 'LIKE', "%$search%")
                    ->skip($skip)
                    ->take($limit)
                    ->get();    
                $count =    Product::orderBy('created_at', 'desc')->where('name', 'LIKE', "%$search%")
                    ->orWhere('description', 'LIKE', "%$search%")->count(); 
               $lastpage       = (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit));    
               $searchview = true;
            }

            return $this->view->render($response, 'website/shop.twig', [
                'pagination'    => [
                    'needed'        => $count > $limit,
                    'count'         => $count,
                    'page'          => $page,
                    'lastpage'      => $lastpage,
                    'limit'         => $limit,
                    'prev'          => $page-1,
                    'next'          => $page+1,
                    'start'          => max(1, $page - 4),
                    'end'          => min($page + 4, $lastpage),
                ],
              'products'=>$products ,
              'searchView'=>$searchview,
              'searchQuery'=>$request->getParam('search')
            ]); 
    }
    
    public function cat($request,$response,$args){
            $slug = rtrim($args['slug'], '/');        
            $cat =  ProductCategories::where('slug', $slug )->first();
            $count          =  Product::where('categoryID',$cat->id )->count();   
            $page           = ($request->getParam('page', 0) > 0) ? $request->getParam('page') : 1;
            $limit          = 12; 
            $lastpage       = (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit));    
            $skip           = ($page - 1) * $limit;
            $products       = Product::where('categoryID',$cat->id )->skip($skip)->take($limit)->orderBy('created_at', 'desc')->get();;

            return $this->view->render($response, 'website/shop.twig', [
                'pagination'    => [
                    'needed'        => $count > $limit,
                    'count'         => $count,
                    'page'          => $page,
                    'lastpage'      => $lastpage,
                    'limit'         => $limit,
                    'prev'          => $page-1,
                    'next'          => $page+1,
                    'start'          => max(1, $page - 4),
                    'end'          => min($page + 4, $lastpage),
                ],
              'products'=>$products 
            ]); 
    }
    
     public function checkout($request,$response,$args){
         
    $cart = Cart::where('user_id',$_SESSION['auth-user'])->get()->toArray();
        foreach($cart as $item ) {
           $product = Product::where('id',$item['productID'])->first()->toArray();
                $product['productID'] = $product['id'];
                $item['cartID'] = $item['id'];

           $maincart[] =  array_merge($product,$item);
        }
                
            return $this->view->render($response, 'website/checkout.twig',['cart'=>$maincart]); 
     }
    
    
}

