<?php
namespace App\Controllers;
use \App\Classes as classes;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

defined('BASEPATH') OR exit('No direct script access allowed');


class installController extends Controller{
    public function install($request,$response) {
                if($request->getMethod() == 'POST'){
                   $dir = dirname(__DIR__);
                    
//                    $yes = ['a' => '1'];
                    
//                    $content = return $yes;
                    
                    
//                    file_put_contents($dir."/test.php",$yes);
                }
        
        return $this->container->view->render($response,'install/install.twig');
    } 
    
}