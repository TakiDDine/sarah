<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Models\Coupons;
use \App\Classes\files;

defined('BASEPATH') OR exit('No direct script access allowed');

class CouponsController extends Controller {
    
        public function index($request,$response) {
                        $count          = Coupons::count();   
                        $page           = ($request->getParam('page', 0) > 0) ? $request->getParam('page') : 1;
                        $limit          = 10; 
                        $lastpage       = (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit));    
                        $skip           = ($page - 1) * $limit;
                        $coupons          = Coupons::skip($skip)->take($limit)->orderBy('created_at', 'desc')->get();

                        return $this->view->render($response, 'admin/coupons/index.twig', [
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
                          'coupons'=>$coupons ,
                        ]);
        }

        public function create($request,$response) {

                    if($request->getMethod() == 'GET'){
                        return $this->container->view->render($response,'admin/coupons/create.twig');
                    }
        }

        public function edit($request,$response,$args) {



            }

        public function delete($request,$response,$args) {
            $Post = Page::find(rtrim($args['id'], '/'));
            unlink($this->container->conf['dir.pages'].$Post->thumbnail);
            $Post->delete();
            $this->flash->addMessage('success','تم حذف المقالة بنجاح');
            return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('pages'));
        }

        public function duplicate($request,$response,$args) {
            $product = Page::find(rtrim($args['id'], '/'));
            $new = $product->replicate();
            $new->save();
            $this->flash->addMessage('success','تم تكرار المقالة بنجاح');
            return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('pages'));
        }  

        public function blukdelete($request,$response){
            $users = Page::truncate();
            $this->flash->addMessage('success', 'تم حذف كل الصفحات بنجاح');
            return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('pages'));
        }

}

