<?php
namespace App\Controllers;
use \App\Classes as classes;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

defined('BASEPATH') OR exit('No direct script access allowed');


class installController extends Controller{
    public function index($request,$response) {

        
if ((int)phpversion()[0] < 7) {
    fwrite(
        STDERR,
        'Phan requires PHP version 7 or greater. See https://github.com/phan/phan#getting-started for more details.'
    );
    exit(1);
}        
        
        
        
        
        
        
        
        
        
        
        
        
        return $this->container->view->render($response,'install/install.twig');
    } 
    
}