<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Models\Ads;
use \App\Classes\files;

defined('BASEPATH') OR exit('No direct script access allowed');

class AdsController extends Controller {
    
    public function index($request,$response) {
        
            $searchview     = false;
            $count          = ads::count();   // Count of all available users      
            $page           = ($request->getParam('page', 0) > 0) ? $request->getParam('page') : 1;
            $limit          = 10; // Number of Users on one page   
            $lastpage       = (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit));    // the number of the pages
            $skip           = ($page - 1) * $limit;
            $ads          = $this->db->table('ads')->skip($skip)->take($limit)->orderBy('created_at', 'desc')->get();


            return $this->view->render($response, 'admin/ads/index.twig', [
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
              'ads'=>$ads ,
              'searchView'=>$searchview,
              'searchQuery'=>$request->getParam('search')
            ]);
        
        
    }
    
    
    
    public function show($request,$response,$args) {
        
        $ads = ads::find($args['id']);
        $post = $request->getParams();
        $helper = $this->helper;
        
        
        if($request->getMethod() == 'POST'){ 
             
            
            
            
            
            
        $statue = 0;
        $url = " ";
        $htmlCode = " ";
        
        $name =  " ";
        if($post['isAdChanged'] == 'true') {
                $ad = " ";
                $file = $_FILES['image'];
                
                // Upload
                if(isset($file) and !empty($file['name'])) { $ad =  $this->files->upload_avatar($this->dir('ads'),$file);  }  
                
                unlink($this->dir('ads').$ads->image);
                $ads->image = $ad;
            }


        if($post['active'] == 'active') {
            $statue = 1;
        }
        
        // do not forget to clean this one before sending
        if(!empty(clean($request->getParam('link')))){
            $url = clean($request->getParam('link'));
        }
        
        // do not forget to clean this one before sending
        if(!empty($request->getParam('codehtml'))){
            $htmlCode = clean($request->getParam('codehtml'));
        }
        if(!empty($request->getParam('name'))){
            $name = clean($request->getParam('name'));
        }
        
        $ads->name = $name;
        $ads->url = $url;
        $ads->statue = $statue;
        $ads->htmlcode = $htmlCode;
        $ads->area = clean($request->getParam('areaUndetected'));
        $ads->save();
        $this->flash->addMessage('success','تم تحديث الإعلان بنجاح');
        return $response->withRedirect($this->router->pathFor('ads.show', ['id'=> $ads->id , 'ads' => $ads]));
        }
        
        return $this->container->view->render($response,'admin/ads/show.twig',['ads'=>$ads]); 
    }
    
    
  
    
    public function create($request,$response) {
        
        if($request->getMethod() == 'GET'){ 
        return $this->container->view->render($response,'admin/ads/create.twig'); 
        }
        
        
        $statue = 0;
        
        if($request->getParam('active') == 'active') {
            $statue = 1;
        }
        
        $url = " ";
        // do not forget to clean this one before sending
        if(!empty($request->getParam('link'))){
            $url = clean($request->getParam('link'));
        }
        
        
        
        $htmlCode = " ";
        // do not forget to clean this one before sending
        if(!empty($request->getParam('codehtml'))){
            $htmlCode = clean($request->getParam('codehtml'));
        }
        
        $ads = " ";
        // check if there is a file
        if(isset($_FILES['image']) and !empty($_FILES['image']['name'])) {

            $ads = new files();
            $path = $this->container->conf['dir.ads'];
            $file = $_FILES['image'];
            
            // Upload
            $ads =  $ads->upload_avatar($path,$file);
            
        }
        
        
        $area = $request->getParam('areaUndetected');

        Ads::create([
        'name' => $request->getParam('name'),
        'image' => $ads,
        'statue' => $statue,
        'url'   => $url,
        'area'   => $area,
        'htmlcode' => $htmlCode
        ]);
        
        $this->flash->addMessage('success','تم اضافة الإعلان بنجاح');
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('ads'));
        
    }
    

    public function delete($request,$response,$args) {
        $ad = ads::find(rtrim($args['id'], '/'));
        unlink($this->container->conf['dir.ads'].$ad->image);
        $ad->delete();
        $this->flash->addMessage('success','تم حذف الإعلان بنجاح');
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('ads'));
    }
    
    public function blukdelete($request,$response){
        ads::truncate();
        delete_folders_files($this->container->conf['dir.undetected']);
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('ads'));
    }
    
    
    
    
    
   
}

