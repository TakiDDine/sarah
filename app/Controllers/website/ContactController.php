<?php

namespace App\Controllers\website;

use App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Classes\files;
use \App\Models\Emails;


class ContactController extends \App\Controllers\Controller{
    public function index($request,$response) {
       return $this->container->view->render($response,'website/contact.twig');
    }
    
    public function create($request,$response) {
       
        $name       = clean($request->getParam('contact')['name']);
        $email      = clean($request->getParam('contact')['email']);
        $phone      = clean($request->getParam('contact')['phone']);
        $body       = clean($request->getParam('contact')['body']);

        Emails::create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'body' => $body
        ]);
        
        $this->flash->addMessage('success','your message sent seccussfuly');
        return $response->withRedirect($this->router->pathFor('website.contact'));
        
    }
    
}

