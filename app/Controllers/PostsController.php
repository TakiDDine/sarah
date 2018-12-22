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
           
           
           
//                   st($posts,1);

           // get the posts, get the posts categories , get the posts authors
           
//           $posts = Post::leftJoin('postscategories','postscategories.id','posts.categoryID')
//                ->leftJoin('users','users.id','=','posts.author')
//               ->select('posts.*','postscategories.name as category','users.username')->skip($skip)->take($limit)->orderBy('created_at', 'desc')->get();
               
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

            if($request->getMethod() == 'POST'){

                // initialize the helper & the uploader clean post form
                $helper   = $this->helper;
                $post = $helper->cleanData($request->getParams());
                $up = $this->files;

                // upload the post thumbnail
                $file = $_FILES['post_thumbnail'];
                $thumbnail = !empty($file['name']) ? $up->up($this->dir('posts'),$file) : " ";

                // create the post
                Post::create([
                    'title' => $post['title'] ,
                    'content'  => $post['post_content'],
                    'thumbnail' => $thumbnail,
                    'author' => $_SESSION['auth-admin'],
                    'statue' => '1',
                    'type' => 'post',
                    'categoryID' => $post['postCategory']
                ]);

                // flash success & redirect
                $this->flashsuccess('تم اضافة المقالة بنجاح');
                return $response->withRedirect($this->router->pathFor('posts'));        
          }

          $categories = PostsCategories::all();
          return $this->container->view->render($response,'admin/posts/create.twig',compact('categories')); 
    }
    
    
    
    public function edit($request,$response,$args) {
        $categories = PostsCategories::all();
        $id = rtrim($args['id'], '/');
        $post = Post::find($id);

        
//        $post =Post::findOrFail($id);
//        
//        st($post,1);
//        
        
        if($request->getMethod() == 'GET'){       
            if($post){
                return $this->view->render($response,'admin/posts/edit.twig',compact('post','categories'));
            }
            return $response->withRedirect($this->router->pathFor('posts'));        
        }
        
        if($request->getMethod() == 'POST'){

                // initialize the helper & the uploader clean post form
                $helper   = $this->helper;
                $form     = $helper->cleanData($request->getParams());
                $up       = $this->files;
                $file     = $_FILES['post_thumbnail'];
                $dir      = $this->dir('posts');
            
                if($form['thumbnailChanged'] == 'true') {
                    // Upload
                    $Post->thumbnail = !empty($file['name']) ? $up->up($dir,$file) : ' ';

                    // delete the old thumbnail 
                    $old = $dir.$post->thumbnail; if(file_exists($old)){unlink($old);}
                }        

            
                // edit the post & save
                $post->title                = $form['title'];
                $post->content              = $form['post_content'];
                $post->statue               = '1';
                $post->slug                 = $form['slug'];
                $post->categoryID           = $form['postCategory'];
                $post->save();

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

    // Duplicate the post
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

