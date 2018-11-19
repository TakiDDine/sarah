<?php

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Classes\files;
use \App\Models\Emails;

defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends Controller{
   
  
    public function home($request,$response) {
     
      $count = [];
        
      $count['products'] = $this->db->table('products')->count(); 
      $count['users'] = $this->db->table('users')->count(); 
      $count['emails'] = $this->db->table('emails')->count(); 
      $count['posts'] = $this->db->table('posts')->count(); 
      $count['orders'] = $this->db->table('orders')->count(); 
      $count['pages'] = $this->db->table('pages')->count(); 

        
       return $this->container->view->render($response,'admin/home.twig',['count'=>$count]);
    }
    
    public function page404($request,$response){
        return $this->container->view->render($response,'admin/errors/404.twig');
    }
   
    
   
     
}

