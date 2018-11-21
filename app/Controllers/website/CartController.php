<?php

namespace App\Controllers\website;

use App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Classes\files;
use \App\Models\Emails;
use \App\Models\Product;
use \App\Models\Cart;


class CartController extends \App\Controllers\Controller{
    
    
    public function index($request,$response) {
        
       $maincart = [];
       if(isset($_SESSION['auth-user'])){
       $cart = Cart::where('user_id',$_SESSION['auth-user'])->get()->toArray();
            foreach($cart as $item ) {
               $product = Product::where('id',$item['productID'])->first()->toArray();
                    $product['productID'] = $product['id'];
                    $item['cartID'] = $item['id'];

               $maincart[] =  array_merge($product,$item);
            }
       }
       return $this->container->view->render($response,'website/cart.twig',['cart'=>$maincart]);
    }
 
    
    public function add($request,$response,$args) {
        $id = rtrim($args['id'], '/');
        Cart::create([
            'user_id' => $_SESSION['auth-user'],
            'productID' => $id ,
            'quantity' => clean($request->getParam('quantity'))
        ]);
        $this->flash->addMessage('success_cart','');
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('website.product',['id'=>$id]));
    }
    
  
    
    public function delete($request,$response,$args) {
        $id = rtrim($args['id'], '/');
        if(is_numeric($id)){
            $Cart = Cart::find($id);
            if($Cart) {
                $Cart->delete();
                $this->flash->addMessage('success','تم ازالة المنتوج من السلة بنجاح');
                return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('website.cart'));
            }
        }
    }
    
    
    
    
    
}