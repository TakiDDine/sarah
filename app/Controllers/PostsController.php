<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Models\Post;
use \App\Models\PostsCategories;
use \App\Classes\files;

defined('BASEPATH') OR exit('No direct script access allowed');

class PostsController extends Controller {
    
    
       public function index($request,$response) {
                $searchview     = false;
                $count          = Post::count();   
                $page           = ($request->getParam('page', 0) > 0) ? $request->getParam('page') : 1;
                $limit          = 10; 
                $lastpage       = (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit));    
                $skip           = ($page - 1) * $limit;
                $posts          = Post::skip($skip)->take($limit)->orderBy('created_at', 'desc')->get();

                return $this->view->render($response, 'admin/posts/index.twig', [
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
                  'posts'=>$posts ,
                  'searchView'=>$searchview,
                  'searchQuery'=>$request->getParam('search')
                ]);
        }
    
    
        public function create($request,$response) {

            if($request->getMethod() == 'GET'){
                $categories = PostsCategories::all();
                return $this->container->view->render($response,'admin/posts/create.twig',['categories'=>$categories]);
            }
            
            if($request->getMethod() == 'POST'){
                
                // initialize the helper & the uploader clean post form
                $helper   = $this->helper;
                $post     = $request->getParams();
                $uploader = $this->files;
                
                $title        = $helper->clean($post['title']);
                $post_content = $helper->clean($post['post_content']);
                $categories   = $helper->clean($post['postCategory']);
                
                
                $post_thumbnail = " ";
                
                // upload the post thumbnail
                $file = $_FILES['post_thumbnail'];
                if(isset($file) and !empty($file['name'])) {

                 // upload the thumbnail
                 $post_thumbnail =  $uploader->upload_avatar($this->dir('posts'),$file);

                }  
                
                // create the post
                Post::create([
                    'title' => $title,
                    'content'  => $post_content,
                    'thumbnail' => $post_thumbnail,
                    'author' => $_SESSION['auth-admin'],
                    'statue' => '1',
                    'type' => 'post',
                    'categoryID' => $categories
                ]);
                
                // flash success & redirect
                $this->flashsuccess('تم اضافة المقالة بنجاح');
                return $response->withRedirect($this->router->pathFor('posts'));        
          }
        
    }
    
    
    
    public function edit($request,$response,$args) {
        $categories = PostsCategories::all();
        $id = rtrim($args['id'], '/');
        $Post = Post::find($id);
        
        if($request->getMethod() == 'GET'){       
            if($Post){
                return $this->container->view->render($response,'admin/posts/edit.twig',['post'=>$Post,'categories'=>$categories]);
            }
            return $response->withRedirect($this->router->pathFor('posts'));        
        }
        
        if($request->getMethod() == 'POST'){
           
            
            // initialize the helper & the uploader clean post form
            $helper   = $this->helper;
            $form     = $request->getParams();
            $uploader = $this->files;
            
            // get & clean the content
            $title = $helper->clean($form['title']);
            $content = $helper->clean($form['post_content']);
            $slug = $helper->clean($form['slug']); 
            $categories   = $helper->clean($form['postCategory']);
            
            
           if($post['thumbnailChanged'] == 'true') {
              
                $thumbnail = " ";
                // get the thumbnail
                $file = $_FILES['post_thumbnail'];
               
                // Upload
                if(isset($file) and !empty($file['name'])) { $thumbnail =  $uploader->upload_avatar($this->dir('posts'),$file);}  
                
                // delete the old thumbnail 
                $old = $this->dir('posts').$Post->thumbnail;
                if(file_exists($old)){unlink($old);}
                
                // change the post thumbnail to the new one
                $Post->thumbnail = $thumbnail;
  
            }        
            
            // edit the post & save
            $Post->title                = $title;
            $Post->content              = $content;
            $Post->statue               = '1';
            $Post->slug                 = $slug;
            $Post->categoryID           = $categories;
            $Post->save();
            
            // flash success & redirect
            $this->flashsuccess( 'تم تعديل المقالة بنجاح');
            return $response->withRedirect($this->router->pathFor('posts.edit',['id'=>$id]));   
            
        }
        
        
    }
    
    public function delete($request,$response,$args) {
        
        // get the id & the post
        $id = rtrim($args['id'], '/');
        $Post = Post::find($id);
        
        //  get the thumbnail
        $thumbnail = $this->dir('posts').$Post->thumbnail;
        
        // if the thumbnail exist delete it
        if(file_exists($thumbnail)){unlink($thumbnail);}
        
        // if the post exist delete it & flash success
        if($Post){$Post->delete(); $this->flashsuccess('تم حذف المقالة بنجاح'); }
        
        return $response->withRedirect($this->router->pathFor('posts'));  
    }
    
    
    
    
    // Dupli
    public function duplicate($request,$response,$args) {
        
        // get the id
        $id = rtrim($args['id'], '/');
        
        // get the post
        $post = Post::find($id);
        
        // if the post exist Duplicate & flash success
        if($post){$new = $product->replicate();$new->save(); $this->flashsuccess('تم تكرار المقالة بنجاح');}
        
        // redirect  
        return $response->withRedirect($this->router->pathFor('posts'));  
    }
   
    public function blukdelete($request,$response){
        Post::truncate();
        // delete post thumbnails
        $this->helper->delete_folders_files($this->dir('posts'));
        return $response->withRedirect($this->router->pathFor('posts'));  
    }   
    
    
    /*
    *   Taking Action For selected Rows in the Table
    *   version 1.0 , Action that exist now is Delete 
    */
    public function mutliAction($request,$response){
    
        // Get All selected Pages
        $selected =  Post::whereIn('id', array_values($request->getParam('checkaction')));

        // Take the Correct Action
        if($request->getParam('takeAction') == 'delete'){ $selected->delete();  }

        // Redirect To Pages
        $this->flashsuccess( 'تم تنفيذ الأمر بنجاح');
        return $response->withRedirect($this->router->pathFor('posts'));  
    
    }
    
}

