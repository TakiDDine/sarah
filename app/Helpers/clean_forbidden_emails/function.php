<?php 

    /**
    ** 		MADE BY : soulaimane takiddine 
    ** 		EMAIL : takiddine.job@gmail.com
    **/ 

    function Is_Email_forbidden ($myemail) {

        // GET THE LIST OF FORBIDDEN EMAILS .
        $forbidden_emails_array = json_decode(file_get_contents('domains.json'));

        // IXPLODE EMAIL DOMAIN .
        $email_domain = explode('@',$myemail);
        $check_me = $email_domain[1];

        // CHEKING IF MY EMAIL IS FORBIDDEN
        if(in_array($check_me,$forbidden_emails_array)) {
            return true ;
        }else {
            return false;
        }
        
    }
    
    /**
    ** 		how to use :
    **		if(	Is_Email_forbidden ('takiddine.job@yopmail.com') == true )	{ // execute here }
    ** 		
    **/ 
    
    

?>