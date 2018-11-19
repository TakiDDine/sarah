<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use \App\Email\Email;
use \App\Models\User;
use \App\Classes\App;

defined('BASEPATH') OR exit('No direct script access allowed');

class AuthController extends Controller {
    
    public function getLogin($request,$response) {
       return $this->container->view->render($response,'admin/auth/login.twig');
    } 
    public function postLogin($request,$response) {
        
        $login_form = $request->getParam('validate');
        if($login_form == 'customer_login'){
                $auth = $this->container->auth->attempt(
                    clean($request->getParam('user_login')),
                    clean($request->getParam('pass_login')),
                    'user'
                );
                if($auth) {
                    return $response->withRedirect($this->container->router->pathFor('website.home'));
                }else {
                    $this->flash->addMessage('error','المعلومات غير صحيحة');
                    return $response->withRedirect($this->container->router->pathFor('website.login'));
                } 
        }
        
        
        
        
        
        $auth = $this->container->auth->attempt(
            clean($request->getParam('user_login')),
            clean($request->getParam('pass_login')),
            'admin'
        );
        if($auth) {
            return $response->withRedirect($this->container->router->pathFor('admin.index'));
        }else {
            $this->flash->addMessage('error','المعلومات غير صحيحة');
            return $response->withRedirect($this->container->router->pathFor('login'));
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
        $validator = $this->validator;
      
    
        
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
                    $baseUrl = $this->conf['app.url'].$this->container->router->pathFor('resetPassword');
                    $recover_link  = $baseUrl."?token=$recover->retrieve_token";
                    $this->Emailer->to = $recover->email;
                    $this->Emailer->username = $recover->username;
                    $this->Emailer->recover_link = $recover_link;
                    $this->Emailer->Recover_Password_Email;  
                    
                }

            }
            
            $validator->flash('اذا كان البريد الإلكتروني الذي أدخلته مسجل عندنا ستصلك رسالة في بريدك ، شكرا لك');
        }
        
        
        
        if(!isset($_SESSION['flash'])) { $flash = ' ';} else {   $flash = $_SESSION['flash']; }
        return $this->container->view->render($response,'admin/auth/recover.twig',['flash'=>$flash]);

    }
    
    public function register($request,$response) { 
        
        
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

