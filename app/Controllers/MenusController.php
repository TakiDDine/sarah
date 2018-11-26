<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Models\Menus;
use \App\Classes\files;

defined('BASEPATH') OR exit('No direct script access allowed');

class MenusController extends Controller {
    
    public function index($request,$response) {
        
            $menus = Menus::all();
            $pages = $this->db->table('pages')->take(7)->get()->toArray();
            $posts = $this->db->table('posts')->take(7)->get()->toArray();
            $menu = $menus->first()->toArray();
        
            return $this->container->view->render($response,'admin/menus/index.twig',[
                'menus'=>$menus,
                'menu'=>$menu,
                'htmlMenu' => json_decode($menu['menu'], TRUE),
                'pages'=>$pages,
                'posts'=>$posts
            ]); 
    }
    
  
    public function create ($request,$response) {
          
        
        $name = clean($request->getParam('name'));
        
        if(!empty($name)){
           $menu = Menus::create([
             'name' => clean($request->getParam('name'))
            ]); 
            $this->flash->addMessage('success','تم اضافة القائمة بنجاح');
            return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('menus.edit',['id'=>$menu->id]));
        }
        
        $this->flash->addMessage('error','لا يمكن ترك اسم القائمة فارغاً');
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('menus'));
        
    }
    
    public function edit ($request,$response,$args) {
        
        // Get  
        $id = rtrim($args['id'], '/');
        $menu = Menus::find($id);
        $menus = Menus::all();
        $pages = $this->db->table('pages')->take(7)->get()->toArray();
        $posts = $this->db->table('posts')->take(7)->get()->toArray();
        
        
        if($request->getMethod() == 'GET'){ 
           return $this->container->view->render($response,'admin/menus/index.twig',[
                'menus'=>$menus,
                'menu'=>$menu,
                'htmlMenu' => json_decode($menu['menu'], TRUE),
                'pages'=>$pages,
                'posts'=>$posts
            ]); 
        }
        
        
        if($request->getMethod() == 'POST'){ 
            
            
            $menu->name =  $request->getParam('menu_name');
            $decodedmenu = json_decode($request->getParam('menu_json'), TRUE);
            $menu->area = $request->getParam('area');
            
            // change the all the ids of the menu items, when saving , and delete new-1 
            $i = 0;  
            $c = 1000;
            
            for($x=0;$x<count($decodedmenu);$x++):
                  $decodedmenu[$x]['id'] = $i ;
            
   
                  if(isset($decodedmenu[$x]['children'])){
                        for($v=0;$v<count($decodedmenu[$x]['children']);$v++):
                            $decodedmenu[$x]['children'][$v]['id'] = $c;
                            $c++;
                         endfor;
                    }
                $i++; 
            endfor;

            $menu->menu = json_encode( $decodedmenu , JSON_UNESCAPED_UNICODE );
             
             // saving the menu
             $menu->save();  
            
            $this->flash->addMessage('success','تم تعديل القائمة بنجاح');
            return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('menus.edit',['id'=>$id]));

        }
    }   
    
    
    public function delete($request,$response,$args) {
        $id = rtrim($args['id'], '/');
        $menu = Menus::find($id);
        $menu->delete();
        $this->flash->addMessage('success','تم حذف القائمة بنجاح');
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('menus'));
    } 
    
    
    public function blukdelete($request,$response){
        Menus::truncate();
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('menus'));
    }
    
    
}

