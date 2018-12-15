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

          
           
           
  $posts = Faqs::leftJoin('faqscategories', 'faqscategories.id', '=', 'faqs.category')->select('faqscategories.name', 'faqs.*')
        ->get();
           

           
           
    $faqs = array();
    foreach ($posts->toArray() as $element) {
        $faqs[$element['name']][] = $element;
    }
           
           
           
           
           
           
                return $this->view->render($response, 'admin/faq/index.twig',compact('faqs'));
           

        
           
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

        if($request->getMethod() == 'POST'){

            // initilize the helper & Form data
            $helper = $this->helper;
            $Post = $helper->cleanData($request->getParams());

            // get & clean the form data
            $question = $Post['question'];
            $answer   = $Post['answer'];

            // add the question to database
            Faqs::create([ 'question' => $question,  'answer' => $answer ]);

            // flash success
            $this->flashsuccess('تم اضافة السؤال بنجاح');

            // redirect to faqs
            return $response->withRedirect($this->router->pathFor('faqs'));        
        }

        $categories = FaqsCategories::all();
        return $this->container->view->render($response,'admin/faq/create.twig',compact('categories'));
    }
    
    
    
    public function edit($request,$response,$args) {
        
        // get the Faqs categories
        $categories = FaqsCategories::all();
        
        // get the faq id to edit it
        $id = rtrim($args['id'], '/');
        
        // get the faq
        $Post = Faqs::find($id);
        
        if($request->getMethod() == 'GET'){   
            
            // if the faq exist 
            if($Post){   
                return $this->container->view->render($response,'admin/faq/edit.twig',['post'=>$Post,'categories'=>$categories]);
            }
            
            // otherwise , redirect to faqs page
            return $response->withRedirect($this->router->pathFor('faqs'));
        }
        
        // if the Form of the edit is submited
        if($request->getMethod() == 'POST'){
            
            // initilize the helper & Form data
            $helper = $this->helper;
            $Post = $helper->cleanData($request->getParams());

            // update in database
            $Post->question   = $Post['question'];
            $Post->answer     = $Post['answer'];
            $Post->category   = $Post['postCategory'];
            $Post->save();
            
            // flash success
            $this->flashsuccess( 'تم تعديل السؤال بنجاح');
            return $response->withRedirect($this->router->pathFor('faqs.edit',['id'=>$id]));   
        }
        
        
    }
    
    public function delete($request,$response,$args) {
        
        // get the id
        $id = rtrim($args['id'], '/');
        
        // get the Faq
        $Post = Faqs::find($id);
        
        // if the faq exist , delete
        if($Post){  $Post->delete(); $this->flashsuccess('تم حذف السؤال بنجاح'); }
        
        // redirect to faqs page
        return $response->withHeader('Location', $this->router->urlFor('faqs'));
    }
    
    
    
    public function duplicate($request,$response,$args) {
        
        // get the id
        $id = rtrim($args['id'], '/');
        
        // get the faq
        $product = Faqs::find($id);
        
        // duplicate
        if($product){ $new = $product->replicate(); $new->save();  }
        
        // flash success & redirect
        $this->flashsuccess('تم تكرار السؤال بنجاح');
        return $response->withRedirect($this->router->pathFor('faqs'));
    }
   
    
    
    public function blukdelete($request,$response){
        Faqs::truncate();
        return $response->withRedirect($this->router->pathFor('faqs'));
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
        
        // get the id
        $id = rtrim($args['id'], '/');
        
        // get the Faq categorie
        $categorie = FaqsCategories::find($id);
        
        if($request->getMethod() == 'GET'){
            if($categorie) {
                return $this->view->render($response, 'admin/faq/categories/edit.twig',['categorie'=>$categorie]);
            }
            return $response->withRedirect($this->router->pathFor('faqs.categories'));
        }
    
        if($request->getMethod() == 'POST'){
            
            $helper = $this->helper;
            $post = $helper->cleanData($request->getParams());

            // check if the name or the slug are not empty
            if(empty($post['name'])) {
                $this->flasherror('المرجوا ادخال اسم التصنيف والرابط');
                return $response->withRedirect($this->router->pathFor('faqs.cat.edit',compact('id','categorie')));
            }
            
            // update the info in the database
            $categorie->name = $post['name'];
            $categorie->save();
            
            // success &  redirect
            $this->flashsuccess('تم تحديث التصنيف بنجاح');
            return $response->withRedirect($this->router->pathFor('faqs.categories'));
            
        }
    }
    
    
    // Faqs Categorie Delete
    public function categories_delete($request,$response,$args){
        
        // get the id
        $id = rtrim($args['id'], '/');
        
        // get the categorie
        $categorie = FaqsCategories::find($id);
        
        // if the categorie exist , delete it
        if($categorie) {$categorie->delete(); $this->flashsuccess('تم حذف التصنيف بنجاح'); }
        return $response->withRedirect($this->router->pathFor('faqs.categories'));

    }
    
    
    // Faqs categorie create
    public function categories_create($request,$response){
        
            // get the category name & clean it
            $name = $this->helper->clean($request->getParam('name'));
            
            // check if it is unique
            $unique = FaqsCategories::where('name','=',$name)->first();
            
            // route to redirect
            $route =  $response->withRedirect($this->router->pathFor('faqs.categories'));
        
            // check if the name or the slug are not empty
            if(empty($name)) { $this->flashflasherror('المرجوا ادخال اسم التصنيف والرابط');return $route;   }
           
            // check if the name is unique
            if($unique->name == $name) { $this->flasherror('اسم التصنيف موجود من قبل'); return $route;}
            
            // create the category
            FaqsCategories::create([ 'name' => $name]);
            
            // success
            $this->flashsuccess('تم اضافة التصنيف بنجاح'); return $route;
    }


}