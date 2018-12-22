<?php

namespace App\Controllers\website;

use App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Classes\files;
use \App\Models\Emails;
use \App\Models\Product;
use \App\Models\WishList;
use \App\Models\Reviews;
use \App\Models\Cart;



class ProductController extends \App\Controllers\Controller{
    public function index($request,$response,$args) {
        
        $id = rtrim($args['id'], '/');
        $product = Product::find($id);
        $reviews = Reviews::where('ProductID',$product->id)->get();
        $related = Product::where('categoryID', $product->categoryID)->get();
        $wishlist = WishList::where('productID', $product->id)->where('user_id', $_SESSION['auth-user'])->first();
        
        
        st($product);
         
        /* 
         من أجل اظهار فورم التقييم
         1 - التأكد من أن المستخدم قام بشراء المنتوج
         *2 - التأكد من أنه لا يوجد تقييم
         */

                
        $not_commented = false;
         $paid = false;
        if($not_commented == false and $paid == false){
           $allowRating = true; 
        }
     
       $cartlist = Cart::where('productID', $product->id)->where('user_id', $_SESSION['auth-user'])->first();

        if($wishlist){
            $wish = true;
        }else {
            $wish = false;
        }
      
        if($cartlist){
            $incart = $cartlist->id;
        }else {
            $incart = false;
        }
   

       return $this->container->view->render($response,'website/product.twig',
                 [
                  'product'=>$product,
                  'related'=>$related,
                  'wish'=>$wish,
                  'incart'=>$incart,
                  'allowRating' => $allowRating,
                  'reviews' => $reviews
                 ]
      );
    }
    
    
    
        
    public function rate ($request,$response,$args) {
        
        // Secure Me please
        $product_id     = clean($request->getParam('product_id'));
        $user_id        = $_SESSION['auth-user'];
        $review         = clean($request->getParam('review'));
        $title          = clean($request->getParam('title'));
        $rating         = clean($request->getParam('rating'));
        
        
        // check if there is no rating first of all.
        $already = Reviews::where('productID', $product_id)->where('user_id',$user_id)->first();
        
        if(!$already){
                // Creating the Review
                Reviews::create([
                    'productID' => $product_id,
                    'rating' => 4,
                    'title' => $title,
                    'review' => $review,
                    'user_id' => $user_id
                ]);
        }
        
        // Redirect To The Product 
        $this->flash->addMessage('success', 'thank you for rating');
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('website.product',['id'=>$product_id])); 
    }
  
}

