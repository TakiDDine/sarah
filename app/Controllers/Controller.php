<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Classes\Helper;

defined('BASEPATH') OR exit('No direct script access allowed');

class Controller {
    
    protected $container;
    protected $helper;
    
    
    
    public function __construct($container){
       $this->container = $container; 
       $this->helper    = new Helper();
    } 
    
    public function flash($message, $type = 'success'){
        return $_SESSION['flash'][$type] = $message;
    }
    
    public function __get($name){
        return $this->container->$name;
    }
    
    
    
}