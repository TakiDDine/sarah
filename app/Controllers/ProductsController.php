<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Models\Product ;
use \App\Models\ProductCategories;
use \App\Classes\files;
use JasonGrimes\Paginator;

defined('BASEPATH') OR exit('No direct script access allowed');

class ProductsController extends Controller{
    
    
    // index Page
    public function index($request,$response) {
        $r = $this->paginate('Product',$request);
        return $this->view->render($response, 'admin/products/index.twig', ['products'=>$r[0],'p'=>$r[1]]);    
    }
    
    public function create($request,$response){
        
        if($request->getMethod() == 'GET'){ 
          $categories = ProductCategories::all();
          return $this->view->render($response,'admin/products/create.twig',compact('categories'));
        }
          
        
        if($request->getMethod() == 'POST'){ 
            
            // Get the Form data & initialize the fileUploader & helper
            $up     = $this->files;
            $helper = $this->helper;
            $post   = $helper->cleanData($request->getParams());
            $path   = $this->dir('products');
            $thumb  = $_FILES['ProductThumbnail'];
            $galle  = $_FILES['ProductGallery'];
            
            // creating the description
            $description = !empty($post['description']) ? $post['description'] : ' ';
            
            // upload the thumbnail
            $thumbnail = !empty($thumb['name']) ? $up->up($path,$thumb) : ' ';

            // upload the gallery
            $gallery = !empty($galle) ? implode('//',$up->multiple_upload($path,$galle)) : ' ';

            
            // adding the product
            Product::create([
                'name'           => $post['title'] ,
                'description'    => $description,
                'thumbnail'      => $thumbnail ,
                'gallery'        => $gallery ,
                'price'          => $post['price'],
                'discount_price' => $post['discount_price'],
                'categoryID'     => $post['category'],
                'slug'           => $helper->string_To_Uri($post['slug'])
            ]);
            
            // success & redirect
            $this->flashsuccess('تم اضافة المنتوج بنجاح');
            return $response->withRedirect($this->router->pathFor('products'));
        }
    }
    

    public function edit($request,$response,$args){
        
            // get the product id
            $id = rtrim($args['id'], '/');

            // get the product
            $product = Product::find($id);

            // get the products categories
            $categories = ProductCategories::all();

            // show the edit page 
            if($request->getMethod() == 'GET'){ 
                
              return $this->view->render($response,'admin/products/edit.twig',['product'=>$product,'categories'=>$categories]);
            }
        
        
        if($request->getMethod() == 'POST'){
            
            $post       = $request->getParams();
            $helper     = $this->helper;
            $uploder    = new files();
            $path       = $this->container->conf['dir.products'];
            $thumbnail  = $_FILES['ProductThumbnail'];
            
            // Clean the Variables
            $title              = $helper->clean($post['title']);
            $description        = $helper->clean($post['description']);
            $price              = $helper->clean($post['price']);
            $category           = $helper->clean($post['category']);
            $discount_price     = $helper->clean($post['discount_price']);
            $slug               = $helper->string_To_Uri($helper->clean($post['slug']));
            
            
            // check if the image is edited.
            if($post['isAdChanged'] == 'true') {
                $ad = " ";
                
                // upload thumbnail
                if(isset($thumbnail) and !empty($thumbnail['name'])) { $thumbnail =  $uploder->file_upload($path,$thumbnail); }  
                
                // Delete the old one
                unlink($path.$product->thumbnail);
                $product->thumbnail = $thumbnail;
            }
            
            // change the info & save
            $product->slug =  $slug; 
            $product->name = $title; 
            $product->description = $description;
            $product->price = $price;
            $product->discount_price = $discount_price;
            $product->categoryID = $category;
            $product->save();
            
            // success & redirect
            return $response->withRedirect($this->router->pathFor('products.edit',[
                'id'=> $id ,
                'product'=>$product,
                'categories'=>$categories
            ]));
            
        }
        
        
        
    }

    public function delete($request,$response,$args) {
        
        // get the product id
        $id = rtrim($args['id'], '/');
        
        $path = $this->container->conf['dir.products'];
        
        // Get the Product
        $product = Product::find($id);
        
        
        if($product){
            
            // Delete Thumbnail image
            $thumbnail = $path.$product->thumbnail;
            if(file_exists($thumbnail)){
                unlink($thumbnail);
            }
            
            // Delete Gallery images
            $gallery = explode('//',$product->gallery);
            foreach($gallery as $image):
                unlink($path.$image);
            endforeach;
            
            // Delete the Product
            $product->delete();
            $this->flashsuccess('تم حذف المنتوج بنجاح');
            
        }
        
        return $response->withRedirect($this->router->pathFor('products'));
        
    }
    
    
    
    public function duplicate($request,$response,$args) {
        
        // get the product id
        $id = rtrim($args['id'], '/');
        
        // Get the Product
        $product = Product::find($id);
        
        if($product) {
        
            // duplicate , generate new slug & save
            $new = $product->replicate();
            $new->slug = $product->slug.rand(10,100);
            $new->save();

            // success message
            $this->flashsuccess('تم تكرار المنتوج بنجاح');
            
        }
        
        return $response->withRedirect($this->router->pathFor('products'));
    }
    
    
    public function blukdelete($request,$response){
        
        // delete all data of products 
        $users = Product::truncate();
        
        // delete all images of products
        $this->helper->delete_folders_files($this->container->conf['dir.products']);
        
        // success & redirect
        return $response->withRedirect($this->router->pathFor('products'));
        
    }
    
    
    
}
 