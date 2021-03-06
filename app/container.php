<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use PHPtricks\Orm\Database;
use Noodlehaus\Config;
use Illuminate\Database\Capsule\Manager as Capsule;
use \App\Models\User;
use Slim\Flash\Messages as Flash;
use \App\Auth;
use \App\Models\options;
use \App\Classes\App;
use \App\Helpers\functions;
use \App\Models\ProductCategories;
use \App\Models\Menus;
use \App\Models\Cart;
use \App\Models\Product;
use \App\Models\Post;
use \App\Classes\Helper;


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}





// Set the container
$container = $app->getContainer();

// Get All the settings Frpm Config File
$container['conf'] = function () {
    return Config::load(INC_ROOT.'/app/config.php');
};

// 405 Error Handler
$container['notAllowedHandler'] = function ($container) {
    return function ($request, $response, $methods) use ($container) {
        return $response->withStatus(405)
            ->withHeader('Allow', implode(', ', $methods))
            ->withHeader('Content-type', 'text/html')
            ->write(' ');
    };
};



//  Error Handling
//  Stop the errors when the mode is live
if($container['conf']['app.debug'] == false ):  
    ini_set("display_errors", 0);
    ini_set('log_errors', 0);
    error_reporting(0);
    @ini_set('display_errors',0);
endif;
//
//
//$function = new Twig_SimpleFunction('square', function () {
//    if param2 present?
//     return param1*param2;
//    else
//     return param1;
//});





// Register Flash Messages
$container['flash'] = function ($container) {
    return new \Slim\Flash\Messages();
};
// Register Twig View helper
$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig('../app/Views', [
        'cache' => false,
    ]);
    
    // Instantiate and add Slim specific extension
    $router = $c->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));
        
    
    $view->addExtension(new Knlv\Slim\Views\TwigMessages(
    new Slim\Flash\Messages()
    ));
    $view->getEnvironment()->addglobal('flash',$c->flash);
    

    
    
    $filter = new Twig_SimpleFilter('displayStatue', function ($username) {
        return User::displayStatue($username);
    });
    $view->getEnvironment()->addFilter($filter);
    
    
    $filter = new Twig_SimpleFilter('options', function ($username) {
        $options = new options();
        $option = $options->get_option($username);
        if($option){
            return $option;
        }else {
              return "";
        }
    });
    $view->getEnvironment()->addFilter($filter);
    
    
    $filter = new Twig_SimpleFilter('dateOnly', function ($username) {
        $date = date('Y-m-d', strtotime($username));
        if(date('Y-m-d') == date('Y-m-d', strtotime($date))) {
             return "اليوم";
        }
        
        return $date;
    });
    $view->getEnvironment()->addFilter($filter);
  
  
    $filter = new Twig_SimpleFilter('highlight_code', function ($username) {
        
        $helper = new helper();
        return $helper->highlight_code($username);
        
    });
    $view->getEnvironment()->addFilter($filter);
      
    
    
    
   $filter = new Twig_SimpleFilter('file_size', function ($file) {
       global $container;
       $helper= new Helper();
       echo $helper->calc(filesize($container->conf['dir.media'].$file));
    });
    $view->getEnvironment()->addFilter($filter);
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    $filter = new Twig_SimpleFilter('smallAvatar', function ($gender) {
        global $container;
        if(!empty($gender)){
            if(!$container->validator->is_gravatar($gender)){
                $gender = $container->conf['url.avatars'].$gender;   
            }     
            $gender = '<div class="avatar"><img src="'.$gender.'" /></div>';
            echo $gender;  
        }
    });
    $view->getEnvironment()->addFilter($filter);
    
    
    $filter = new Twig_SimpleFilter('navAvatar', function ($gender) {
        global $container;
        if(!empty($gender)){
            if(!$container->validator->is_gravatar($gender)){
                $gender = $container->conf['url.avatars'].$gender;   
            }     
            $gender = '<img src="'.$gender.'" />';
            echo $gender;  
        }
    });
    $view->getEnvironment()->addFilter($filter);
    
    
    $filter = new Twig_SimpleFilter('adsatue', function ($gender) {
        if($gender == 0 ) {
        echo '<span class="label border-left-danger label-striped">غير مفعل</span>';
        } else{
            
        echo '<span class="label border-left-success label-striped">مفعل</span>';
        }
        
    });
    $view->getEnvironment()->addFilter($filter);
    
    
    
    $filter = new Twig_SimpleFilter('pagesatue', function ($gender) {
        if($gender == 0 ) {
        echo '<span class="label border-left-danger label-striped">مسودة</span>';
        } 
        if($gender == 1 ) {
          echo '<span class="label border-left-success label-striped">منشور</span>';  
        }
    });
    $view->getEnvironment()->addFilter($filter);
    
    
    $filter = new Twig_SimpleFilter('fuckit', function ($time) {
        return st($time);
    });
    $view->getEnvironment()->addFilter($filter);
    
    $filter = new Twig_SimpleFilter('st', function ($username) {
        return st($username);
    });
    $view->getEnvironment()->addFilter($filter);
    
    
    
    
    $filter = new Twig_SimpleFilter('makeNiceTime', function ($time) {
        return human_time_diff($time);
    });
    $view->getEnvironment()->addFilter($filter);
    
    
    return $view;
};




// Connect To DataBase

    $capsule = new Capsule;
  $capsule->addConnection([
        'driver'    => $container['conf']['db.driver'],
        'host'      => $container['conf']['db.host'],
        'database'  => $container['conf']['db.name'],
        'username'  => $container['conf']['db.username'],
        'password'  => $container['conf']['db.password'],
        'charset'   => $container['conf']['db.charset'],
        'collation' => $container['conf']['db.collation'],
        'prefix'    => '',
        'strict' => false
    ]);

   
   // Make this Capsule instance available globally via static methods... (optional)
    $capsule->setAsGlobal();

    // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
    $capsule->bootEloquent();




try {
    Capsule::connection()->getPdo();
} catch (\Exception $e) {
    die("Could not connect to the database.  Please check your configuration. "  );
}




// Setup 404 Handler
$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        global $container;
        return $container->view->render($response->withStatus(404),'website/404.twig');
    };
};

/*
*   Add Classes To the Container 
*/
$container['db'] = $capsule;
$container['auth'] = new \App\Auth\auth;
$container['validator'] = new \App\Classes\validator;
$container['Emailer'] = new \App\Email\Email($container);
$container['User']  = function($container){
    return new \App\Models\User;
};



$container['Users'] = function ($container) { return new \App\Controllers\UsersController($container);};
$container['Menus'] = function ($container) { return new \App\Controllers\MenusController($container);};
$container['Comments'] = function ($container) { return new \App\Controllers\CommentsController($container);};
$container['Media'] = function ($container) { return new \App\Controllers\MediaController($container);};
$container['Pages'] = function ($container) { return new \App\Controllers\PagesController($container);};





/*
*   Add Global Variables to twig view
*/
$search = $_GET['search'] ?? '';

$container['view']->getEnvironment()->addGlobal('admin_assets', $container['conf']['url.admin_assets']);
$container['view']->getEnvironment()->addGlobal('website_assets', $container['conf']['url.website_assets']);
$container['view']->getEnvironment()->addGlobal('search', $search);


        // the cart start
        $maincart = [];
        if(isset($_SESSION['auth-user'])) {  
        $cart = Cart::where('user_id',$_SESSION['auth-user'])->get()->toArray();

        foreach($cart as $item ) {
           $product = Product::where('id',$item['productID'])->first();
            if($product){
                $product = $product->toArray();
                $product['productID'] = $product['id'];
                $item['cartID'] = $item['id'];
                $maincart[] =  array_merge($product,$item);
            }
                
        }
}    
// the cart end

$countries = include_once INC_ROOT.'/app/countries.php';
$container['view']->getEnvironment()->addGlobal('countries', $countries);
$container['view']->getEnvironment()->addGlobal('ads_url', $container['conf']['url.ads']); 
$container['view']->getEnvironment()->addGlobal('config', $container['conf']['app']); 
$container['view']->getEnvironment()->addGlobal('url', $container['conf']['url']); 
$container['view']->getEnvironment()->addGlobal('dir', $container['conf']['dir']); 
$container['view']->getEnvironment()->addGlobal('searchCategories', ProductCategories::all()); 
$container['view']->getEnvironment()->addGlobal('menus', Menus::All()); 
$container['view']->getEnvironment()->addGlobal('CLEAN_URL_BASE', rtrim($container['conf']['url.base'], '/')); 
$container['view']->getEnvironment()->addGlobal('cart', $maincart); 



  
//$post = Post::find(8);
//echo '<pre>';
//print_r($post->author()->get()->toArray());
//exit;
//
//


/*
*   Add admin to view
*/
if(isset($_SESSION['auth-admin'])) {   
    $container['view']->getEnvironment()->addGlobal('admin',$capsule->table('users')->find($_SESSION['auth-admin']) );
}

/*
*   Add admin to view
*/
if(isset($_SESSION['auth-user'])) {   
    $container['view']->getEnvironment()->addGlobal('user',$capsule->table('users')->find($_SESSION['auth-user']) );
}
 $file = BASEPATH.'/app/lang/admin/ar.php';
   $container['view']->getEnvironment()->addGlobal('l', Config::load($file));


//if(isset($_GET['lang'])) {
//    setcookie('lang', $_GET['lang'], time()+3600 , '/');
//    header('Location: http://sarah.local/dashboard/'); 
//    $file = BASEPATH.'/app/lang/admin/'.$_GET['lang'].'.php';
//    $container['view']->getEnvironment()->addGlobal('l', Config::load($file));
//    $container['view']->getEnvironment()->addGlobal('l', Config::load($file));
//}
//$lg = !isset($_COOKIE['lang']) ? 'en' : $_COOKIE['lang'];
//
//$file = BASEPATH.'/app/lang/admin/'.$lg.'.php';
//$container['view']->getEnvironment()->addGlobal('l', Config::load($file));
//
//




