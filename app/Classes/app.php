<?php


namespace App\Classes;

defined('BASEPATH') OR exit('No direct script access allowed');

class app {
    
    public static function start_session(){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /*
    *    Create a Random String
    */
    public static function str_random($length = 20) {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }
    
    /*
    *    Debuging
    */
    public static function dd($variable){
        if(isset($variable)) {            
            echo '<pre dir="ltr">';
            print_r($variable);
            echo '</pre>';
        }else {
            echo ' ';
        }
    }
    
  
    
    
    
    
    

}