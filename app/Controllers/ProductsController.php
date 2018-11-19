<?php

namespace App\Controllers;
use \App\Classes as classes;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Models\Product;
use \App\Models\ProductCategories;
use \App\Models\WishList;
use \App\Classes\files;
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductsController extends Controller{
    
    public function index($request,$response) {
            $searchview     = false;
            $count          = Product::count();   // Count of all available users      
            $page           = ($request->getParam('page', 0) > 0) ? $request->getParam('page') : 1;
            $limit          = 10; // Number of Users on one page   
            $lastpage       = (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit));    // the number of the pages
            $skip           = ($page - 1) * $limit;
            $products          =  Product::skip($skip)->take($limit)->orderBy('created_at', 'desc')->get();

            // Search Logic
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
               $lastpage       = (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit));    // the number of the pages
               $searchview = true;
            }

            return $this->view->render($response, 'admin/products/index.twig', [
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
    
    public function create($request,$response){
        
        if($request->getMethod() == 'GET'){ 
          $categories = ProductCategories::all();
          return $this->container->view->render($response,'admin/products/create.twig',['categories'=>$categories]);
        }
          
        
        if($request->getMethod() == 'POST'){ 
            
            
            if(empty($_FILES['ProductThumbnail']['name'])) {
                $this->flash->addMessage('error','الصورة الخارجة للمنتوج ضرورية ، لا يمكن تركها فارغة');
                return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('products.create'));
            }
            
            
            
            
            
            
            $files = new files();

            $title = $request->getParam('title');
            
            $description = $request->getParam('description');
            $path = $this->container->conf['dir.products'];
            
            if(is_null($description) or empty($description)){
                $description = " ";
            }

            /*
            *   رفع الصورة الخارجية
            */
            $ProductThumbnail  = '';
            if(isset($_FILES['ProductThumbnail']) and !empty($_FILES['ProductThumbnail']['name'])) {
                $ProductThumbnail =  $files->upload_avatar($path,$_FILES['ProductThumbnail']);
            } 


            /*
            *   رفع صور المنتوج
            */
            $gallery = '';
            if(isset($_FILES['ProductGallery']) and !empty($_FILES['ProductGallery'])) {
               $gallery = $files->multiple_upload($path,$_FILES['ProductGallery']);
               $gallery = implode('//',$gallery);
            }

            /*
            * اضافة المنتجات
            */
            Product::create([
                
                'name'           => $title ,
                'description'    => $description,
                'thumbnail'      => $ProductThumbnail ,
                'gallery'        => $gallery ,
                'price'          => $request->getParam('price'),
                'discount_price' => $request->getParam('discount_price'),
                'categoryID'     => $request->getParam('category'),
                'slug'           => string_To_Uri($request->getParam('slug'))
            ]);

            $this->flash->addMessage('success','تم اضافة المنتوج بنجاح');
            return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('products'));
        }
    }
    
    public function edit($request,$response,$args){
        $product = Product::find(rtrim($args['id'], '/'));
         $categories = ProductCategories::all();
        if($request->getMethod() == 'POST'){
            
            
            
            
            // check if the image is edited.
            if($request->getParam('isAdChanged') == 'true') {
                $ad = " ";
                
                /*
                * رفع الصورة الجديدة عندما يتم 
                */
                if(isset($_FILES['ProductThumbnail']) and !empty($_FILES['ProductThumbnail']['name'])) {

                    $files = new files();
                    $path = $this->container->conf['dir.products'];
                    $file = $_FILES['ProductThumbnail'];

                    // Upload
                    $thumbnail =  $files->upload_avatar($path,$file);
                }  
                
                // Delete the old one
                unlink($this->container->conf['dir.products'].$product->thumbnail);
                $product->thumbnail = $thumbnail;
            }
            
            
           
            $product->slug = $request->getParam('slug'); 
            $product->name = $request->getParam('title'); 
            $product->description = $request->getParam('description');
            $product->price = $request->getParam('price');
            $product->discount_price = $request->getParam('discount_price');
            $product->categoryID = $request->getParam('category');
            $product->save();
            
        return $response->withRedirect($this->router->pathFor('products.edit', ['id'=> $product->id , 'product'=>$product,'categories'=>$categories]));
            
        }
        
        
        
        return $this->container->view->render($response,'admin/products/show.twig',['product'=>$product,'categories'=>$categories]);
    }

    public function delete($request,$response,$args) {
        
        
        /*
        *       Get the Product
        */
        $product = Product::find(rtrim($args['id'], '/'));
        
        /*
        *       Delete Thumbnail image
        */
        unlink($this->container->conf['dir.products'].$product->thumbnail);
        
        /*
        *       Delete Gallery images
        */
        $gallery = explode('//',$product->gallery);
        foreach($gallery as $image):
            unlink($this->container->conf['dir.products'].$image);
        endforeach;
        
        /*
        * Delete the Product
        */
        $product->delete();
        $this->flash->addMessage('success','تم حذف المنتوج بنجاح');
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('products'));
    }
    
    public function duplicate($request,$response,$args) {
        $product = Product::find(rtrim($args['id'], '/'));
        $new = $product->replicate();
        $new->slug = $product->slug.rand(10,100);
        $new->save();
        $this->flash->addMessage('success','تم تكرار المنتوج بنجاح');
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('products'));
    }
    
    public function blukdelete($request,$response){
        $users = Product::truncate();
        $this->flash->addMessage('success', 'تم حذف كل المنتجات بنجاح');
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('products'));
    }
    
}
 