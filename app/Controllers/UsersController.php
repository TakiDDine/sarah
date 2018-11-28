<?php

namespace App\Controllers;
use \App\Classes as classes;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Models\User;
use \App\Classes\validator as validator;
use forxer\Gravatar\Gravatar;
use \App\Classes\files;
use \App\Classes\app;
use \App\Classes\pdf\FPDF;
use Dompdf\Dompdf;


defined('BASEPATH') OR exit('No direct script access allowed');
class UsersController extends Controller{
    
    public function account($request,$response) {
       return $this->container->view->render($response,'admin/account.twig');
    } 
    
    public function create($request,$response) {
        
        
             if($request->getMethod() == 'GET'){
               return $this->container->view->render($response,'admin/users/create.twig');
             }
        
             if($request->getMethod() == 'POST'){  

                $validator = $this->validator;    
                
                 // Get the user IP
                $ip = $this->helper->get_ip_address();

                 
                 

                // Get the parameters Sent by the Form .
                $post = $request->getParams();

                // Clean the variables
                $username            = strtolower($validator->clean($post['username']));
                $email               = strtolower($validator->clean($post['email']));
                $password            = $validator->clean($post['password']);
                $role                = $validator->clean($post['role']);


                if(!empty(User::where('username',$username)->first())){
                    $this->flash->addMessage('error', 'اسم المستخدم موجود من قبل');
                    return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('users.create'));
                }
                if(!empty(User::where('email',$email)->first())){
                    $this->flash->addMessage('error', 'البريد الإلكتروني مستخدم من قبل');
                    return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('users.create'));
                }

                if($validator->is_alphanumeric($username)){ 
                    $this->flash->addMessage('error','اسم المستخدم غير صحيح، يجب باستخدام الحروف والأرقام فقط' );
                    return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('users.create'));
                } 
                
                 
                if($validator->is_empty($email)){ 
                    $this->flash->addMessage('error','المرجوا ادخال البريد الإلكتروني');
                    return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('users.create'));                        
                }  
                 
                 
                if($validator->is_Email($email)){ 
                    $this->flash->addMessage('error','البريد الإلكتروني غير صحيح' );
                    return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('users.create'));                    
                }       
                
                 
                if($validator->is_empty($username)){
                    $this->flash->addMessage('error','المرجوا ادخال اسم المستخدم' );
                    return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('users.create'));                    
                }

                 
                if($validator->is_empty($password)){ 
                    $this->flash->addMessage('error', 'المرجوا ادخال كلمة المرور');
                    return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('users.create'));                    
                }


                $avatar = 'default-avatar.png';
                if (Gravatar::image($email)){
                    $avatar = Gravatar::image($email);
                }

                $password = password_hash($password,PASSWORD_DEFAULT);    

                    User::create([
                           'username' => $username,
                           'email' => $email,
                           'password' => $password,
                           'role' => $role,
                           'avatar' => $avatar,
                           'ip' => $ip,
                           'statue' => '1'
                     ]); 

                    $this->Emailer->to = $email;
                    $this->Emailer->username = $username;
                    $this->Emailer->Registration_email;
                
                 $this->flash->addMessage('success','تم تسجيل العضو بنجاح');
                 return $response->withRedirect($this->router->pathFor('users'));
             }

    }  
    
    public function index($request,$response) {
        
            $searchview     = false;
            $count          = User::count();   // Count of all available users      
            $page           = ($request->getParam('page', 0) > 0) ? $request->getParam('page') : 1;
            $limit          = 10; // Number of Users on one page   
            $lastpage       = (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit));    // the number of the pages
            $skip           = ($page - 1) * $limit;
            $users          = $this->db->table('users')->skip($skip)->take($limit)->orderBy('created_at', 'desc')->get();

            // Search Logic
            if($request->getParam('search')){
               $search = $request->getParam('search');
               $users  = $this->db->table('users')
                    ->orderBy('created_at', 'desc')
                    ->where('username', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%")
                    ->skip($skip)
                    ->take($limit)
                    ->get();    
                $count =    $this->db->table('users')->orderBy('created_at', 'desc')->where('username', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%")->count(); 
               $lastpage       = (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit));    // the number of the pages
               $searchview = true;
            }

            return $this->view->render($response, 'admin/users/index.twig', [
                'pagination'    => [
                    'needed'        => $count > $limit,
                    'count'         => $count,
                    'page'          => $page,
                    'lastpage'      => $lastpage,
                    'limit'         => $limit,
                    'prev'          => $page-1,
                    'next'          => $page+1,
                    'start'          => max(1, $page - 4),
                    'end'          => min($page + 4, $lastpage),
                ],
              'users'=>$users ,
              'searchView'=>$searchview,
              'searchQuery'=>$request->getParam('search')
            ]);

    }

    public function edit($request,$response,$args) {

$validator = $this->validator; 

$user = User::where('username','=',$args['username'])->first();    
// check if the user avatar is not gravatar , if is not , append avatars url
 if(!$validator->is_gravatar($user->avatar)){
     $user->avatar = $this->conf['url.avatars'].$user->avatar;   
}     

if($request->getMethod() == 'GET'){
    return $this->container->view->render($response,'admin/users/edit.twig',['user'=>$user]);
}
    
        
        if($request->getMethod() == 'POST'){

            /*
            *    تعديل المعلومات الشخصية
            */
            if($request->getParam('validate') == 'update-general-user-info'){
                
                /*
                *   check if the new password is submmited , and change it
                */
                $password = $request->getParam('password');
                if (isset($password) and !empty($password)) {
                    
                    $password = password_hash($password,PASSWORD_DEFAULT);    
                    $user->password = $password;
                    
                }
                
                /*
                * Upload the Avatar & update it in database
                */
                $avatar_action = $request->getParam('avatarChanged');
                
                // check first of all if avatar is changed !
                if($avatar_action == 'true') {
                    
                    // check if there is a file
                    if(isset($_FILES['avatar']) and !empty($_FILES['avatar']['name'])) {

                        $avatar = new files();
                        $path = $this->container->conf['dir.avatars'];
                        $file = $_FILES['avatar'];

                        // Upload
                        $avatar =  $avatar->upload_avatar($path,$file);

                        // check if the user avatar is not gravatar , if is not , Delete Previews avatar file
                        if(!$validator->is_gravatar($user->avatar)){
                             $avatar_path = $this->container->conf['dir.avatars'].'/'.$user->avatar;
                             if (file_exists($avatar_path)) {
                                unlink($avatar_path);
                             } 
                        }     

                        // update it in database with the new one
                        $user->avatar  =  $avatar;

                    }
                }
                

                $user->username =  $request->getParam('username');
                $user->full_name =  $request->getParam('full_name');
                $user->email =  $request->getParam('email');
                $user->gender =  $request->getParam('gender');
                $user->birth =  $request->getParam('birth');
                $user->phone =  $request->getParam('phone');
                $user->country =  $request->getParam('country');
                $user->description =  $request->getParam('description');
                $user->facebook =  $request->getParam('facebook');
                $user->twitter =  $request->getParam('twitter');
                $user->youtube =  $request->getParam('youtube');
                $user->save();
                
                $_SESSION['user-admin'] = $user;
                
                $this->flash->addMessage('success', 'تم تعديل المعلومات بنجاح');
                return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('users.edit',['username'=>$user->username]));
                
            }
            
            
            /*
            *   حظر العضو
            */
            if($request->getParam('validate') == 'blockUser'){
                $user->statue = 3;
                $user->save(); 
                $this->flash->addMessage('error','تم حظر العضو بنجاح');
                return $response->withRedirect($this->router->pathFor('users.edit', ['username'=> $user->username , 'user'=>$user]));
            }
            
            /*
            *   تفعيل العضو
            */
            if($request->getParam('validate') == 'ActivateUser'){
                $user->statue = 1;
                $user->save(); 
                $this->flash->addMessage('success','تم تفعيل العضو العضو بنجاح');
                return $response->withRedirect($this->router->pathFor('users.edit', ['username'=> $user->username , 'user'=>$user]));
            }
            
            
            /*
            *   حذف العضو
            */
            if($request->getParam('validate') == 'DeleteUser'){
                if($user->statue == 'supper') {
                    $validator->flash('لا يمكن حذف هذا العضو ','error');
                }else{
                    $user->delete();
                    $this->flash->addMessage('error', 'تم حذف العضو بنجاح');
                    return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('users'));
                }
            }  
            
        }
        

       return $this->container->view->render($response,'admin/users/show.twig',['user'=>$user,'flash'=>$flash]);
    }    

    public function export_pdf($request,$response) {

// reference the Dompdf namespace


// instantiate and use the dompdf class
$dompdf = new Dompdf();
        
        $users = User::All();
        ob_start();
        ?>
        <style>
            table tr td{
                border-bottom: 1px solid black;
                padding: 5px;
            }
        </style>
        <table>
           
            <tr>
                <th>Userame</th>
                <th>Email</th>
                <th>Created at</th>
            </tr>
            <tbody>
              <tr>
                  <td colspan="3"></td>
              </tr>
               <?php foreach($users as $user): ?>
                <tr>
                    <td style="width:250px;"><?php echo $user->username ?></td>
                    <td style="width:250px;"><?php echo $user->email ?></td>
                    <td style="width:250px;"><?php echo $user->created_at ?></td>                    
                </tr>
                <?php endforeach; ?>
            </tbody>
            
            
        </table>
        
        <?php
        
        $users = ob_get_clean();
        
        
$dompdf->loadHtml($users);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$filename = date('Y-m-d') . '_users.pdf';
$dompdf->stream($filename);
      

    }
    
    public function export_csv($request,$response) {
       
   $stream = fopen('php://memory', 'w+');
            fwrite($stream, chr(0xEF) . chr(0xBB) . chr(0xBF));
            // Add header
        $columns = ['username',
'full_name',
'email',
'created_at',
'updated_at',
'deleted_at',
'description',
'phone',
'facebook',
'twitter',
'youtube',
'country',
'ip',
'gender',
'birth'];
            fputcsv($stream, $columns, ';');
        
        $users = User::All(['username',
'full_name',
'email',
'created_at',
'updated_at',
'deleted_at',
'description',
'phone',
'facebook',
'twitter',
'youtube',
'country',
'ip',
'gender',
'birth']);
       


        

        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
          foreach ($users as $user) {
              $data = [
                      $user->username,
$user->full_name,
$user->email,
$user->created_at,
$user->updated_at,
$user->deleted_at,
$user->description,
$user->phone,
$user->facebook,
$user->twitter,
$user->youtube,
$user->country,
$user->ip,
$user->gender,
$user->birth,

                    ];
              
            fputcsv($stream, $data, ';');
        }
                  
        
            rewind($stream);

            $filename = date('Y-m-d') . '_users.csv';
            $response = $this->response
                ->withHeader('Content-Type', 'text/csv')
                ->withHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->withHeader('Pragma', 'no-cache')
                ->withHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
                ->withHeader('Expires', '0');

            return $response->withBody(new \Slim\Http\Stream($stream));     
        
        
    }  
    
    public function blukdelete($request,$response){
        $users = User::where('statue', '!=', 'supper')->delete();
        $this->flash->addMessage('success', 'تم حذف كل الأعضاء بنجاح');
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('users'));
    }
    
    /*
    *   Taking Action For selected Rows in the Table
    *   version 1.0 , Action that exist now is Delete 
    */
    public function mutliAction($request,$response){
    
        // Get All selected Pages
        $selected =  User::whereIn('id', array_values($request->getParam('checkaction')));
        
        // Take the Correct Action
        if($request->getParam('takeAction') == 'delete'){ $selected->delete(); }

        // Redirect To Pages
        $this->flash->addMessage('success', 'تم تنفيذ الأمر بنجاح');
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor('users'));
    
    }
    
}
