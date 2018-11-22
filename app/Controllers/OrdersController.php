<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Classes\files;
use \App\Models\Order;
use \App\Models\Cart;
use \App\Models\Product;


defined('BASEPATH') OR exit('No direct script access allowed');

class OrdersController extends Controller {
    
    public function index($request,$response){

                $searchview     = false;
                $count          = Order::count();   
                $page           = ($request->getParam('page', 0) > 0) ? $request->getParam('page') : 1;
                $limit          = 10; 
                $lastpage       = (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit));    // the number of the pages
                $skip           = ($page - 1) * $limit;
                $orders         = Order::skip($skip)->take($limit)->orderBy('created_at', 'desc')->get();

                return $this->view->render($response, 'admin/orders/index.twig', [
                        'pagination'    => [
                        'needed'        => $count > $limit,
                        'count'         => $count,
                        'page'          => $page,
                        'lastpage'      => $lastpage,
                        'limit'         => $limit,
                        'prev'          => $page-1,
                        'next'          => $page+1,
                        'start'         => max(1, $page - 4),
                        'end'           => min($page + 4, $lastpage),
                    ],
                  'orders'=> $orders ,
                ]);
    }  
 
 
     public function create($request,$response)  {
         
         if(isset($_SESSION['auth-user'])){
            // Get the products he want to buy , so wer are getting the cart of course !
            $cart = Cart::where('user_id',$_SESSION['auth-user']);  
         }
         
         if(isset($cart) and !empty($cart)){

             // total = all (products price * quanity )
             $total = [];
             foreach($cart->get() as $item ) {
                $product = Product::where('id',$item->productID)->first();
                $total[] = $product->price  * $item->quantity;
             }
             $total = array_sum($total);
             
             
            // Payement Logic
             
            // make the payement;
             
            // if the payement is correct , redirect to order info page
            
            // if the payement is incomplete , return to order page with the error given


            // insert to database
            $order =  Order::create([
                     'first_name'   => clean($request->getParam('first_name')),
                     'last_name'    => clean($request->getParam('last_name')),
                     'email'        => clean($request->getParam('Email')),
                     'company'      => clean($request->getParam('company_name')),
                     'country'      => clean($request->getParam('country')),
                     'postalCode'   => clean($request->getParam('Postcode')),
                     'state'        => clean($request->getParam('State')),
                     'city'         => clean($request->getParam('City')),
                     'phone'        => clean($request->getParam('Phone')),
                     'adressLine1'  => clean($request->getParam('adressLine1')),
                     'adressLine2'  => clean($request->getParam('adressLine2')),
                     'total'        => $total,
                     'notes'        => $request->getParam('notes'),
                     'statue'       => 1
                ]);

             // ADD the products to orders Table
             foreach($cart as $item ) {
                 $this->db->table('orderproducts')->insert([
                     'order_id' => $order->id , 
                     'quantity' => $item->quantity,
                     'productID' => $item->productID
                 ]);  
             }

            // Empty the cart of the user after order 
            $cart->delete();

            $this->flash->addMessage('success','شكراً ، تم تلقي الطلب بنجاح ');
            return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('website.home'));
             
        }
         
        // if the cart is empty
        $this->flash->addMessage('error','please add products to your cart to make the order');
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('website.checkout'));
    
    }
    
    public function edit($request,$response,$args) {
        $id = rtrim($args['id'], '/');
        $order = Order::find($id);
        
        $products = $this->db->table('orderproducts')->where('order_id',$id)->get();
        
        if($request->getMethod() == 'GET'){
            return $this->view->render($response, 'admin/orders/edit.twig',['order'=>$order,'products'=>$products]);
        }
    
    }
    
    public function delete($request,$response,$args) {
        $id = rtrim($args['id'], '/');
        $order = Order::find($id);
        $order->delete();
        $this->flash->addMessage('success','تم حذف الطلب بنجاح');
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('orders'));
    } 
    
     public function blukdelete($request,$response){
        Order::truncate();
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('orders'));
    }
    
    
    
    
    
}