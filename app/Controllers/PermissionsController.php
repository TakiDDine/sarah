<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


defined('BASEPATH') OR exit('No direct script access allowed');

class PermissionsController extends Controller {
    
    
    public function index($request,$response) {
        $permissions = $this->db->table('permissions')->get();
        return $this->view->render($response, 'admin/permissions/index.twig', ['permissions'=>$permissions ]);
    }
 
    
    public function create($request,$response) {
        
        // get the roule name
        $name = $this->helper->clean($request->getParam('name'));
        $route = $response->withRedirect($this->router->pathFor('permissions'));        
        
        // check if the name is not empty
        if(empty($name)){ $this->flasherror('المرجوا ادخال اسم المجموعة أولا'); return $route; }
        
        // adding the permission to database
        $this->db->table('permissions')->insert([ 'name'=>$name ]);
                
        // flash success & redirect to permissions page
        $this->flashsuccess('تم اضافة المجموعة بنجاح'); return $route;       
       
    }
    
    public function edit($request,$response,$args) {
        
        // get the id
        $id = rtrim($args['id'], '/');
        
        // connect to the permissions table
        $table = $this->db->table('permissions');
        
        // get the permission
        $permission = $table->find($id);
        
        // showing the edit page if the permission exist , otherwise redirect to the main permissions page
        if($request->getMethod() == 'GET'){      
            if($permission) {
                return $this->view->render($response,'admin/permissions/edit.twig',['permission'=>$permission]);
            }
            return $response->withRedirect($this->router->pathFor('permissions'));
        }
        
        
        // when the form is submitted
        if($request->getMethod() == 'POST'){
            
            // initlize the form & helper
            $post = $request->getParams();
            $helper = $this->helper;
            
            // clean 
            $name = $helper->clean($post['name']);
            $permissions = $post['permissions'];
            
            // update 
            $permission->name = $name;
            $permission->permissions = $permissions;
            $permission->save();
            
            $this->flashsuccess('تم تعديل المجموعة بنجاح');
            return $response->withRedirect($this->router->pathFor('permissions'));
            
        }
        
        
    }
    
    // Delete the permission 
    public function delete($request,$response,$args) {
        $id = rtrim($args['id'], '/');
        $role  = $this->db->table('permissions');
        if($role){ $role->delete($id); }
        $this->flashsuccess('تم حذف المجموعة بنجاح');
        return $response->withRedirect($this->router->pathFor('permissions'));
    }
    
    // delete all the permissions
    public function blukdelete($request,$response){
        $this->db->table('permissions')->truncate();
        $this->flashsuccess( 'تم حذف كل المجموعات بنجاح');
        return $response->withRedirect($this->router->pathFor('permissions'));
    }
   
}

