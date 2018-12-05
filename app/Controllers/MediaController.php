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
   
    
  
    public function upload($request,$response) {
       
         $file = $_FILES['file'];
         if(isset($file) and !empty($file['name'])) {
            
            // upload the file to media directory
            $ad =  $this->files->media_uploader($this->dir('media'),$file);
             
            // add the media to database
            $up = Media::create([ 'name' => $ad['name'],  'post_mime_type' => $ad['file_src_mime'] ]);
             
            $url =  $this->url('media').$ad['name'];
             $format = $this->helper->get_ext($ad['name']);
             
             
             
             $size = $this->helper->calc(filesize($this->dir('media').$ad['name']));
             
             
             $download = $this->router->pathFor('media.download',['id'=>$up->id]);
             
           echo '<tr id="'.$up->id.'" class="new">
                <td><a href="'.$url.'" class="mediapreview">
                <img src="'.$url.'" class="img-rounded img-preview">
                </a></td>
                <td>Format: '.$format.'</td>
                <td>'.human_time_diff($up->created_at).'</td>
                <td>'.$size.'</td>
                <td><a href="'.$url.'" target="_blank">اضغط هنا</a></td>
                <td><a href="'.$download.'" >تحميل الملف</a></td>
                <td class="text-center">
                <a id="DeleteMedia" data-id="'.$up->id.'" class="text-danger"><i class="icon-trash"></i><b> حذف  </b></a>
                </td>
                </tr>';
        }  

    }
    
    
    
    
    
    //  upload the file & add to database & return the name of the file , Ajax Function
    public function modal_uploader($request,$response) {
        
         // get the file
         $file = $_FILES['file'];
        
         // check if not empty & upload
         if(isset($file) and !empty($file['name'])) {
            $ad =  $this->files->media_uploader($this->dir('media') ,$file);
            $up = Media::create([ 'name' => $ad['name'], 'post_mime_type' => $ad['file_src_mime'] ]);
            echo $ad['name'];
        }  
        
    }

   
    // Delete a media element by ajax so there is no redirect
    public function delete($request,$response,$args) {
        
        // get the id
        $id = rtrim($_POST['id'], '/');
        
        // get the media 
        $media = Media::find($id);
        
        if($media){
            unlink($this->dir('media').$media->name);
            $media->delete();
        }
        
    }
    
    
    // Delete a media element by ajax so there is no redirect
    public function download($request,$response,$args) {
        
        // get the id
        $id = rtrim($args['id'], '/');
        
        // get the media 
        $media = Media::find($id);

        
        if($media){
            $file = $this->dir('media').$media->name;
            $this->helper->download($file);
        }
        
    }
    
    
    
    // Delete all the media data & files from the media folder
    public function blukdelete($request,$response){
        
        // Clean the media Table in database
        Media::truncate();
        
        // Delete all the files in media folder 
        $this->helper->delete_folders_files($this->dir('media'));
        
        // Return to media page
        return $response->withRedirect($this->router->pathFor('media'));

    }
    
    
    
    
    
   
}

