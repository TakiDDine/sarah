<?php

namespace App\Controllers\website;

use App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Classes\files;
use \App\Models\Emails;
use \App\Models\User;


class AuthController extends \App\Controllers\Controller{
    
    public function login_get($request,$response) {
        if(isset($_SESSION['auth-user'])){
            return $response->withRedirect($this->container->router->pathFor('website.home'));
        }
       return $this->container->view->render($response,'website/login.twig');
    }
    
  
    public function account($request,$response) {
        return $this->container->view->render($response,'website/account.twig');
    }
    
    
    
    
    
    public function login_post($request,$response) {
       
        $name       = clean($request->getParam('first_name'));
        $email      = clean($request->getParam('last_name'));
        $phone      = clean($request->getParam('email'));
        $body       = clean($request->getParam('password'));

        Emails::create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'body' => $body
        ]);
        
        $this->flash->addMessage('success','your message sent seccussfuly');
        return $response->withRedirect($this->router->pathFor('website.contact'));
        
    }
    
    
    public function register($request,$response) {
        
        
        
        if($request->getMethod() == 'GET'){
            if(isset($_SESSION['auth-user'])){
                return $response->withRedirect($this->container->router->pathFor('website.home'));
            }
            return $this->container->view->render($response,'website/register.twig');
        }
        
        if($request->getMethod() == 'POST'){
        

            $first_name     = clean($request->getParam('first_name'));
            $last_name      = clean($request->getParam('last_name'));
            $email          = clean($request->getParam('email'));
            $password       = clean($request->getParam('password'));

             // Check if the informations are not empty
             if(
                 empty($first_name) 
                 or empty($last_name) 
                 or empty($email) 
                 or empty($password) 
               ) {

                // the Imporant Fields are empty
                $this->flash->addMessage('error','Please Fill All the required Fileds');
                return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('website.register'));
             }


            $full_name = $first_name.' '.$last_name;
            $username = string_To_Uri($full_name);
            $password = password_hash($password,PASSWORD_DEFAULT);

            $user = User::create([
                'username' => $username,
                'full_name' => $full_name,
                'email' => $email,
                'password' => $password,
                'role' => '1',
                'statue' => '1'
            ]);

            $_SESSION['auth-user'] = $user->id;

            return $response->withRedirect($this->router->pathFor('website.home'));
        
        }
        
        
    }
    
    
    public function resetPassword($request,$response) {
        
            if($request->getMethod() == 'GET'){ 
                 if(isset($_SESSION['auth-user'])){
                     return $response->withRedirect($this->container->router->pathFor('website.home'));
                 }
                return $this->container->view->render($response,'website/reset.twig');
            }
        
            if($request->getMethod() == 'POST'){ 
            
                    // Get the Email & Clean it 
                    $email = clean($request->getParam('email'));
                    
                    // Check if it is a real Email
                    if(!empty($email) and $this->helper->valid_email($email)){
                        
                        // Check if the email exist
                        $recover = $this->auth->recover($email);
                        
                        if($recover) {
                            
                            $date = date("Y-m-d H:i:s");
                                     
                            //Convert the variable date using strtotime and 30 minutes
                            $add_min = date("Y-m-d H:i:s", strtotime($date . "+30 minutes"));
                            $date . "<br />"; //current date or whatever date you want to put in here
                            $add_min; //add 30 minutes  

                            // Create the Time and Token in Database .
                            $recover->retrieve_expiration = $add_min;
                            $recover->retrieve_token = password_hash($add_min,PASSWORD_DEFAULT);
                            $recover->save();                            
                            
                            // Send Recover Password Email .
                            $baseUrl = $this->container->conf['url.base'].$this->container->router->pathFor('website.resetpassword');
                            $recover_link  = $baseUrl."?token=$recover->retrieve_token";
                            
                            
                            $this->Emailer->to = $recover->email;
                            $this->Emailer->username = $recover->username;
                            $this->Emailer->recover_link = $recover_link;
                            $this->Emailer->Recover_Password_Email;                             
                            
                            // ارسال كلمة المرور
                            $this->flash->addMessage('success','تم ارسال كلمة المرور بنجاح');
                            return $response->withRedirect($this->router->pathFor('website.reset'));

                        }
                        
                    }
                
                    else {
                        // المعلومات خاطئة
                        $this->flash->addMessage('error','المعلومات خاطئة');
                        return $response->withRedirect($this->router->pathFor('website.reset'));
                    }
                    
            }
    }
    
    public function resetForm($request,$response) {
        
        
        
    // Show the Reset Password Page   
    if($request->getMethod() == 'GET'){ 
        return $this->container->view->render($response,'website/resetpassword.twig',['reset_token'=>$_GET['token']]);
    }
        
         
    // Check the Password, and Reset the Password to new one !
    if($request->getMethod() == 'POST'){ 
        
       // Clean the inputs first!
       $password            =  clean($request->getParam('password'));
       $confirmPassword     =  clean($request->getParam('confirmPassword')); 
       $token               =  clean($request->getParam('reset_token')); 
        
        if(empty($token)){
           $this->flash->addMessage('email_list_error', 'عفواً ، الرابط الذي تم تتبعه لا يعمل أو منتهي الصلاحية');
           return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('website.home')); 
        }
        
        // Get the user
        $user = User::where('retrieve_token','=',$token)->first();
        
        // check if the link is sent before 30 min
        $expiration = strtotime($user->retrieve_expiration);
        $now = strtotime(date("Y-m-d H:i:s"));  
         if($now>$expiration) {
             $this->flash->addMessage('email_list_error', 'عفواً ، الرابط الذي تم تتبعه لا يعمل أو منتهي الصلاحية');
             return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('website.home')); 
         }
        
        
        // التأكد من أن الحقول غير فارغة
        if(empty($password) or empty($confirmPassword) ){
            $this->flash->addMessage('error','المرجوا ادخال كلمة المرور واعادة تأكيدها');
            return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('website.resetpassword'),['reset_token'=>$token]);
        }

        if(!empty($password) or !empty($confirmPassword)) {
            
            // اذا كانت كلمات المرور غير متطابقة
           if($password != $confirmPassword){
              $this->flash->addMessage('error','كلمات المرور غير متطابقة المرجو المحاولة من جديد');
                return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('website.resetpassword'),['reset_token'=>$token]);       
           }
            
           //  اذا كانت كلمات المرور متطابقة
           if($password == $confirmPassword){ 

                // hash tha password .
                $password = password_hash($password,PASSWORD_DEFAULT);    
                
                $user->retrieve_expiration =  " ";
                $user->retrieve_token =  " ";
                $user->password = $password;
                $user->save();
                $this->flash->addMessage('email_list', 'تم تغيير كلمة المرور بنجاح');
                return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('website.home')); 

            }
            
        }
        
       
    }    
        
    }
    
    
}