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
 
    

    public function create($request,$response) {

            if($request->getMethod() == 'GET'){
                return $this->container->view->render($response,'admin/pages/create.twig');
            }
            
            if($request->getMethod() == 'POST'){
        
                $title = $request->getParam('title');
                $post_content = $request->getParam('post_content');

                $post_thumbnail = " ";
                
                
                  if(isset($_FILES['post_thumbnail']) and !empty($_FILES['post_thumbnail']['name'])) {
                            $files = new files();
                            $path = $this->container->conf['dir.pages'];
                            $file = $_FILES['post_thumbnail'];
                            $post_thumbnail =  $files->upload_avatar($path,$file);
                   }  
                

                Page::create([
                    'title' => $title,
                    'content'  => $post_content,
                    'thumbnail' => $post_thumbnail,
                    'author' => $_SESSION['auth-admin'],
                    'statue' => '1',
                    'type' => 'post',
                    'categoryID' => $request->getParam('postCategory')
                ]);
                
                $this->flash->addMessage('success','تم اضافة المقالة بنجاح');
                return $response->withRedirect($this->router->pathFor('pages'));        
          }
        
    }
    
 public function edit($request,$response,$args) {
        $id = rtrim($args['id'], '/');
        $Post = Page::find($id);
        $files = new files();
      
        
        if($request->getMethod() == 'GET'){       
            return $this->container->view->render($response,'admin/pages/edit.twig',['post'=>$Post]);
        }
        
        if($request->getMethod() == 'POST'){
           
           if($request->getParam('thumbnailChanged') == 'true') {
              
                $thumbnail = " ";
                if(isset($_FILES['post_thumbnail']) and !empty($_FILES['post_thumbnail']['name'])) {
                    
                    // Upload
                    $thumbnail =  $files->upload_avatar($this->container->conf['dir.pages'],$_FILES['post_thumbnail']);
                }  
                
                unlink($this->container->conf['dir.pages'].$Post->thumbnail);
                $Post->thumbnail = $thumbnail;
  
            }        
            
            $Post->title                = $request->getParam('title');
            $Post->content              = $request->getParam('post_content');
            $Post->statue               = '1';
            $Post->slug                 = $request->getParam('slug');
            $Post->categoryID           = $request->getParam('postCategory');
            $Post->save();
            
            $this->flash->addMessage('success', 'تم تعديل المقالة بنجاح');
            return $response->withRedirect($this->container->router->pathFor('pages.edit',['id'=>$id]));   
            
        }
        
        
    }
    
    
    public function delete($request,$response,$args) {
        $Post = Page::find(rtrim($args['id'], '/'));
        unlink($this->container->conf['dir.pages'].$Post->thumbnail);
        $Post->delete();
        $this->flash->addMessage('success','تم حذف المقالة بنجاح');
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('pages'));
    }
    
    public function duplicate($request,$response,$args) {
        $product = Page::find(rtrim($args['id'], '/'));
        $new = $product->replicate();
        $new->save();
        $this->flash->addMessage('success','تم تكرار المقالة بنجاح');
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('pages'));
    }  
    
    public function blukdelete($request,$response){
        $users = Page::truncate();
        delete_folders_files($this->container->conf['dir.pages']);
        $this->flash->addMessage('success', 'تم حذف كل الصفحات بنجاح');
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('pages'));
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
        $this->flash->addMessage('success', 'تم تنفيذ الأمر بنجاح');
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('pages'));
    
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
   
}

