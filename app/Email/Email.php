<?php

namespace App\Email;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

defined('BASEPATH') OR exit('No direct script access allowed');


class Email {
    
    private $container;
    public  $to;
    public  $username;
    private $subject;
    private $message;
    private $site_name;
    public $recover_link;

    public function __get($name){
       if($this->$name()) {
        return $this->$name();
       }
    }
    
    
    
    
    public function __construct($container){
        $this->container = $container;
    }

    
    private function sendEmail(){
        
        $url = 'https://api.elasticemail.com/v2/email/send';
        try{
                $post = array('from' => 'takiddine.job@gmail.com',
                'fromName' => 'اسم الموقع',
                'apikey' => '7374d8f3-d40d-4f08-9e2e-b8fcbedd5a0f',
                'subject' => $this->subject,
                'to' => $this->to,
                'bodyHtml' => $this->message,
                'isTransactional' => false);

                $ch = curl_init();
                curl_setopt_array($ch, array(
                    CURLOPT_URL => $url,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $post,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HEADER => false,
                    CURLOPT_SSL_VERIFYPEER => false
                ));

                $result=curl_exec ($ch);
                curl_close ($ch);
        }
        catch(Exception $ex){
            echo $ex->getMessage();
        }
    }
     
    
    public function Registration_Email (){
        $message = file_get_contents(__DIR__.'/email.html'); 
        $message = str_replace('%username%', $this->username, $message); 
        $message = str_replace('%site_name%', $this->site_name, $message);    
        $this->message = str_replace('%email%', $this->to, $message);    
        $this->subject = 'مرحبا بك في موقع TBS';
        return $this->sendEmail();
    }
    
    public function Recover_Password_Email (){
        $message = file_get_contents(__DIR__.'/recover.html'); 
        $message = str_replace('%username%', $this->username, $message); 
        $message = str_replace('%site_name%', $this->site_name, $message);    
        $message = str_replace('%recoverlink%', $this->recover_link, $message);    
        $this->message = str_replace('%email%', $this->to, $message);    
        $this->subject = 'استرجاع حسابك الإلكتروني';
        return $this->sendEmail();        
    } 
    
    public function Account_deleted_Email (){

    }
    
    
    
}