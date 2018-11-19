<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

defined('BASEPATH') OR exit('No direct script access allowed');

class StatiqueController extends Controller {
    
    /*
    *   Javascript Disabled
    */
    public function jsDisabled($request,$response) {
      return $this->container->view->render($response,'admin//java.twig'); 
    }
    
    /*
    *   Logs Page
    */
    public function logs($request,$response) {
      return $this->container->view->render($response,'admin/statiquePages/logs.twig'); 
    }
   
    /*
    *   Statistiques Page
    */
    public function statistiques($request,$response) {
       return $this->container->view->render($response,'admin/statiquePages/statistiques.twig');
    }
    
   
}

