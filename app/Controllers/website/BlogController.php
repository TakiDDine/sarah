<?php

namespace App\Controllers\website;

use App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Classes\files;
use \App\Models\Emails;
use \App\Models\Post;
use \App\Models\PostsCategories;
use \App\Models\Comments;


class BlogController extends \App\Controllers\Controller{
    
    public function index($request,$response) {
                $searchview     = false;
                $count          = Post::count();   
                $page           = ($request->getParam('page', 0) > 0) ? $request->getParam('page') : 1;
                $limit          = 10; 
                $lastpage       = (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit));    
                $skip           = ($page - 1) * $limit;
                $posts          = Post::skip($skip)->take($limit)->orderBy('created_at', 'desc')->get();

        $categories = PostsCategories::all();
        
        
                return $this->view->render($response, 'website/blog.twig', [
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
                  'posts'=>$posts ,
                  'categories' =>$categories,
                  'searchView'=>$searchview,
                  'searchQuery'=>$request->getParam('search')
                ]);
        }
    
     
    public function article($request,$response,$args) {
       $id = rtrim($args['id'], '/');
       $article = Post::find($id);
       $categories = PostsCategories::all();
       $related = Post::where('categoryID', $article->categoryID)->get()->toArray();
       $comments = Comments::where('post_id', $id)->get()->toArray();
       return $this->container->view->render($response,'website/article.twig',[
           'article'=>$article,
           'comments' =>$comments,
           'categories' =>$categories,
           'related' =>$related
       ]);
    }
    

   public function categorie($request,$response,$args) {
       $id = rtrim($args['id'], '/');
       $categories = PostsCategories::all();
       $posts = Post::where('categoryID', $id)->get()->toArray();
       return $this->container->view->render($response,'website/blog.twig',[
           'posts'=>$posts ,
           'categories' =>$categories,
       ]);
    }    
    
    
    
    
}