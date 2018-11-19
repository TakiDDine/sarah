<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use \App\Email\Email;
use \App\Models\options;
use \App\Models\User;
use \App\Models\ProductCategories;
use \App\Classes\app;
use \App\Classes\files;
defined('BASEPATH') OR exit('No direct script access allowed');

class settingsController extends Controller {
    
    
    
    public function account($request,$response){
        
        $user = User::find($_SESSION['auth-admin']);
        
        if($request->getMethod() == 'GET'){
            return $this->view->render($response,'admin/settings/account.twig', ['user'=>$user]);
        }
        
        if($request->getMethod() == 'POST'){
            $form = $request->getParam('validate');
            $validator = $this->validator;
            
            
            if($form == 'validate_my_settings'){
              
                $username = $request->getParam('username');
                $email = $request->getParam('email');
                
                
                if($validator->is_empty($username)){ 
                    $this->flash->addMessage('error', 'لا يمكن ترك اسم المستخدم فارغاً');
                    return $response->withRedirect($this->router->pathFor('settings.account', ['user'=>$user ]));
                }
                if($validator->is_empty($email)){ 
                    $this->flash->addMessage('error', 'لا يمكن ترك البريد الإلكتروني فارغاً');
                    return $response->withRedirect($this->router->pathFor('settings.account', ['user'=>$user ]));
                }
                
                $user->username = $username;
                $user->email = $email;
                $user->save();
                
                $this->flash->addMessage('success','تم تحديث المعلومات بنجاح');
                return $response->withRedirect($this->router->pathFor('settings.account', ['user'=>$user ]));
            }
            
            if($form == 'validate_my_pass'){
               
                $old_pass = $request->getParam('old_pass');
                $new_pass = $request->getParam('new_pass');
                $new_pass_re = $request->getParam('new_pass_re');
                
                if(!password_verify($old_pass,$user->password)) {
                  $this->flash->addMessage('error', 'كلمة المرور الحالية التي أدخلتها خاطئة !');
                  return $response->withRedirect($this->router->pathFor('settings.account', ['user'=>$user ]));   
                }
                
                if($new_pass != $new_pass_re){
                  $this->flash->addMessage('error', 'كلمتا المرور الجديدة غير متطابقتين ، المرجوا المحاولة من جديد');
                  return $response->withRedirect($this->router->pathFor('settings.account', ['user'=>$user ]));  
                }
                
                $password = password_hash($new_pass,PASSWORD_DEFAULT);    
                
                $user->password = $password;
                $user->save();
                
                $this->flash->addMessage('success','تم تحديث كلمة المرور بنجاح');
                return $response->withRedirect($this->router->pathFor('settings.account', ['user'=>$user ]));
            }
            
            
        }
    }
    
    
    public function index($request,$response) {
        
        if($request->getMethod() == 'POST'){

        echo '<pre>';
        $request->getParams();
        exit;
        
       }
        /*
       *    تحميل نسخة من قاعدة البيانات
       */
        $download = $request->getParam('export');
        if(isset($download)){
            include_once dirname(__DIR__).'/Classes/database_exporter.php';
            $world_dumper = \Shuttle_Dumper::create(array(
                'host' => $this->conf['db.host'],
                'username' => $this->conf['db.username'],
                'password' => $this->conf['db.password'],
                'db_name' => $this->conf['db.name'],
            ));

            $file_url = 'database.sql';
            header('Content-Type: application/octet-stream');
            header("Content-Transfer-Encoding: Binary"); 
            header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\""); 
            readfile($file_url); // do the double-download-dance (dirty but worky)
            unlink($file_url);
            
       }
       return $this->view->render($response,'admin/settings/index.twig');
    } 

    public function email($request,$response) {
        $options = Options::all();
        $options = $options->pluck('name');
        $options =  array_combine($options->toArray(),$options->toArray());
        
         if($request->getMethod() == 'POST'){
             Options::update_option('SMTP_Host',$request->getParam('Host'));
             Options::update_option('SMTP_Port',$request->getParam('Port'));
             Options::update_option('SMTP_User',$request->getParam('User'));
             Options::update_option('SMTP_Password',$request->getParam('Password'));
            $this->flash->addMessage('success','تم تحديث المعلومات بنجاح');
            return $response->withRedirect($this->router->pathFor('settings/email', ['options'=>$options ]));
         }


        
        return $this->view->render($response,'admin/settings/email.twig',['options'=>$options ]);
    }
    public function links($request,$response) {
        return $this->view->render($response,'admin/settings/links.twig');
    }
    public function users($request,$response) {
        return $this->view->render($response,'admin/settings/users.twig');    
    }    
    
    public function socialGet($request,$response) {
        return $this->view->render($response,'admin/settings/social.twig');    
    }   
    public function socialPost($request,$response) {
        
        $options = Options::all();
        $options = $options->pluck('name');
        $options =  array_combine($options->toArray(),$options->toArray());
        
             Options::update_option('facebook',$request->getParam('facebook'));
             Options::update_option('twitter',$request->getParam('twitter'));
             Options::update_option('instagram',$request->getParam('instagram'));
             Options::update_option('youtube',$request->getParam('youtube'));
            $this->flash->addMessage('success','تم تحديث المعلومات بنجاح');
            return $response->withRedirect($this->router->pathFor('settings.social', ['options'=>$options ]));
    }   
    
    public function general($request,$response) {
       
        
        if(isset($_FILES['logo']) and !empty($_FILES['logo']['name'])) {
            $logo = new files();
            $logo =  $logo->upload_avatar($this->container->conf['dir.general'],$_FILES['logo']);
        }
        
        if(isset($_FILES['favicon']) and !empty($_FILES['favicon']['name'])) {
            $favicon = new files();
            $favicon =  $favicon->upload_avatar($this->container->conf['dir.general'],$_FILES['favicon']);
        }    

            
            
            
            
        
        $options = Options::all();
        $options = $options->pluck('name');
        $options =  array_combine($options->toArray(),$options->toArray());
        
        if($request->getParam('validate') == 'general_settings'){
            
            
            
             Options::update_option('favicon',$favicon);
             Options::update_option('logo',$logo); 
            
             Options::update_option('name',$request->getParam('name'));
             Options::update_option('description',$request->getParam('description'));
             Options::update_option('keywords',$request->getParam('keywords'));
             Options::update_option('mode',$request->getParam('mode'));
             Options::update_option('phone',$request->getParam('phone'));
             Options::update_option('email',$request->getParam('email'));
             Options::update_option('adress',$request->getParam('adress'));
             Options::update_option('ganalitycs',$request->getParam('ganalitycs'));
            $this->flash->addMessage('success','تم تحديث المعلومات بنجاح');
            return $response->withRedirect($this->router->pathFor('settings', ['options'=>$options ]));
        }

    }  
    
    public function home($request,$response){
        
        if($request->getMethod() == 'GET'){
            $categories     = ProductCategories::All();
            return $this->view->render($response,'admin/settings/home.twig', ['categories'=>$categories]);
        }
        
        if($request->getMethod() == 'POST'){
            $uploader = new files();
            $options = new options();    
            
            
            if(isset($_FILES) and !empty($_FILES)) {
              for($x=0;$x<7;$x++):
                  if(isset($_FILES["BLOCK_IMAGE_".$x]) and !empty($_FILES["BLOCK_IMAGE_".$x]['name'])) {  
                    $image =  $uploader->upload_avatar($this->container->conf['dir.general'],$_FILES["BLOCK_IMAGE_".$x]);
                    $options->update_option("BLOCK_IMAGE_".$x,$image);
                  }
             endfor;
            }
    
            foreach($request->getParams() as $key => $value):
            $options->update_option($key,$value);
            endforeach;
            $this->flash->addMessage('success','تم تحديث المعلومات بنجاح');
            return $response->withRedirect($this->router->pathFor('settings.home', ['options'=>$options ]));
        }
        
       
        
    }
    
    public function slider($request,$response){
        
        if($request->getMethod() == 'GET'){
            return $this->view->render($response,'admin/settings/slider.twig');
        }
        
        
       if($request->getMethod() == 'POST'){

            $files = new files();
           
            if(isset($_FILES['slidertopright']) and !empty($_FILES['slidertopright']['name'])) {
                $uploader = new files();
                $slider1 =   $uploader->upload_avatar($this->container->conf['dir.slider'],$_FILES['slidertopright']);
                Options::update_option('HOME_SLIDER_RIGHT_TOP',$slider1);
            }

            if(isset($_FILES['sliderbottomright']) and !empty($_FILES['sliderbottomright']['name'])) {
                $uploader = new files();
                $slider2 =   $uploader->upload_avatar($this->container->conf['dir.slider'],$_FILES['sliderbottomright']);
                Options::update_option('HOME_SLIDER_RIGHT_BOTTOM',$slider2);
            }
        
            $this->flash->addMessage('success','تم تحديث المعلومات بنجاح');
            return $response->withRedirect($this->router->pathFor('beside-slider', ['options'=>$options ]));
         }
        
    }
    
    public function footer($request,$response){
        
        if($request->getMethod() == 'GET'){
            return $this->view->render($response,'admin/settings/footer.twig');
        }
        
        
       if($request->getMethod() == 'POST'){

           $files = new files();
           $options = new options();

           $options->update_option('footer_text_widget_title_1',$request->getParam('footer_text_widget_title_1'));
           $options->update_option('footer_text_widget_content_1',$request->getParam('footer_text_widget_content_1'));
           $options->update_option('footer_text_widget_title_2',$request->getParam('footer_text_widget_title_2'));
           $options->update_option('footer_text_widget_content_2',$request->getParam('footer_text_widget_content_2'));
           $options->update_option('footer_text_widget_title_3',$request->getParam('footer_text_widget_title_3'));
           $options->update_option('footer_text_widget_content_3',$request->getParam('footer_text_widget_content_3'));
           $options->update_option('footer_text_widget_title_4',$request->getParam('footer_text_widget_title_4'));
           $options->update_option('footer_text_widget_content_4',$request->getParam('footer_text_widget_content_4'));
           $options->update_option('footer_text_widget_title_5',$request->getParam('footer_text_widget_title_5'));
           $options->update_option('footer_text_widget_content_5',$request->getParam('footer_text_widget_content_5'));
           $options->update_option('footer_link_fb',$request->getParam('footer_link_fb'));
           $options->update_option('footer_link_tw',$request->getParam('footer_link_tw'));
           $options->update_option('footer_link_yb',$request->getParam('footer_link_yb'));
           $options->update_option('footer_link_pi',$request->getParam('footer_link_pi'));
           $options->update_option('footer_link_ins',$request->getParam('footer_link_ins'));
           $options->update_option('footer_link_vie',$request->getParam('footer_link_vie'));
           $options->update_option('footer_link_gp',$request->getParam('footer_link_gp'));
           $options->update_option('footer_copyrights',$request->getParam('footer_copyrights'));
           

            $this->flash->addMessage('success','تم تحديث المعلومات بنجاح');
            return $response->withRedirect($this->router->pathFor('settings.footer'));
         }
        
    }
    
    
    
    public function others($request,$response){
        
        if($request->getMethod() == 'GET'){
            return $this->view->render($response,'admin/settings/others.twig');
        }
        
        
       if($request->getMethod() == 'POST'){

               $options = new options();
               foreach($request->getParams() as $key => $value) {
                    $options->update_option($key,$value);               
               }
            $this->flash->addMessage('success','تم تحديث المعلومات بنجاح');
            return $response->withRedirect($this->router->pathFor('settings.others'));
         }
        
    }
    
    
    
    
    
    
}

