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
                $lastpage       = (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit));   
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
         
         // Paypal info.
         $client_id = $this->container->conf['app.sandbox_cliend_id'];
         $secret_id = $this->container->conf['app.sandbox_secret_id'];
             
         // initialize the helper & post Form
         $helper = $this->helper;
         $post   = $request->getParams();
         
         
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
//             $payment = new \PayPal\Api\Payment();
             
             
             
            // make the payement;
             
            // if the payement is correct , redirect to order info page
            
            // if the payement is incomplete , return to order page with the error given
            $payament = 0;
             
             
            $first_name   = $helper->clean($post['first_name']);
            $last_name    = $helper->clean($post['last_name']);
            $email        = $helper->clean($post['Email']);
            $company      = $helper->clean($post['company_name']);
            $country      = $helper->clean($post['country']);
            $postalCode   = $helper->clean($post['Postcode']);
            $state        = $helper->clean($post['State']);
            $city         = $helper->clean($post['City']);
            $phone        = $helper->clean($post['Phone']);
            $adressLine1  = $helper->clean($post['adressLine1']);
            $adressLine2  = $helper->clean($post['adressLine2']);
            $notes        = $helper->clean($post['notes']);
             
             // Check if the informations are not empty
             if(
                 empty($first_name) 
                 or empty($last_name) 
                 or empty($email) 
                 or empty($country) 
                 or empty($phone) 
                 or empty($adressLine1) 
                 or empty($city)
               ) {
                 
                // the Imporant Fields are empty
                $this->flash->addMessage('error','Please Fill All the required Fileds');
                return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('website.checkout'));
             }
             
             
            
             
             
             
             
            if($payament == 1 )  {
                 
                // insert to database
                $order =  Order::create([
                         'first_name'   => $first_name,
                         'last_name'    => $last_name,
                         'email'        => $email,
                         'company'      => $company,
                         'country'      => $country,
                         'postalCode'   => $postalCode,
                         'state'        => $state,
                         'city'         => $city,
                         'phone'        => $phone,
                         'adressLine1'  => $adressLine1,
                         'adressLine2'  => $adressLine2,
                         'total'        => $total,
                         'notes'        => $notes,
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

                $this->flashsuccess('شكراً ، تم تلقي الطلب بنجاح ');
                return $response->withRedirect($this->router->pathFor('website.home'));
           }
             
             
             
        }
         
        // if the cart is empty
        $this->flasherror('please add products to your cart to make the order');
        return $response->withRedirect($this->router->pathFor('website.checkout'));
        
    
    }
    

    public function edit($request,$response,$args) {
        $id = rtrim($args['id'], '/');
        $order = Order::find($id);
        
        $products = $this->db->table('orderproducts')->where('order_id',$id)->get();
        
        if($request->getMethod() == 'GET'){
            return $this->view->render($response, 'admin/orders/edit.twig',['order'=>$order,'products'=>$products]);
        }
    
    }
    
    
    // delete the order 
    public function delete($request,$response,$args) {
        
        // get the id
        $id = rtrim($args['id'], '/');
        
        // get the order
        $order = Order::find($id);
        
        // delete & flush success & redirect
        if($order){  $order->delete(); $this->flashsuccess('تم حذف الطلب بنجاح'); }
        return $response->withRedirect($this->router->pathFor('orders'));
    } 
    
    // delete all the orders & redirect to orders page
    public function blukdelete($request,$response){
        Order::truncate();
        return $response->withRedirect($this->router->pathFor('orders'));
    }
    
    
    
    
    
}