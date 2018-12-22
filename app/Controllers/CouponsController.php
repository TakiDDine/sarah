<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Models\Coupons;
use \App\Classes\files;

defined('BASEPATH') OR exit('No direct script access allowed');

class CouponsController extends Controller {
    
            // index Page, Get all ads
    public function index($request,$response) {
        $r = $this->paginate('Coupons',$request);
        return $this->view->render($response, 'admin/coupons/index.twig', ['users'=>$r[0],'p'=>$r[1]]);    
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

