<?php 

namespace App\Classes;

use \App\Classes\app;

defined('BASEPATH') OR exit('No direct script access allowed');

class files {
    
    
    /*
    *       Returns @avatar , the name of uploaded file 
    */
    public function upload_avatar($path,$file){
        $handle = new \upload($file);
        if ($handle->uploaded) {
            
        $nameimmg = app::str_random();
        $handle->file_new_name_body   = $nameimmg;

        $handle->process($path);
          if ($handle->processed) {
            $avatar = $nameimmg.'.'.$handle->file_src_name_ext;
            $handle->clean();
            return $avatar;
          } else {
            return false;
          }
        }
    }
    
    
    public function file_upload($path,$file){
        $handle = new \upload($file);
        if ($handle->uploaded) {
            
        $nameimmg = app::str_random();
        $handle->file_new_name_body   = $nameimmg;

        $handle->process($path);
          if ($handle->processed) {
            $avatar = $nameimmg.'.'.$handle->file_src_name_ext;
            $handle->clean();
            return $avatar;
              
          } else {
            return false;
          }
        }
    }
    
     public function media_uploader($path,$file){
        $handle = new \upload($file);
        if ($handle->uploaded) {
            
        $nameimmg = app::str_random();
        $handle->file_new_name_body   = $nameimmg;

        $handle->process($path);
          if ($handle->processed) {
            $avatar = $nameimmg.'.'.$handle->file_src_name_ext;
            
              $result = [];
              $result['name'] = $avatar;
              $result['file_src_mime'] = $handle->file_src_mime;
            
              $handle->clean();
              return $result;
              
              
          } else {
            return false;
          }
        }
    }
    
    
    
    public function multiple_upload($path,$file){
        $files = array();
        foreach ($file as $k => $l) {
          foreach ($l as $i => $v) {
          if (!array_key_exists($i, $files))
            $files[$i] = array();
            $files[$i][$k] = $v;
          }
        }
        $images = [];
        foreach ($files as $file) {
            $images[] = $this->upload_avatar($path,$file);
        }
        return $images;
    }

    
    
    
    
    
    
}