<?php

namespace App\Controllers\website;

use App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Classes\files;
use \App\Models\Comments;
use \App\Models\User;


class CommentsController extends \App\Controllers\Controller{
    
    
 
    public function create($request,$response,$args) {
       
        $body        = clean($request->getParam('comment')['body']);
        $post_id     = clean($request->getParam('post_id'));
        
        /*
        *   Get the user info if he is logged in the website
        */
        if(isset($_SESSION['auth-user'])){
            $user_id = User::find($_SESSION['auth-user']);
            $email   = " ";
            $author  = " ";
        }
        
        /*
        *   Get the Form info if he is NOT logged in
        */
        else {
            $author = clean($request->getParam('comment')['author']);
            $email = clean($request->getParam('comment')['email']);
        }
       
        /*
        *    Adding the comment
        */
        Comments::create([
            'post_id' => $post_id,
            'author' => $author,
            'content' => $body,
            'email' => $email,
            'approved' => 1
        ]);
        
        $this->flash->addMessage('success','your Comment Added seccussfuly');
        return $response->withRedirect($this->router->pathFor('website.article',['id'=>'ddldkdldld']));
        
        
    }
  
    
    
    
    
    
}