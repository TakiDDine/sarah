<?php
namespace App\Middleware;
use \App\Models\options as Options;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

defined('BASEPATH') OR exit('No direct script access allowed');

class downMiddleware extends Middleware {
    
    public function __invoke($request, $response, $next)
    {
        $op = new Options;
        $x = $op->get_option('mode') == 1 ? 'Notdown' : 'down';
        if($x == 'down') {
            return $this->container->view->render($response,'website/sitemaintance.twig');
        }else {
            
        $response = $next($request, $response);
        return $response;
            
        }
    }

}