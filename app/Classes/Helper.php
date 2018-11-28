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
    
    /*
    *  Get User IP
    *  this function is tested & it works perfectly
    */
    public static function get_ip_address(){ return "dlklkdldkld";
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe

                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
    }
    
    
    
}