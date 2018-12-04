<?php

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Classes\files;
use \App\Models\Slider;
defined('BASEPATH') OR exit('No direct script access allowed');
class SliderController extends Controller{
   
  
    public function index($request,$response) {
        
            $count          = Slider::count();   
            $page           = ($request->getParam('page', 0) > 0) ? $request->getParam('page') : 1;
            $limit          = 10; 
            $lastpage       = (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit));    
            $skip           = ($page - 1) * $limit;
            $slides         =  Slider::skip($skip)->take($limit)->orderBy('created_at', 'desc')->get();

            return $this->view->render($response, 'admin/slider/index.twig', [
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
              'slides'=>$slides
            ]);  
       
    }
    
  
    public function edit($request,$response,$args) { 
        
    //  Get the id & slide
    $id = rtrim($args['id'], '/');
    $slider = Slider::find($id);
        
    // initlize the helper & the form
    $helper = $this->helper;
    $uploader = $this->files;
        
      if($request->getMethod() == 'GET'){ 
          if($slider) {
              return $this->container->view->render($response,'admin/slider/edit.twig',['slider'=>$slider]);
          }
          return $response->withRedirect($this->router->pathFor('slider'));
      }
        
        
        
      if($request->getMethod() == 'POST'){ 
          
         if($request->getParam('isAdChanged') == 'true') {
               
                // upload the new image
                $file = $_FILES['image'];
                     
                if(isset($file) and !empty($file['name'])) {

                    // Upload
                    $slide =  $uploader->upload_avatar($this->dir('slider'),$file);
                    
                    // delete old slide
                    $old = $this->dir('slider').$slider->image;
                    if(file_exists($old)) {unlink($old);}
                    
                    // update in database & save
                    $slider->image = $slide;
                    $slider->save();
                    
                }
             
            $link = $request->getParam('link');
            $slider->link = $link;
            $slider->save();
             
            }
          
          $this->flashsuccess('تم تحديث السلايدر بنجاح');
          return $response->withRedirect($this->router->pathFor('slider.edit', ['id'=> $slider->id , 'slider'=>$slider]));
          
          
      }
        
       
    }
    
    public function create($request,$response) {
        
          if($request->getMethod() == 'GET'){ 
              return $this->container->view->render($response,'admin/slider/create.twig');
          }
        
          if($request->getMethod() == 'POST'){ 
            
            $form     = $request->getParams();
            $helper   = $this->helper;
            $uploader = $this->files;

            // upload the image
            $image  = ' ';
            $file = $_FILES['image'];
            if(isset($file) and !empty($file['name'])) { $image =  $uploader->upload_avatar($this->dir('slider'),$file); } 

            // get the link
            $link = $helper->clean($form['link']);
              
            // create the slider
            Slider::create(['image' => $image, 'link'=>$link ] );
            
              // flash & redirect
            $this->flashsuccess('تم اضافة السلايدر بنجاح');
            return $response->withRedirect($this->router->pathFor('slider'));
        }
       
    }
    
    
    
    public function delete($request,$response,$args) {
        
        //  Get the id & slide
        $id = rtrim($args['id'], '/');
        $slider = Slider::find($id);
        
        // Delete Slide image if exist
        $image = $this->dir('slider').$slider->image;
        if(file_exists($image)) {unlink($image);}
     
        // Delete the slider if exist & flash success
        if($slider){$slider->delete();$this->flashsuccess('تم حذف السلايدر بنجاح');}
        
        // redirect to slides route
        return $response->withHeader('Location', $this->router->urlFor('slider'));
    }
    
    
     
}

