<?php

namespace App\Controllers\website;

use App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Classes\files;
use \App\Models\Emails;
use \App\Models\User;


class AuthController extends \App\Controllers\Controller{
    
    public function login_get($request,$response) {
       return $this->container->view->render($response,'website/login.twig');
    }
    public function register_get($request,$response) {
       return $this->container->view->render($response,'website/register.twig');
    }
    public function account($request,$response) {
        return $this->container->view->render($response,'website/account.twig');
    }
    
    
    
    
    
    public function login_post($request,$response) {
       
        $name       = $request->getParam('first_name') ;
        $email      = $request->getParam('last_name') ;
        $phone      = $request->getParam('email');
        $body       = $request->getParam('password') ;

        Emails::create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'body' => $body
        ]);
        
        $this->flash->addMessage('success','your message sent seccussfuly');
        return $response->withRedirect($this->router->pathFor('website.contact'));
        
    }
    
    
    public function register_post($request,$response) {
        
        $first_name     = $request->getParam('first_name') ;
        $last_name      = $request->getParam('last_name') ;
        $email          = $request->getParam('email');
        $password       = $request->getParam('password') ;

        $full_name = $first_name.' '.$last_name;
        $username = string_To_Uri($full_name);
        $password = password_hash($password,PASSWORD_DEFAULT);
        
        $user = User::create([
            'username' => $username,
            'full_name' => $full_name,
            'email' => $email,
            'password' => $password,
            'role' => '1',
            'statue' => '1'
        ]);
        
        $_SESSION['auth-user'] = $user->id;
      
        return $response->withRedirect($this->router->pathFor('website.home'));
        
    }
    
    
    public function reset_post($request,$response) {
    }
    
    
    
    
    
    
}