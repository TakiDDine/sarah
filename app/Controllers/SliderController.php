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
        
        /*
        *       Get the slide
        */
        $slider = Slider::find(rtrim($args['id'], '/'));
        
        
      if($request->getMethod() == 'GET'){ 
              return $this->container->view->render($response,'admin/slider/edit.twig',['slider'=>$slider]);
      }
        
      if($request->getMethod() == 'POST'){ 
          
         if($request->getParam('isAdChanged') == 'true') {
               
                /*
                * رفع الصورة الجديدة عندما يتم 
                */
                if(isset($_FILES['image']) and !empty($_FILES['image']['name'])) {

                    $files = new files();
                    $path = $this->container->conf['dir.slider'];
                    $file = $_FILES['image'];

                    // Upload
                    $slide =  $files->upload_avatar($path,$file);
                    
                    // delete old slide
                    unlink($this->container->conf['dir.slider'].$slider->image);
                    
                    // update in database
                    $slider->image = $slide;
                    
                    // saving
                    $slider->save();
                    
                }
             
             $link = $request->getParam('link');
             $slider->link = $link;
            $slider->save();
             
            }
          
          $this->flash->addMessage('success','تم تحديث السلايدر بنجاح');
          return $response->withRedirect($this->router->pathFor('slider.edit', ['id'=> $slider->id , 'slider'=>$slider]));
          
          
      }
        
       
    }
    
    public function create($request,$response) {
        
          if($request->getMethod() == 'GET'){ 
              return $this->container->view->render($response,'admin/slider/create.twig');
          }
        
          if($request->getMethod() == 'POST'){ 
            
            $files = new files();

            $path = $this->container->conf['dir.slider'];

            /*
            *   رفع الصورة الخارجية
            */
            $image  = ' ';
            if(isset($_FILES['image']) and !empty($_FILES['image']['name'])) {
                $image =  $files->upload_avatar($path,$_FILES['image']);
            } 

              
            $link = $request->getParam('link');
              
              
            /*
            * اضافة السلايدر
            */
            Slider::create(['image' => $image, 'link'=>$link ] );
            $this->flash->addMessage('success','تم اضافة السلايدر بنجاح');
            return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('slider'));
        }
       
    }
    
    
    
    public function delete($request,$response,$args) {
        
        
        /*
        *       Get the slide
        */
        $slider = Slider::find(rtrim($args['id'], '/'));
        
        /*
        *       Delete Slide image
        */
        unlink($this->container->conf['dir.slider'].$slider->image);
        
       
        /*
        * Delete the slider
        */
        $slider->delete();
        $this->flash->addMessage('success','تم حذف السلايدر بنجاح');
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('slider'));
    }
    
    
     
}

