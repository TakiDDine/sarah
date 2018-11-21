<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Classes\Helper;


defined('BASEPATH') OR exit('No direct script access allowed');

class MailListsController extends Controller {
    
    public function index($request,$response) {
        $mailist = $this->db->table('mail_list')->get()->toArray();
        return $this->container->view->render($response,'admin/statiquePages/mail_list.twig',['mailist'=>$mailist]); 
    }
    
    public function add($request,$response) {
        
        // Get the Email & Clean it 
        $email = clean($request->getParam('email'));
                       
        // Check if is it a real Email
        if($this->helper->valid_email($email)){
            
            // insert the email to database.
            $this->db->table('mail_list')->insert(['email'=>$email]);
            
            // Flash Success & Redirect
            $this->flash->addMessage('email_list','تم الإشتراك في القائمة البريدية بنجاح');
            return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('website.home'));
            
        }
        
        else {
            // Flash Error & Redirect
            $this->flash->addMessage('email_list_error','الإميل الذي تم ادخاله خاطئ المرجوا التأكد منه والمحاولة من جديد');
            return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('website.home'));
            
        }
    }
   
    public function blukdelete($request,$response){
        Comments::truncate();
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('comments'));
    }       
    
   
}

