<?php
namespace App\Controllers;
use \App\Classes as classes;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

defined('BASEPATH') OR exit('No direct script access allowed');


class installController extends Controller{
    
    
    public function index($request,$response) {
        return $this->container->view->render($response,'install/install.twig');
    } 
    
}