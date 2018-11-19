<?php


namespace App\Middleware;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
defined('BASEPATH') OR exit('No direct script access allowed');
class Middleware {
    
    protected $container;
    
    public function __construct($container){
       $this->container = $container; 
    }   
    
}