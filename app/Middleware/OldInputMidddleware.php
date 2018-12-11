<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
namespace App\Middleware;
defined('BASEPATH') OR exit('No direct script access allowed');

class OldInputMidddleware extends Middleware {
    
    
    
    public function __invoke($request, $response, $next)
    {
        
        if(isset($_SESSION['auth-admin'])):
        
        $this->container->view->getEnvironment()->addGlobal('old', $_SESSION['old']);
        $_SESSION['old'] = $request->getParams();
        endif;
        $response = $next($request, $response);
        return $response;
        
    }
    
    
}