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
use \App\Classes\Helper;





// Set the container
$container = $app->getContainer();

// Get All the settings Frpm Config File
$container['conf'] = function () {
    return Config::load(INC_ROOT.'/app/config.php');
};


//  Error Handling
if($container['conf']['info.debug'] == 'false' ):  
    ini_set("display_errors", 0);
    ini_set('log_errors', 0);
    error_reporting(0);
    @ini_set('display_errors',0);
endif;


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
    
    $view->addExtension(new \nochso\HtmlCompressTwig\Extension());
    
    
    $view->addExtension(new Knlv\Slim\Views\TwigMessages(
    new Slim\Flash\Messages()
    ));
    $view->getEnvironment()->addglobal('flash',$c->flash);
    
    
    // Adding DisplayStatue To twig
    $filter = new Twig_SimpleFilter('displayRole', function ($username) {
        return User::displayRole($username);
    });
    $view->getEnvironment()->addFilter($filter);
    
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
    
    $filter = new Twig_SimpleFilter('displayGender', function ($gender) {
        if($gender == 'male') {
            return 'مذكر';
        }else{
            return 'أنثى';
        }
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
    
    
    
    
    $filter = new Twig_SimpleFilter('makeNiceTime', function ($time) {
        return human_time_diff($time);
    });
    $view->getEnvironment()->addFilter($filter);
    
    
    return $view;
};


/*
*    Connect To DataBase
*/
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


// Setup 404 Handler
$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        global $container;
        return $container->view->render($response,'website/404.twig');
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

/*
*   Add Global Variables to twig view
*/


$container['view']->getEnvironment()->addGlobal('admin_assets', $container['conf']['url.admin_assets']);
$container['view']->getEnvironment()->addGlobal('website_assets', $container['conf']['url.website_assets']);



// the cart start
$maincart = [];
if(isset($_SESSION['auth-user'])) {  
$cart = Cart::where('user_id',$_SESSION['auth-user'])->get()->toArray();

        foreach($cart as $item ) {
           $product = Product::where('id',$item['productID'])->first()->toArray();
                $product['productID'] = $product['id'];
                $item['cartID'] = $item['id'];

           $maincart[] =  array_merge($product,$item);
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
