<?php

namespace App\Controllers\website;

use App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Classes\files;
use \App\Models\Emails;


class StatiquePagesController extends \App\Controllers\Controller{
    
    public function faqs($request,$response) {
       return $this->container->view->render($response,'website/faqs.twig');
    }
 
    public function about($request,$response) {
       return $this->container->view->render($response,'website/about-us.twig');
    }
    
  
    
    
    
    
    
}