<?php 
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
namespace App\Middleware;

defined('BASEPATH') OR exit('No direct script access allowed');
class exportMiddleware extends Middleware {
    
    public function __invoke($request, $response, $next)
    {
        $response = $next($request, $response);
        echo 'ijhaaaaaaaaaaaaaaan';
        return $response;
    }
    
    
}