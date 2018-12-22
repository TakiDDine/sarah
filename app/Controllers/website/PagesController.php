<?php

namespace App\Controllers\website;

use App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Models\Page;
use \App\Controllers\Controller as controller;


class PagesController extends Controller{

    public function page($request,$response,$args) {
       $id = rtrim($args['id'], '/');
       $page = Page::find($id)->toArray();
       return $this->container->view->render($response,'website/article.twig',compact('page'));
    }
 
}