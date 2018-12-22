<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Classes\Helper;
use \App\Classes\files;
use JasonGrimes\Paginator;


defined('BASEPATH') OR exit('No direct script access allowed');

class Controller {
    
    protected $container;
    protected $helper;
    protected $files;
    
  
    
    public function paginate($model,$request) {
        $helper = $this->helper;
        $model = "\App\Models\\".$model;
        $model = new $model;
        $count          = $model->count();         
        $page           = ($request->getParam('page', 0) > 0) ? $request->getParam('page') : 1;
        $limit          = 10; 
        $lastpage       = (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit));   
        $skip           = ($page - 1) * $limit;
        $result         = $model->skip($skip)->take($limit)->orderBy('created_at', 'desc')->get();
        
        $search = $helper->clean($request->getParam('search'));
        
        // Search Logic
        if($search){
        $result = $model->where('username', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%")
                ->skip($skip)
                ->take($limit)
                ->orderBy('created_at', 'desc')
                ->get();
         $count =  $result->count();   
        }
        $urlPattern     = !empty($search) ? "?search=$search&page=(:num)" : "?page=(:num)"  ;
        
        $paginator = new Paginator($count, $limit, $page, $urlPattern);
        return [$result,$paginator];
    }
    
    
    public function __construct($container){
       $this->container = $container; 
       $this->helper    = new Helper();
       $this->files     =  new files();
        
      
    } 
    
    public function dir($dir){
       return $this->container->conf['dir.'.$dir];
    }
    public function url($url){
        return $this->container->conf['url.'.$url];
    }
    
    public function flash($message, $type = 'success'){
        return $_SESSION['flash'][$type] = $message;
    }
    
    public function flasherror($message){
        return $this->flash->addMessage('error',$message);
    } 
    
    public function flashsuccess($message){
        return $this->flash->addMessage('success',$message);
    } 
    
    
    public function __get($name){
        return $this->container->$name;
    }
    
    
    
}