<?php

namespace App\Auth;
use App\Models\User;
use App\Classes\Helper;

class Auth {
        
    public function attempt($email,$password,$type) {
        $user = User::where('email','=',$email)->orWhere('username','=',$email)->first();
        
        if($type == 'user'){
            

            if(password_verify($password,$user->password)) {
                    session_start();
                    $_SESSION['auth-user'] = $user->id;
                    return true;
            } 
        }
        if($type == 'admin'){
     
            if($user){
                if($user->role != '2' and $user->statue != '3') {
                    return false;
                }
                if(password_verify($password,$user->password)) {
                    $_SESSION['auth-admin'] = $user->id;
                    return true;
                } 
            }
        }
        
        return false;
    }
    
    public function recover($email){
        $user = User::where('email','=',$email)->first();
        if($user){
            return $user;
        }
        return false;
    }
    
    public function register(){
        
    }
    
    public function username_exists($username){
        $user = User::where('username','=',$username)->first();
        if($user){
            return $user;
        }
        return false;
    }
    
    public function email_exists($email){
        $user = User::where('email','=',$email)->first();
        if($user){
            return $user;
        }
        return false;        
    }
    
    public function avatar_defaults(){
        
        
        



    }
    
    
    
    
    public function validate_username(){
        
    }
    
    
}