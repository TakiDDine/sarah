<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Models\Emails;

defined('BASEPATH') OR exit('No direct script access allowed');

class MailController extends Controller {
    
    public function index($request,$response) {
        
            $count          = Emails::count();   
            $page           = ($request->getParam('page', 0) > 0) ? $request->getParam('page') : 1;
            $limit          = 10; 
            $lastpage       = (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit));    
            $skip           = ($page - 1) * $limit;
            $emails         = Emails::skip($skip)->take($limit)->orderBy('created_at', 'desc')->get();

            return $this->view->render($response, 'admin/mail/index.twig', [
                'pagination'    => [
                    'needed'        => $count > $limit,
                    'count'         => $count,
                    'page'          => $page,
                    'lastpage'      => $lastpage,
                    'limit'         => $limit,
                    'prev'          => $page-1,
                    'next'          => $page+1,
                    'start'          => max(1, $page - 4),
                    'end'          => min($page + 4, $lastpage),
                ],
              'emails'=>$emails ,
            ]);
    } 
    
    
    public function show($request,$response,$args) { 
            $email = Emails::find($args['id']);
            $email->seen = 1;
            $email->save();
            return $this->container->view->render($response,'admin/mail/show.twig',['email'=>$email]);
    } 
    
    public function Action($request,$response,$args) { 
        $email = Emails::find($args['id']);
        $email->delete();
        $this->flash->addMessage('success','تم حذف الرسالة بنجاح');
        return $response->withRedirect($this->router->pathFor('mail'));
    } 
    
     public function blukdelete($request,$response){
        Emails::truncate();
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('mail'));
    }
   
}

