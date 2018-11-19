<?php
//
//use \Psr\Http\Message\ServerRequestInterface as Request;
//use \Psr\Http\Message\ResponseInterface as Response;
//
//
//namespace App\Middleware;
//
////use ;
//
//class MinifierMiddleware extends Middleware {
//    
//    public function __invoke($request, $response, $next)
//    {
//        
//        require_once (INC_ROOT."/app/Classes/HtmlMin.php");
//
//        $response->getBody()->write('BEFORE');
//        
//    $response = $next($request, $response);
//    $response->getBody()->write('AFTER');
//
////        $minified_html = PHPWee\Minify::html($response);
//
//       $minified_html = \App\Classes\HtmlMin::minify($response);
//        return $minified_html;
//    }
//    
//    
//}