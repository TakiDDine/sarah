<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Classes\files;
use \App\Models\Product;
use \App\Models\ProductCategories;
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductsCategoriesController extends Controller {
    
    public function index($request,$response){
 
        if($request->getMethod() == 'POST'){
        
            $name = clean($request->getParam('name'));
            $slug = strtolower(string_To_Uri(clean($request->getParam('slug'))));
            
            $unique = ProductCategories::where('slug','=',$slug)->orWhere('name','=',$name)->first();
            
            // check if the name or the slug are not empty
            if(empty($name) or empty($slug)) {
                $this->flash->addMessage('error','المرجوا ادخال اسم التصنيف والرابط');
                return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('products.categories'));
            }
            
           // check if the slug is alphanumeric
           if(is_slug($slug)){
                $this->flash->addMessage('error','الرابط يجب أن يتكون من حروف وأرقام لاتينية فقط ');
                return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('products.categories')); 
           }
            
            // check if the name is unique
            if($unique->name == $name) {
                $this->flash->addMessage('error','اسم التصنيف موجود من قبل');
                return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('products.categories'));
            }
            
            // check if the slug is unique
            if($unique->slug == $slug) {
                $this->flash->addMessage('error','رابط التصنيف موجود من قبل');
                return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('products.categories'));
            }

            // create the category
            ProductCategories::create([
                'name' => $name,
                'slug' => $slug
            ]);
            
            // success
            $this->flash->addMessage('success','تم اضافة التصنيف بنجاح');
            return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('products.categories'));
        }

        if($request->getMethod() != 'POST'){

                $searchview     = false;
                $count          = ProductCategories::count();   
                $page           = ($request->getParam('page', 0) > 0) ? $request->getParam('page') : 1;
                $limit          = 10; 
                $lastpage       = (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit));    // the number of the pages
                $skip           = ($page - 1) * $limit;
                $categories     = ProductCategories::skip($skip)->take($limit)->orderBy('created_at', 'desc')->get();

                return $this->view->render($response, 'admin/products/categories/index.twig', [
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
    }  
    
 
   public function delete($request,$response,$args) {
        $categorie = ProductCategories::find(rtrim($args['id'], '/'));
        $categorie->delete();
        $this->flash->addMessage('success','تم حذف التصنيف بنجاح');
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('products.categories'));
    }
    
    
    public function edit($request,$response,$args) {
        $categorie = ProductCategories::find(rtrim($args['id'], '/'));
        
        if($request->getMethod() == 'GET'){
            return $this->view->render($response, 'admin/products/categories/edit.twig',['categorie'=>$categorie]);
        }
    
        if($request->getMethod() == 'POST'){
            
            $name = clean($request->getParam('name'));
            $slug = strtolower(string_To_Uri(clean($request->getParam('slug'))));
            
            $unique = ProductCategories::where('slug','=',$slug)->orWhere('name','=',$name)->first();
            
            // check if the name or the slug are not empty
            if(empty($name) or empty($slug)) {
                $this->flash->addMessage('error','المرجوا ادخال اسم التصنيف والرابط');
                return $response->withRedirect($this->router->pathFor('products.categories.edit', ['id'=> $categorie->id , 'categorie' => $categorie]));
            }
            
           // check if the slug is alphanumeric
           if(is_slug($slug)){
                $this->flash->addMessage('error','الرابط يجب أن يتكون من حروف وأرقام لاتينية فقط ');
                return $response->withRedirect($this->router->pathFor('products.categories.edit', ['id'=> $categorie->id , 'categorie' => $categorie]));
           }
            
            $categorie->name = $name;
            $categorie->slug = $slug;
            $categorie->save();
            
            // success
            $this->flash->addMessage('success','تم تحديث التصنيف بنجاح');
            return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('products.categories'));
        }
        
    }
    
}