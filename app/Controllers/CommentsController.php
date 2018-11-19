<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Models\Ads;
use \App\Models\Comments;
use \App\Classes\files;


defined('BASEPATH') OR exit('No direct script access allowed');

class CommentsController extends Controller {
    
    public function index($request,$response) {
        
            $searchview     = false;
            $count          = Comments::count();
            $page           = ($request->getParam('page', 0) > 0) ? $request->getParam('page') : 1;
            $limit          = 10;
            $lastpage       = (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit));
            $skip           = ($page - 1) * $limit;
            $comments       = Comments::skip($skip)->take($limit)->orderBy('created_at', 'desc')->get();

            return $this->view->render($response, 'admin/comments/index.twig', [
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
              'comments'=>$comments ,
              'searchView'=>$searchview,
              'searchQuery'=>$request->getParam('search')
            ]);
    }
    
    
    public function edit($request,$response,$args) {
        
        $comment = Comments::find(rtrim($args['id'], '/'));

        if($request->getMethod() == 'POST'){ 
            if(!empty($request->getParam('content'))){
                $comment->content = clean($request->getParam('content'));
                $comment->save();
                $this->flash->addMessage('success','تم تعديل التعليق بنجاح');
                return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('comments'));
            }
        }
        if($request->getMethod() == 'GET'){ 
            return $this->container->view->render($response,'admin/comments/edit.twig',['comment'=>$comment]); 
        }
    }

    public function delete($request,$response,$args) {
        $comment = Comments::find(rtrim($args['id'], '/'));
        $comment->delete();
        $this->flash->addMessage('success','تم حذف التعليق بنجاح');
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('comments'));
    }
    
public function create ($request,$response){
    
    // first of all check if the id of article is numeric 
    // check if the article exists
    // secure the inputs
    
    // To Do , Secure Me please !
    $user_id = 'quest';
    if(isset($_SESSION['auth-user'])){
        $user_id = $_SESSION['auth-user'];
    }

    $post_id = $request->getParam('post_id');
    $author = $request->getParam('author');
    $email  = $request->getParam('email');
    $body   = $request->getParam('body');
    
    Comments::create([
        'user_id' => $user_id,
        'post_id' => $post_id,
        'author' => $author,
        'email' => $email,
        'content' => $body,
        'approved' => $body
    ]);
    
    $this->flash->addMessage('success','تم تعديل التعليق بنجاح');
    return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('website.post',['id'=>$post_id]));
    
}
    public function blukdelete($request,$response){
        Comments::truncate();
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('comments'));
    }       
    
   
}

