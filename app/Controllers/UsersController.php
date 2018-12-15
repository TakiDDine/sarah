<?php

namespace App\Controllers;
use \App\Classes as classes;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Models\User;
use forxer\Gravatar\Gravatar;
use \App\Classes\files;
use Dompdf\Dompdf;


defined('BASEPATH') OR exit('No direct script access allowed');

class UsersController extends Controller{
  
    public function index($request,$response) {
        

       $users = User::paginate(15);
          return $this->view->render($response, 'admin/users/index.twig', compact('users'));
//        ?page=2
    
        
//            $searchview     = false;
//            $count          = User::count();  
//            $page           = ($request->getParam('page', 0) > 0) ? $request->getParam('page') : 1;
//            $limit          = 10; 
//            $lastpage       = (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit));    
//            $skip           = ($page - 1) * $limit;
//            $users          = User::skip($skip)->take($limit)->orderBy('created_at', 'desc')->get();
//
//            // Search Logic
//            if($request->getParam('search')){
//               $search = $request->getParam('search');
//               $users  = $this->db->table('users')
//                    ->orderBy('created_at', 'desc')
//                    ->where('username', 'LIKE', "%$search%")
//                    ->orWhere('email', 'LIKE', "%$search%")
//                    ->skip($skip)
//                    ->take($limit)
//                    ->get();    
//                $count =    $this->db->table('users')->orderBy('created_at', 'desc')->where('username', 'LIKE', "%$search%")
//                    ->orWhere('email', 'LIKE', "%$search%")->count(); 
//               $lastpage       = (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit));    // the number of the pages
//               $searchview = true;
//            }
//
//            return $this->view->render($response, 'admin/users/index.twig', [
//                'pagination'    => [
//                    'needed'        => $count > $limit,
//                    'count'         => $count,
//                    'page'          => $page,
//                    'lastpage'      => $lastpage,
//                    'limit'         => $limit,
//                    'prev'          => $page-1,
//                    'next'          => $page+1,
//                    'start'          => max(1, $page - 4),
//                    'end'          => min($page + 4, $lastpage),
//                ],
//              'users'=>$users ,
//              'searchView'=>$searchview,
//              'searchQuery'=>$request->getParam('search')
//            ]);

    }
    
    public function account($request,$response) {
       return $this->container->view->render($response,'admin/account.twig');
    } 
    
    
    
    
    // Create user
    public function create($request,$response) {
        
         if($request->getMethod() == 'POST'){  

                // Get the parameters Sent by the Form & initialize the helper 
                $helper = $this->helper;
                $post = $helper->cleanData($request->getParams());
                
                // the route to redirect for errors
                $route = $response->withRedirect($this->router->pathFor('users.create'));

                // Clean the variables & set the username & email to lowercase
                $username   = strtolower($post['username']);
                $email      = strtolower($post['email']);
               
                // check if username is not empty
                if($helper->is_empty($username)){ $this->flasherror('المرجوا ادخال اسم المستخدم');return $route; }
                 
                // check if the email is not empty
                if($helper->is_empty($email)){ $this->flasherror('المرجوا ادخال البريد الإلكتروني'); return $route; } 
                 
                // check if the password is empty
                if($helper->is_empty($post['password'])){ $this->flasherror('المرجوا ادخال كلمة المرور');return $route; }
                 
                // check if the username is only numbers and letters
                if($helper->is_alphanumeric($username)){ $this->flasherror('اسم المستخدم غير صحيح، يجب باستخدام الحروف والأرقام فقط' ); return $route;} 
                 
                // check if the username already exist
                if(!empty(User::where('username',$username)->first())){ $this->flasherror( 'اسم المستخدم موجود من قبل');return $route; }
                                  
                // check if the email is a real email & a valid email
                if(!$helper->valid_email($email)){ $this->flasherror( 'البريد الإلكتروني غير صحيح'); return $route;}
                 
                // check if the email is already used 
                if(!empty(User::where('email',$email)->first())){ $this->flasherror('البريد الإلكتروني مستخدم من قبل'); return $route;}

                // generate the avatar
                $avatar = Gravatar::image($email) ? Gravatar::image($email) :  'default-avatar.png';
                    

                // creat the user
                $user = User::create([
                   'username' => $username,
                   'email' => $email,
                   'password' => password_hash($post['password'],PASSWORD_DEFAULT) ,
                   'role' => $post['role'],
                   'avatar' => $avatar,
                   'statue' => '1'
                ]); 
                
                // try to add this email to attempt class
                if($user) {
                    $this->Emailer->to = $email;
                    $this->Emailer->username = $username;
                    $this->Emailer->Registration_email; 
                    $this->flashsuccess('تم تسجيل العضو بنجاح');
                    return $response->withRedirect($this->router->pathFor('users'));
                }
                $this->flasherror('حصل خطأ ما  غير متوقع، المرجو المحاولة من جديد');
                return $route;
        }
        
        return $this->container->view->render($response,'admin/users/create.twig');

    } 
    
    
    
    
    
    
    public function edit($request,$response,$args) {

        $slug = $this->helper->clean($args['username']);
        
        // Get the user
        $user = User::where('username','=',$slug)->first();    
        
        
        if($request->getMethod() == 'GET'){
            if($user){
                return $this->container->view->render($response,'admin/users/edit.twig',compact('user'));
            }
            return $response->withHeader('Location', $this->router->urlFor('users'));
        }
        
        if($request->getMethod() == 'POST'){
            
            // Get the parameters Sent by the Form & initialize the helper & the fileupldader
            $helper = $this->helper;
            $post = $helper->cleanData($request->getParams());
            $up  =  $this->files();
            
            $route = $response->withRedirect($this->router->pathFor('users.edit', ['username'=> $user->username , 'user'=>$user]));
            
            
            
      


     
            $avatarimg = $_FILES['avatar'];        
                    
            // edit user info
            if($request->getParam('validate') == 'update-general-user-info'){
                
                
                
                
                // Upload the Avatar & update it in database and delete the old 
                
                // check first of all if avatar is changed !
                if($post['avatarChanged'] == 'true') {
                    
                    
                    
                    // check if there is a file
                    if(isset($avatarimg) and !empty($avatarimg['name'])) {

                        // Upload
                        $avatar =  $up->up($this->dir('avatars'),$avatarimg);

                        // check if the user avatar is not gravatar , if is not , Delete Previews avatar file
                        if(!$validator->is_gravatar($user->avatar)){
                             $avatar_path = $this->dir('avatars').'/'.$user->avatar;
                             if (file_exists($avatar_path)) {
                                unlink($avatar_path);
                             }
                        }     

                        // update it in database with the new one
                        $user->avatar  =  $avatar;
                    }
                }
               
                
                
                
                // update the user info
                $user->password = !empty($post['password']) ? password_hash($post['password'],PASSWORD_DEFAULT) : $user->password;
                $user->username     = strtolower($post['username']);;
                $user->full_name    = strtolower($post['full_name']);
                $user->email        = strtolower($post['email']);
                $user->gender       = $post['gender'];
                $user->birth        = $post['birth'];
                $user->phone        = $post['phone'];
                $user->country      = $post['country'];
                $user->description  = $post['description'];
                $user->facebook     = $post['facebook'];
                $user->twitter      = $post['twitter'];
                $user->youtube      = $post['youtube'];
                $user->save();
                
                // update the session info
                $_SESSION['user-admin'] = $user;
                
                $this->flashsuccess('تم تعديل المعلومات بنجاح');
                return $route;
                
            }
            
            // block user  حظر العضو
            if($request->getParam('validate') == 'blockUser'){
                $user->statue = 3;
                $user->save(); 
                $this->flashsuccess('تم حظر العضو بنجاح');
                return $route;
            }
            
            // activate user
            if($request->getParam('validate') == 'ActivateUser'){
                $user->statue = 1;
                $user->save(); 
                $this->flashsuccess('تم تفعيل العضو العضو بنجاح');
                return $route;
            }
            
            // Delete user
            if($request->getParam('validate') == 'DeleteUser'){
                if($user->statue == 'supper') {
                    $this->flasherror('لا يمكن حذف هذا العضو ');
                    return $route;
                }else{
                    $user->delete();
                    $this->flasherror('تم حذف العضو بنجاح');
                    return $response->withHeader('Location', $this->router->urlFor('users'));
                }
            }
        
        }
        

    }    

    public function export_pdf($request,$response) {

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
              <tr><td colspan="3"></td></tr>
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
            $columns = [
                'username','full_name','email','created_at','updated_at','deleted_at',
                'description','phone','facebook','twitter',  'youtube','country', 'ip','gender','birth'
            ];
        
            fputcsv($stream, $columns, ';');
        
            $users = User::All(['username',
                'full_name','email', 'created_at','updated_at','deleted_at','description',
                'phone','facebook','twitter','youtube','country','ip','gender','birth'
            ]);
       
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
        User::where('statue', '!=', 'supper')->delete();
        $this->flashsuccess('تم حذف كل الأعضاء بنجاح');
        return $response->withHeader('Location', $this->router->urlFor('users'));
    }
    
    public function mutliAction($request,$response){
    
        // Get All selected Pages
        $selected =  User::whereIn('id', array_values($request->getParam('checkaction')));
        
        // Take the Correct Action
        if($request->getParam('takeAction') == 'delete'){ $selected->delete();  $this->flashsuccess('تم تنفيذ الأمر بنجاح'); }

        // Redirect To users page
        return $response->withRedirect($this->router->pathFor('users'));
    
    }
    
}
