<?php 

namespace App\Classes;

defined('BASEPATH') OR exit('No direct script access allowed');

class Helper {
    
    
    /*
    *  Check Email is Valid
    */
    public static function valid_email($email){
        
        // Check if is it a real email
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return false;
        }
        
        // check if is not from banned list
        $file = INC_ROOT.'/app/Libraries/domains.json';
        
        // Check if File Exists
        if(file_exists($file)){
            $bannedEmails = json_decode(file_get_contents());
            if (in_array(strtolower(explode('@', $email)[1]), $bannedEmails)) {
                return false;
            }
        }
        return true;
    }
    
    
    
    
}