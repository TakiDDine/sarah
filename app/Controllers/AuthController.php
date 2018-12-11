<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Email\Email;
use \App\Models\User;
use \App\Classes\App;

defined('BASEPATH') OR exit('No direct script access allowed');

class AuthController extends Controller {
    
    
    
    public function getLogin($request,$response) {
        
        if(isset($_SESSION['auth-user'])){
            return $response->withRedirect($this->container->router->pathFor('website.home'));
        }
        
        
       return $this->container->view->render($response,'admin/auth/login.twig');
    } 
    
    
    public function login($request,$response) {
        
        
        $helper = $this->helper;
        $post = $helper->cleanData($request->getParams());
        
        $mode = $this->container->conf['app.debug'];
        
        // get the login credentials
        $user = $post['user_login'];
        $pass = $post['pass_login'];
        $form = $post['validate'];
        
        
        // Limit The login after 3 times to attempt
        if($mode == false){
//            // get the quest ip
//            $ip = $helper->get_ip_address();
//            
//            // save the ip
//            $this->db->table('ip')->insert(['address'=>$ip]);
//            
//            // check if the login was before 10 min
//            $count = $this->db->query("SELECT COUNT(*) FROM `ip` WHERE `address` LIKE '$ip' AND `timestamp` > (now() - interval 10 minute)");
//            
//            if($count[0] > 3){
//              echo "Your are allowed 3 attempts in 10 minutes";
//            }
            
        }
        
        // Customer login
        if($form == 'customer_login'){
            
            // do the authentication
            $auth = $this->auth->attempt($user,$pass, 'user');
            
            if($auth) {
                return $response->withRedirect($this->container->router->pathFor('website.home'));
            }else {
                $this->flasherror('المعلومات غير صحيحة');
                return $response->withRedirect($this->container->router->pathFor('website.login'));
            }
        }
        
        
        // admin login
        $auth = $this->auth->attempt($user,$pass, 'admin');
        
        if($auth) {
            return $response->withRedirect($this->container->router->pathFor('admin.index'));
        }else {
            $this->flasherror('المعلومات غير صحيحة');
            return $response->withRedirect($this->container->router->pathFor('admin.index'));
        }
        
        
    }
    
    public function logout($request,$response) {
        unset($_SESSION['auth-admin']);
        return $response->withRedirect($this->container->router->pathFor('admin.index'));
    }
    public function logout_user($request,$response) {
        unset($_SESSION['auth-user']);
        return $response->withRedirect($this->container->router->pathFor('website.home'));
    }
    
    public function rested($request,$response) {
        return $response->withRedirect($this->container->router->pathFor('rested'));
    }
    
    
    public function recover($request,$response) {
        
        if($request->getMethod() == 'GET'){
            return $this->container->view->render($response,'admin/auth/recover.twig'); 
        }
        
        if($request->getMethod() == 'POST'){

            $email = $request->getParam('email');
            if(isset($email) and !empty($email)) {
                
                $recover = $this->auth->recover($email);
                
                if($recover) {
                 
                    $date = date("Y-m-d H:i:s");

                    //Convert the variable date using strtotime and 30 minutes then format it again on the desired date format
                    $add_min = date("Y-m-d H:i:s", strtotime($date . "+30 minutes"));
                    $date . "<br />"; //current date or whatever date you want to put in here
                    $add_min; //add 30 minutes  
                    
                    
                    // Create the Time and Token in Database .
                    $recover->retrieve_expiration = $add_min;
                    $recover->retrieve_token = password_hash($add_min,PASSWORD_DEFAULT);
                    $recover->save();
                    
                    
                    
                    // Send Recover Password Email .
                    $baseUrl = $this->conf['url.base'].$this->container->router->pathFor('resetPassword');
                    $recover_link  = $baseUrl."?token=$recover->retrieve_token";
                    $this->Emailer->to = $recover->email;
                    $this->Emailer->username = $recover->username;
                    $this->Emailer->recover_link = $recover_link;
                    $this->Emailer->Recover_Password_Email;  
                    
                }
            }
            
            $this->flashsuccess('اذا كان البريد الإلكتروني الذي أدخلته مسجل عندنا ستصلك رسالة في بريدك ، شكرا لك');
            return $response->withRedirect($this->router->pathFor('admin.index'));
        }
    }
    
   
    public function resetPasswordGet($request,$response) { 
        
        // fisrt of all do not forget to clean the input before insert in database or check !
        
        if(!isset($_GET['token'])){
            $this->flash->addMessage('error', 'عفواً ، هذا الرابط منتهى الصلاحية');
            return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('home'));
        }else {
            
          $user = User::where('retrieve_token','=',$_GET['token'])->first();  
            
            if($user){
                
                // check if the link is sent before 30 min
            $expiration = strtotime($user->retrieve_expiration);
            $now = strtotime(date("Y-m-d H:i:s"));  
             if($now<$expiration) {
                 
                 
                return $this->container->view->render($response,'admin/auth/password.reset.twig',['reset_token'=>$_GET['token']]); 
             }else{
                $this->flash->addMessage('error', 'عفواً ، هذا الرابط منتهى الصلاحية');
                return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('home')); 
             }
            
                
            }else {

                $this->flash->addMessage('error', 'عفواً ، هذا الرابط منتهى الصلاحية');
                return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('home'));
            }
            
            
             
        }
    }
    
    
    public function resetPasswordPost($request,$response) { 

        
       $validator = $this->validator;

        
        
        // Clean the inputs first!
       $password            =  clean($request->getParam('password'));
       $confirmPassword     =  clean($request->getParam('confirmPassword')); 
       $token               =  clean($request->getParam('reset_token')); 
        

        // التأكد من أن الحقول غير فارغة
        if(empty($password) or empty($confirmPassword) ){

            $validator->flash('المرجوا ادخال كلمة المرور واعادة تأكيدها', 'error');

            if(empty($flash)) { $flash = ' ';} else {   $flash = $_SESSION['flash']; }
            return $this->container->view->render($response,'admin/auth/password.reset.twig',['flash'=>$flash,'reset_token'=>$token]);    
        }

        
       // اذا كانت كلمات المرور غير متطابقة
       if($password != $confirmPassword){

            $validator->flash('كلمات المرور غير متطابقة المرجو المحاولة من جديد', 'error');

            if(!isset($_SESSION['flash'])) { $flash = ' ';} else {   $flash = $_SESSION['flash']; }
            return $this->container->view->render($response,'admin/auth/password.reset.twig',['flash'=>$flash,'reset_token'=>$token]); 
       }
        
        
       //  اذا كانت كلمات المرور متطابقة
       if($password == $confirmPassword){ 

            // hash tha password .
            $password = password_hash($password,PASSWORD_DEFAULT);    
            $user = User::where('retrieve_token','=',$token)->first();
            $user->retrieve_expiration =  " ";
            $user->retrieve_token =  " ";
            $user->password = $password;
            $user->save();
            return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('rested')); 
            
        }

    }
    
}

