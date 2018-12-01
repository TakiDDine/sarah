<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Models\Product;
use \App\Models\ProductCategories;
use \App\Classes\files;


defined('BASEPATH') OR exit('No direct script access allowed');

class ProductsController extends Controller{
    
    
    public function index($request,$response) {
            $searchview     = false;
            $count          = Product::count();         
            $page           = ($request->getParam('page', 0) > 0) ? $request->getParam('page') : 1;
            $limit          = 10; 
            $lastpage       = (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit));   
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
                $count = count($products);
               $lastpage       = (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit)); 
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
            
            // Get the Form data & initialize the fileUploader & helper
            $post   = $request->getParams();
            $files  = new files();
            $helper = $this->helper;
            $path = $this->container->conf['dir.products'];
            
            // Clean the Variables
            $title              = $helper->clean($post['title']);
            $description        = $helper->clean($post['description']);
            $price              = $helper->clean($post['price']);
            $category           = $helper->clean($post['category']);
            $discount_price     = $helper->clean($post['discount_price']);
            $slug               = $helper->string_To_Uri($helper->clean($post['slug']));
            
            // check if the thumnail is empty
            if(empty($_FILES['ProductThumbnail']['name'])) {
                $this->flasherror('الصورة الخارجة للمنتوج ضرورية ، لا يمكن تركها فارغة');
                return $response->withRedirect($this->router->pathFor('products.create'));
            }
            
            if(is_null($description) or empty($description)){
                $description = " ";
            }

            // upload the thumbnail
            $ProductThumbnail  = '';
            if(isset($_FILES['ProductThumbnail']) and !empty($_FILES['ProductThumbnail']['name'])) {
                $ProductThumbnail =  $files->upload_avatar($path,$_FILES['ProductThumbnail']);
            } 

            // upload product Gallery
            $gallery = '';
            if(isset($_FILES['ProductGallery']) and !empty($_FILES['ProductGallery'])) {
               $gallery = $files->multiple_upload($path,$_FILES['ProductGallery']);
               $gallery = implode('//',$gallery);
            }

            // adding the product
            Product::create([
                'name'           => $title ,
                'description'    => $description,
                'thumbnail'      => $ProductThumbnail ,
                'gallery'        => $gallery ,
                'price'          => $price,
                'discount_price' => $discount_price,
                'categoryID'     => $category,
                'slug'           => $slug
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
              return $this->container->view->render($response,'admin/products/edit.twig',['product'=>$product,'categories'=>$categories]);
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
 