<?php 

namespace App\Classes;

defined('BASEPATH') OR exit('No direct script access allowed');

class validator { 
    
   
    
    public function clean($data) {
        // Strip HTML Tags
        $clear = strip_tags($data);
        // Clean up things like &amp;
        $clear = html_entity_decode($clear);
        // Strip out any url-encoded stuff
        $clear = urldecode($clear);
        // Replace Multiple spaces with single space
        $clear = preg_replace('/ +/', ' ', $clear);
        // Trim the string of leading/trailing space
        $clear = trim($clear);
        return $clear;
    }
    
    
    
    public function is_alphanumeric ($input){
        if(!preg_match('/^[a-zA-Z]+[a-zA-Z0-9._]+$/', $input)) {
            return true; 
        }else {
            return false;
        }
    }
    
    public function is_Email($input){
       if(!filter_var($input, FILTER_VALIDATE_EMAIL)) {
            return true; 
        }else {
            return false;
        }
    }  
    
    
    public function is_url($url){
        if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
            return false;
        }
        return true;
    }
    
    public function is_gravatar($url){
        if ( false!==stripos($url, 'gravatar') ) {
            return true;
        }
        return false;
    } 
    
    
    

    
    
    

    public function Is_small ($input,$message){
        if(strlen($input)< 3) {
            echo $message;
            exit();
        } else {
            return true;
        }
    }        


    public function isConfirmed($field1,$field2) {
       if( $field1 === $field2 ){
           return true;
       }else {
           return false;
       }
    }


    // Check for Forbidden usernames
    function forbiddenUsername($nameForbidden) {
        $forbiddenNames = array("God", "admin", "root");
        // هذه الدالة تقوم بتحويل البحث داخل المصفوفة بدون البحث المطابق لشكل الحروف case sensitive
        if(array_search(strtolower($nameForbidden), array_map('strtolower', $forbiddenNames))) {
            return true;
        }
    }

    // check for Forbidden Emails !
    function bannedemails ($check_my_email) {
        global $bannedEmailArray;
        $email_host = explode("@",$check_my_email);
        $to_check = $email_host['1'];
        $BannedEmails = $bannedEmailArray;
        if(in_array($to_check,$BannedEmails)) {
            return true ;
        }
        // How To use  --> if(bannedemails ("takiddine.job@gmail.com") == true){ // your code here}
    }




    
    
    
    
    
    

    
    public function generate_date() {
        return date("l/d/m/Y - h:i:s") ;
    }
    
    public function check_rest_id_token($id,$token) { 
        
    $id = $this->clean($id);
    $token = $this->clean($token);

    $db = app::getDatabase();      
    $sql = "select * from users where id = ? and reset_token = ? and reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE) ";
    $user = $db->query($sql,[$id,$token])->fetch();
        
        if($user) {  
            return true;
        }else {
            return false;
        }
        
    }
  
    


}




