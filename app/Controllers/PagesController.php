<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Models\Page;
use \App\Classes\files;

defined('BASEPATH') OR exit('No direct script access allowed');

class PagesController extends Controller {
    
       public function index($request,$response) {
                $searchview     = false;
                $count          = Page::count();   
                $page           = ($request->getParam('page', 0) > 0) ? $request->getParam('page') : 1;
                $limit          = 10; 
                $lastpage       = (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit));    
                $skip           = ($page - 1) * $limit;
                $posts          = Page::skip($skip)->take($limit)->orderBy('created_at', 'desc')->get();

                return $this->view->render($response, 'admin/pages/index.twig', [
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
     public function edit($request,$response,$args) {
        $id = rtrim($args['id'], '/');
        $post = Page::find($id);
        if($request->getMethod() == 'GET'){       
            if($post){
                return $this->view->render($response,'admin/pages/edit.twig',compact('post','categories'));
            }
            return $response->withRedirect($this->router->pathFor('pages'));        
        }
        
        if($request->getMethod() == 'POST'){

                // initialize the helper & the uploader clean post form
                $helper   = $this->helper;
                $form     = $helper->cleanData($request->getParams());
                $up       = $this->files;
                $file     = $_FILES['post_thumbnail'];
                $dir      = $this->dir('pages');
            
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
                return $response->withRedirect($this->router->pathFor('pages.edit',['id'=>$id]));   
        }
        
        
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
                Page::create([
                    'title' => $post['title'] ,
                    'content'  => $post['post_content'],
                    'thumbnail' => $thumbnail,
                    'author' => $_SESSION['auth-admin'],
                    'statue' => '1',
                    'type' => 'post',
                    'categoryID' => $post['postCategory']
                ]);

                // flash success & redirect
                $this->flashsuccess('تم اضافة الصفحة بنجاح');
                return $response->withRedirect($this->router->pathFor('posts'));        
          }

          return $this->view->render($response,'admin/pages/create.twig'); 
    }
    
    public function delete($request,$response,$args) {
        $page = Page::find(rtrim($args['id'], '/'));
        unlink($this->dir('pages').$page->thumbnail);
        $Post->delete();
        $this->flashsuccess('تم حذف الصفحة بنجاح');
        return $response->withHeader('Location', $this->router->urlFor('pages'));
    }
    
    public function duplicate($request,$response,$args) {
        $product = Page::find(rtrim($args['id'], '/'));
        $new = $product->replicate();
        $new->save();
        $this->flashsuccess('تم تكرار الصفحة بنجاح');
        return $response->withHeader('Location', $this->router->urlFor('pages'));
    }  
    
    public function blukdelete($request,$response){
        $users = Page::truncate();
        $this->delete_folders_files($this->dir('pages'));
        $this->flashsuccess('تم حذف كل الصفحات بنجاح');
        return $response->withHeader('Location', $this->router->urlFor('pages'));
    }
    
    
    /*
    *   Taking Action For selected Rows in the Table
    *   version 1.0 , Action that exist now is Delete 
    */
    public function mutliAction($request,$response){
    
        // Get All selected Pages
        $selected =  Page::whereIn('id', array_values($request->getParam('checkaction')));

        // Take the Correct Action
        if($request->getParam('takeAction') == 'delete'){ $selected->delete(); }

        // Redirect To Pages
        $this->flashsuccess('تم تنفيذ الأمر بنجاح');
        return $response->withHeader('Location', $this->router->urlFor('pages'));
    }
     
   
}