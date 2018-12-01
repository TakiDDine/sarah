<?php 

namespace App\Classes;

defined('BASEPATH') OR exit('No direct script access allowed');

class Helper {
    
    
    /*
    *  Check Email is Valid
    */
    public function valid_email($email){
        
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
    public function get_ip_address(){ 
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
    
    
    /*
    *    Clean the Inputs
    */
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
    
    
    /*
    *    Check if a variable is only numbers and letters
    */
    public function is_alphanumeric ($input){
        if(!preg_match('/^[a-zA-Z]+[a-zA-Z0-9._]+$/', $input)) {
            return true; 
        }else {
            return false;
        }
    }
    
    /*
    *    Check if is a string is small
    */
    public function is_small ($input){
        if(strlen($input)< 3) {
            return false;
        } else {
            return true;
        }
    }   
    
    /*
    *   check a url if it is gravatar
    */
    public function is_gravatar($url){
        if ( false!==stripos($url, 'gravatar') ) {
            return true;
        }
        return false;
    } 
    
    /*
    *    check if a string is an email
    */
    public function is_Email($input){
       if(!filter_var($input, FILTER_VALIDATE_EMAIL)) {
            return true; 
        }else {
            return false;
        }
    }  
    
    
    /*
    *   is unique
    */
    public function is_Unique ($field,$table,$value) {
        $result = $this->container->db->table($table)->where($field, $value)->value($field);
        if($result) {
            return false;
        } else {
            return true;
        }
    }
    
    
    /*
    *   Get time of now  year-month-day Hour:minutes:seconds
    *   Return time
    */
    public function get_Time_Now(){
        $now = new \DateTime();
        return $now->format('Y-m-d H:i:s');
    }
    
    /*
    *   example : contact us page --to--> contact-us-page
    *   remove all whitespace and replace with -
    *   Return srting 
    */
    public function string_To_Uri($string){
      return  preg_replace('/\s+/', '-', $string);
    }
    
    
    /*
    *    Count the words of a string
    */
    public function count_words($word){
        return str_word_count($word);
    }
    
    
    public function is_slug ($input){
        if(!preg_match('/^[a-zA-Z]+[a-zA-Z0-9._-]+$/', $input)) {
            return true; 
        }else {
            return false;
        }
    }
    
    
    /*
    *   Deleting all files ( and the hidden files also) from a folder   
    */
    public function delete_folders_files($path){
        $path = rtrim($path, '/').'/{,.}*';
        $files = glob($path, GLOB_BRACE); // get all file names
        foreach($files as $file){ // iterate files
          if(is_file($file))
            unlink($file); // delete file
        }
    }
    
    
    /*
    *     Get the current page url
    */
    public function get_page_url(){
      return sprintf(
        "%s://%s%s",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME'],
        $_SERVER['REQUEST_URI']
      );
    }
    
    
  /*
    *   Function to Get Snippet from a string , 
    *   @str = the text you want to get snippet from
    *   @$wordCount = the number of words 
    *   usage example get_snippet($text,15,' [...] ');
    */
    public function get_snippet( $str, $wordCount = 10 , $car = ' ' ) {
        $text = implode( 
        '', 
            array_slice( 
              preg_split(
                '/([\s,\.;\?\!]+)/', 
                $str, 
                $wordCount*2+1, 
                PREG_SPLIT_DELIM_CAPTURE
              ),
              0,
              $wordCount*2-1
            )
        );
        
        return $text.$car;
    }
    
    /*
    *    Check if a string is empty
    */ 
    public function is_empty($string){
        if(empty($string)){
            return true;
        }else {
            return false;
        }
    }
    
    
}