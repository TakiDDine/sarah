<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Models\Faqs;
use \App\Models\FaqsCategories;
use \App\Classes\files;

defined('BASEPATH') OR exit('No direct script access allowed');

class FaqsController  extends Controller {
    
    
       public function index($request,$response) {
                $count          = Faqs::count();   
                $page           = ($request->getParam('page', 0) > 0) ? $request->getParam('page') : 1;
                $limit          = 10; 
                $lastpage       = (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit));    
                $skip           = ($page - 1) * $limit;
                $posts          = Faqs::skip($skip)->take($limit)->orderBy('created_at', 'desc')->get();

                return $this->view->render($response, 'admin/faq/index.twig', [
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
                ]);
        }

    
       public function front($request,$response) {
           
                $faqsCategories = FaqsCategories::all();
           
                $count          = Faqs::count();   
                $page           = ($request->getParam('page', 0) > 0) ? $request->getParam('page') : 1;
                $limit          = 10; 
                $lastpage       = (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit));    
                $skip           = ($page - 1) * $limit;
                $posts          = Faqs::skip($skip)->take($limit)->orderBy('created_at', 'desc')->get();

                return $this->view->render($response, 'website/faqs.twig', [
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
                  'faqs'=>$posts ,
                  'categories'=>$faqsCategories 
                ]);
        }
    
    
    
    
    
        public function create($request,$response) {

            if($request->getMethod() == 'GET'){
                $categories = FaqsCategories::all();
                return $this->container->view->render($response,'admin/faq/create.twig',['categories'=>$categories]);
            }
            if($request->getMethod() == 'POST'){
        
                $question = clean($request->getParam('question'));
                $answer = clean($request->getParam('answer'));
                Faqs::create([
                    'question' => $question,
                    'answer'   => $answer
                ]);
                $this->flash->addMessage('success','تم اضافة السؤال بنجاح');
                return $response->withRedirect($this->router->pathFor('faqs'));        
          }
     }
    
    
    
    public function edit($request,$response,$args) {
        $categories = FaqsCategories::all();
        $id = rtrim($args['id'], '/');
        $Post = Faqs::find($id);
        $files = new files();
        if($request->getMethod() == 'GET'){       
            return $this->container->view->render($response,'admin/faq/edit.twig',['post'=>$Post,'categories'=>$categories]);
        }
        
        if($request->getMethod() == 'POST'){
            $Post->question                = $request->getParam('question');
            $Post->answer                 = $request->getParam('answer');
            $Post->category           = $request->getParam('postCategory');
            $Post->save();
            
            $this->flash->addMessage('success', 'تم تعديل السؤال بنجاح');
            return $response->withRedirect($this->container->router->pathFor('faqs.edit',['id'=>$id]));   
            
        }
        
        
    }
    
    public function delete($request,$response,$args) {
        $Post = Faqs::find(rtrim($args['id'], '/'));
        $Post->delete();
        $this->flash->addMessage('success','تم حذف السؤال بنجاح');
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('faqs'));
    }
    
    public function duplicate($request,$response,$args) {
        $product = Faqs::find(rtrim($args['id'], '/'));
        $new = $product->replicate();
        $new->save();
        $this->flash->addMessage('success','تم تكرار السؤال بنجاح');
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('faqs'));
    }
   
    public function blukdelete($request,$response){
        Faqs::truncate();
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('faqs'));
    }  
    
    
    
    /*
    *       Faqs Categoris
    */
    public function categories($request,$response){
        $searchview     = false;
        $count          = FaqsCategories::count();   
        $page           = ($request->getParam('page', 0) > 0) ? $request->getParam('page') : 1;
        $limit          = 10; 
        $lastpage       = (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit));    // the number of the pages
        $skip           = ($page - 1) * $limit;
        $categories     = FaqsCategories::skip($skip)->take($limit)->orderBy('created_at', 'desc')->get();

        return $this->view->render($response, 'admin/faq/categories/index.twig', [
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
          'categories'=> $categories ,
        ]);
    }
    
    
    
    public function categories_edit($request,$response,$args){
        $categorie = FaqsCategories::find(rtrim($args['id'], '/'));
        
        if($request->getMethod() == 'GET'){
            return $this->view->render($response, 'admin/faq/categories/edit.twig',['categorie'=>$categorie]);
        }
    
        if($request->getMethod() == 'POST'){
            
            $name = clean($request->getParam('name'));
            
            $unique = FaqsCategories::where('name','=',$name)->first();
            
            // check if the name or the slug are not empty
            if(empty($name)) {
                $this->flash->addMessage('error','المرجوا ادخال اسم التصنيف والرابط');
                return $response->withRedirect($this->router->pathFor('faqs.cat.edit', ['id'=> $categorie->id , 'categorie' => $categorie]));
            }
            
            $categorie->name = $name;
            $categorie->save();
            
            // success
            $this->flash->addMessage('success','تم تحديث التصنيف بنجاح');
            return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('faqs.categories'));
        }
    }
    
    
    public function categories_delete($request,$response,$args){
        $categorie = FaqsCategories::find(rtrim($args['id'], '/'));
        $categorie->delete();
        $this->flash->addMessage('success','تم حذف التصنيف بنجاح');
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('faqs.categories'));
    }
    
    public function categories_create($request,$response){
        
            $name = clean($request->getParam('name'));
            
            $unique = FaqsCategories::where('name','=',$name)->first();
            
            // check if the name or the slug are not empty
            if(empty($name)) {
                $this->flash->addMessage('error','المرجوا ادخال اسم التصنيف والرابط');
                return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('faqs.categories'));
            }
           
            // check if the name is unique
            if($unique->name == $name) {
                $this->flash->addMessage('error','اسم التصنيف موجود من قبل');
                return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('faqs.categories'));
            }
            
            // create the category
            FaqsCategories::create([
                'name' => $name
            ]);
            
            // success
            $this->flash->addMessage('success','تم اضافة التصنيف بنجاح');
            return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('faqs.categories'));
        
    }

    
    
    
    
    
    
}

