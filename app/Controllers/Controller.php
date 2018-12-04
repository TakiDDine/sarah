<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Classes\Helper;
use \App\Classes\files;


defined('BASEPATH') OR exit('No direct script access allowed');

class Controller {
    
    protected $container;
    protected $helper;
    protected $files;
    
  
    
    
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