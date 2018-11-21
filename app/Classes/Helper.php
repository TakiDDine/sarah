<?php 

namespace App\Classes;

defined('BASEPATH') OR exit('No direct script access allowed');

class Helper {
    
    /*
    *  Check Email is Valid
    */
    public function valid_email($email) {
        return !!filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    

    
    
    
    
    
}