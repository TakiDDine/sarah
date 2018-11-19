<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Models\Ads;
use \App\Models\Media;
use \App\Classes\files;

defined('BASEPATH') OR exit('No direct script access allowed');

class MediaController extends Controller {
    
    public function index($request,$response) {
        
            $count          = Media::count();   
            $page           = ($request->getParam('page', 0) > 0) ? $request->getParam('page') : 1;
            $limit          = 10; 
            $lastpage       = (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit));    
            $skip           = ($page - 1) * $limit;
            $media          =  Media::skip($skip)->take($limit)->orderBy('created_at', 'desc')->get();

            return $this->view->render($response, 'admin/media/index.twig', [
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
              'media'=>$media 
            ]);
        
    }
    
    /*
    public function show($request,$response,$args) {
        
        $ads = ads::find($args['id']);

        if($request->getMethod() == 'POST'){ 
             
        $statue = 0;
        $url = " ";
        $htmlCode = " ";
        
        $name =  " ";
        if($request->getParam('isAdChanged') == 'true') {
                $ad = " ";
                
                
                if(isset($_FILES['image']) and !empty($_FILES['image']['name'])) {

                    $files = new files();
                    $path = $this->container->conf['dir.ads'];
                    $file = $_FILES['image'];

                    // Upload
                    $ad =  $files->upload_avatar($path,$file);
                }  
                
                unlink($this->container->conf['dir.ads'].$ads->image);
                $ads->image = $ad;
            }


        if($request->getParam('active') == 'active') {
            $statue = 1;
        }
        
        
        $ads->name = $name;
        $ads->url = $url;
        $ads->statue = $statue;
        $ads->htmlcode = $htmlCode;
        $ads->area = $request->getParam('areaUndetected');
        $ads->save();
        $this->flash->addMessage('success','تم تحديث الإعلان بنجاح');
        return $response->withRedirect($this->router->pathFor('ads.show', ['id'=> $ads->id , 'ads' => $ads]));
        }
        
        return $this->container->view->render($response,'admin/ads/show.twig',['ads'=>$ads]); 
    }
    */
    
  
    public function upload($request,$response) {
       
         if(isset($_FILES['file']) and !empty($_FILES['file']['name'])) {

            $files = new files();
            $path = $this->container->conf['dir.media'];
            $file = $_FILES['file'];
            
            $ad =  $files->media_uploader($path,$file);
            $up = Media::create([
                'name' => $ad['name'],
                'post_mime_type' => $ad['file_src_mime']
            ]);
             
            $url =  $this->container->conf['url.media'].$ad['name'];

             echo '<tr class="new">
                    <td>'.$ad["name"].'</td>
                    <td>'.$ad["file_src_mime"].'</td>
                    <td>'.human_time_diff($up->created_at).'</td>
                    <td><a href="'.$url.'" target="_blank">اضغط هنا</a></td>
                    <td class="text-center">
                        <a href="/wp-admin/faqs/delete//" class="text-danger"><i class="icon-trash"></i><b> حذف  </b></a>
                    </td>
                </tr>';
        }  

    }
    
   
    public function delete($request,$response,$args) {
        $id = rtrim($_POST['id'], '/');
        $media = Media::find($id);
        unlink($this->container->conf['dir.media'].$media->name);
        $media->delete();
    }
    
    public function blukdelete($request,$response){
        Media::turncate();
        $this->flash->addMessage('success', 'تم حذف كل  الميديا بنجاح');
        
        // Delete All the images
        
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('ads'));
    }
    
    
    
    
    
   
}

