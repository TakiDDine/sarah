<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Models\Coupons;
use \App\Classes\files;

defined('BASEPATH') OR exit('No direct script access allowed');

class EmailController extends Controller {
    
        public function index($request,$response) {
            $inbox = $this->db->table('inbox')->get();
            return $this->view->render($response, 'admin/inbox/index.twig',compact('inbox'));
        }
    

        public function create($request,$response) {

            if($request->getMethod() == 'GET'){
                return $this->container->view->render($response,'admin/inbox/create.twig');
            }
            
            if($request->getMethod() == 'POST'){
             
                $helper = $this->helper;
                $post = $helper->cleanData($request->getParams());
             
                $this->db->table('inbox')->insert([
                    'reciever_email'    => $post['reciever_email'],
                    'subject'           => $post['subject'] ,
                    'body'              => $post['body']
                ]);
                
                 
                // Send the Email
                $url = 'https://api.elasticemail.com/v2/email/send';
                try{
                        $post = array('from' => 'caynoon.job@gmail.com',
                        'fromName' => 'اسم الموقع',
                        'apikey' => '7374d8f3-d40d-4f08-9e2e-b8fcbedd5a0f',
                        'subject' => $subject,
                        'to' => $reciever,
                        'bodyHtml' => $body,
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
                
               $this->flashsuccess('تم ارسال الإميل بنجاح');
               return $response->withRedirect($this->router->pathFor('inbox'));
                
                 
            
            }
            

        }

        public function edit($request,$response,$args) {
            
            $id = rtrim($args['id'], '/');
            $email  = $this->db->table('inbox')->find($id);
            if($email) {
                return $this->view->render($response, 'admin/inbox/edit.twig', ['email'=>$email ]);
            }
                
        }

        public function delete($request,$response,$args) {
            $id = rtrim($args['id'], '/');
            $email  = $this->db->table('inbox');
            if($email){ $email->delete($id); }
            $this->flashsuccess('تم حذف الإميل بنجاح');
            return $response->withRedirect($this->router->pathFor('inbox'));
        }

        public function blukdelete($request,$response){
            $this->db->table('inbox')->get()->delete();
            $this->flashsuccess( 'تم حذف كل الإميلات بنجاح');
            return $response->withRedirect($this->router->pathFor('inbox'));
        }

}

