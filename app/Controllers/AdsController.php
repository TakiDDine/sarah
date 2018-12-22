<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Models\Ads;
use \App\Classes\files;
defined('BASEPATH') OR exit('No direct script access allowed');

class AdsController extends Controller {
    
        
    // index Page, Get all ads
    public function index($request,$response) {
        $r = $this->paginate('ads',$request);
        return $this->view->render($response, 'admin/ads/index.twig', ['users'=>$r[0],'p'=>$r[1]]);    
    }
    
   
    
    
    
    public function show($request,$response,$args) {
        $id = rtrim($args['id'], '/');
        $ads = ads::find($id); 
        
        if(!$ads) { return $response->withRedirect($this->router->pathFor('ads')); }
        
        if($request->getMethod() == 'POST'){ 
            
            $helper = $this->helper;
            $up = $this->files;
            $post = $helper->cleanData($request->getParams());       
            $file = $_FILES['image'];
     
            if($post['isAdChanged'] == 'true') {
                $old = $this->dir('ads').$ads->image;
                $ads->image = !empty($file['name']) ? $up->up($this->dir('ads'),$file) : ' ';
                if(file_exists($old)) { unlink($old); }          
            }

            $statue  = $post['active'] == 'active' ? 1 : 0;
            $url = !empty($post['link']) ? $post['link'] : '';    
            $htmlCode = !empty($post['codehtml']) ? $post['codehtml'] : '';    
            $name = !empty($post['name']) ? $post['name'] : ' ';

            $ads->name = $name;
            $ads->url = $url;
            $ads->statue = $statue;
            $ads->htmlcode = $htmlCode;
            $ads->area = $post['areaUndetected'];

            $ads->save();
            $this->flashsuccess('تم تحديث الإعلان بنجاح');
            return $response->withRedirect($this->router->pathFor('ads.show', compact('id','ads') ));

        }
        
        return $this->view->render($response,'admin/ads/show.twig',['ads'=>$ads]); 
    }
    
    
  
    
    // create the ads
    public function create($request,$response) {
        
        if($request->getMethod() == 'POST'){ 
            $helper = $this->helper;
            $up = new files();
            $post = $helper->cleanData($request->getParams());
            $image = $_FILES['image'];
            $statue  = $post['active'] == 'active' ? 1 : 0;
            $url = !empty($post['link']) ? $post['link'] : '';
            $htmlCode = !empty($post['codehtml']) ? $post['codehtml'] : '';
            $ads = !empty($image['name']) ? $up->up($this->dir('ads'),$image) : ' ';
            $area = $post['areaUndetected'];

            Ads::create([
                'name' => $post['name'],
                'image' => $ads,
                'statue' => $statue,
                'url'   => $url,
                'area'   => $area,
                'htmlcode' => $htmlCode
            ]);

            $this->flashsuccess('تم اضافة الإعلان بنجاح');
            return $response->withRedirect($this->router->pathFor('ads'));
        }

        return $this->view->render($response,'admin/ads/create.twig'); 
    }
    

    // Delete the ad by id , and delete the ad images in ads Directory
    public function delete($request,$response,$args) {
        $id = rtrim($args['id'], '/');
        $ad = ads::find($id);
        
        if($ad) {
            $img = $this->dir('ads').$ad->image;
            if(file_exists($img)) { unlink($img); }
            $ad->delete();
            $this->flashsuccess('تم حذف الإعلان بنجاح');
        }
        return $response->withRedirect($this->router->pathFor('ads'));
    }

    
    // Delete All Ads , and delete all the images in ads Directory
    public function blukdelete($request,$response){
        ads::truncate();
        $this->helper->delete_folders_files($this->dir('ads'));
        return $response->withRedirect($this->router->pathFor('ads'));
    }
    

}