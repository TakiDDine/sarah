<?php

namespace App\Auth;
use App\Models\User;
use App\Classes\Helper;

class Auth {
        
    
        /**
    * Return the logged in user.
    * @return user array data
    */
    public function getUser(){
        return $this->user;
    }

    
       /**
    * Email the confirmation code function
    * @param string $email User email.
    * @return boolean of success.
    */ 
  private function sendConfirmationEmail($email){
       
    }

     /**
    * Assign a role function
    * @param int $id User id.
    * @param int $role User role.
    * @return boolean of success.
    */
      public function assignRole($id,$role){
     
    }

        /**
    * Check if email is already used function
    * @param string $email User email.
    * @return boolean of success.
    */
    private function checkEmail($email){
       
    }
    
    /**
    * Register a wrong login attemp function
    * @param string $email User email.
    * @return void.
    */
    private function registerWrongLoginAttemp($email){
        $pdo = $this->pdo;
        $stmt = $pdo->prepare('UPDATE users SET wrong_logins = wrong_logins + 1 WHERE email = ?');
        $stmt->execute([$email]);
    }    
    
    /**
    * Logout the user and remove it from the session.
    *
    * @return true
    */
    public function logout() {
        $_SESSION['user'] = null;
        session_regenerate_id();
        return true;
    }
    
    
    
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