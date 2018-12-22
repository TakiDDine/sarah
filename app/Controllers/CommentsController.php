<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Models\Ads;
use \App\Models\Comments;
use \App\Classes\files;


defined('BASEPATH') OR exit('No direct script access allowed');

class CommentsController extends Controller {
    
        // index Page, Get all ads
    public function index($request,$response) {
        $r = $this->paginate('Comments',$request);
        return $this->view->render($response, 'admin/comments/index.twig', ['users'=>$r[0],'p'=>$r[1]]);    
    }

    
        // edit a comment
        public function edit($request,$response,$args) {

             // get the comment id
            $id = rtrim($args['id'], '/');

            // get the comment
            $comment = Comments::find($id);

            if(!$comment){ return $response->withRedirect($this->router->pathFor('comments')); }
            
            if($request->getMethod() == 'POST'){ 
                if(!empty($request->getParam('content'))){
                    
                    $comment->content = $this->helper->clean($request->getParam('content'));
                    $comment->save();
                    $this->flashsuccess('تم تعديل التعليق بنجاح');
                    return $response->withHeader('Location', $this->router->urlFor('comments'));
                }
            }

            // open the page of comment edit
            return $this->view->render($response,'admin/comments/edit.twig',['comment'=>$comment]); 
           


        }

    
        // Create a comment & redirect to the article
        public function create ($request,$response){

            $helper = $this->helper;
            $post = $helper->cleanData($request->getParams());
            $user_id = isset($_SESSION['auth-user']) ? $_SESSION['auth-user'] : 'quest';

            Comments::create([
                'user_id'   => $user_id,
                'post_id'   => $post['post_id'],
                'author'    => $post['author'],
                'email'     => $post['email'],
                'content'   => $post['body'],
                'approved'  => 1
            ]);

            $this->flashsuccess('تم اضافة التعليق بنجاح');
            return $response->withRedirect($this->router->pathFor('website.post',['id'=>$post['post_id']]));

        }
    
        // delete a single comment by id
        public function delete($request,$response,$args) {
            $id = rtrim($args['id'], '/');
            $comment = Comments::find($id);
            if($comment) {
                 $comment->delete();
                 $this->flashsuccess('تم حذف التعليق بنجاح');
            }
            return $response->withRedirect($this->router->pathFor('comments'));
        }


        // Delete All the comments at once
        public function blukdelete($request,$response){
            Comments::truncate();
            return $response->withRedirect($this->router->pathFor('comments'));
        }       
   
}

