<?php

namespace App\Controllers\website;

use App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Classes\files;
use \App\Models\Emails;


class ContactController extends \App\Controllers\Controller{
    
    public function index($request,$response) {
       return $this->view->render($response,'website/contact.twig');
    }
    
    public function create($request,$response) {
        
        $helper = $this->helper;
        $post = $request->getParam('contact');
        
        $name       = $helper->clean($post['name']);
        $email      = $helper->clean($post['email']);
        $phone      = $helper->clean($post['phone']);
        $body       = $helper->clean($post['body']);

        Emails::create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'body' => $body
        ]);
        
        $this->flashsuccess('your message sent seccussfuly');
        return $response->withRedirect($this->router->pathFor('website.contact'));
        
    }
    
}

