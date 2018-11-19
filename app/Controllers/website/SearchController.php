<?php

namespace App\Controllers\website;

use App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Classes\files;
use \App\Models\Emails;
use \App\Models\Product;


class SearchController extends \App\Controllers\Controller{
    
        public function index($request,$response) {
        
            $category = $request->getParam('collection');
            if(!is_numeric($category)){
             $category = "";
            }
     
            
            $searchview     = false;
            $count          = Product::count();  
            $page           = ($request->getParam('page', 0) > 0) ? $request->getParam('page') : 1;
            $limit          = 12; 
            $lastpage       = (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit));    
            $skip           = ($page - 1) * $limit;
            $products       = Product::skip($skip)->take($limit)->orderBy('created_at', 'desc')->get();

            
            
            // Search Logic
            if($request->getParam('q') or $request->getParam('collection')){
                  
               $search = $request->getParam('q');
               $products  = Product::where('categoryID',$category)
                    ->orWhere('description', 'LIKE', "%$search%")
                    ->orWhere('name', 'LIKE', "%$search%")
                    ->skip($skip)
                    ->take($limit)
                    ->get();    

               $count = count($products);
               $lastpage       = (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit));    // the number of the pages
               $searchview = true;
            }
            
            
            
            return $this->view->render($response, 'website/search.twig', [
                'pagination'    => [
                    'needed'        => $count > $limit,
                    'count'         => $count,
                    'page'          => $page,
                    'lastpage'      => $lastpage,
                    'limit'         => $limit,
                    'prev'          => $page-1,
                    'next'          => $page+1,
                    'start'         => max(1, $page - 4),
                    'end'           => min($page + 4, $lastpage),
                ],
              'products'=>$products ,
              'searchView'=>$searchview,
              'searchQuery'=>$request->getParam('q')
            ]);

    }
}

