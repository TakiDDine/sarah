<?php

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Classes\files;
use \App\Models\Emails;
use Illuminate\Database\Capsule\Manager as Capsule;

defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends Controller{
   
  
    public function home($request,$response) {
        
              
        $count = Capsule::select("SELECT 
         (SELECT COUNT(*) FROM products) as products, 
         (SELECT COUNT(*) FROM users) as users, 
         (SELECT COUNT(*) FROM emails) as emails,
         (SELECT COUNT(*) FROM posts) as posts, 
         (SELECT COUNT(*) FROM orders) as orders, 
         (SELECT COUNT(*) FROM pages) as pages
        ");

 
        $pdo = $this->db->connection()->getPdo();
        $version = $pdo->query('select version()')->fetchColumn();
        
        
        // get the size of database
        $size = 0;
        foreach($pdo->query('SHOW TABLE STATUS')->fetchAll() as $row) {
            $size += $row["Data_length"] + $row["Index_length"];  
        }
        // change from bytes to megabytes
        $decimals = 2;  
        $databasesize = number_format($size/(1024*1024),$decimals);
        
        // Meteo
        $get = json_decode(file_get_contents('http://ip-api.com/json/'),true);
        date_default_timezone_set('Africa/Casablanca');
        $string = "http://api.openweathermap.org/data/2.5/weather?q=Casablanca&units=metric&appid=ebcf5230b3446f334fe3fa2fd2d4ce24";
        $data = json_decode(file_get_contents($string),true);
        
        
        $temp = $data['main']['temp'];
        $icon = $data['weather'][0]['icon'];
        $desc = $data['weather'][0]['description'];

        $meteo = [];
        $meteo['temp'] = $temp;
        $meteo['icon'] = $icon;
        $meteo['desc'] = $desc;
        $meteo['Humidity'] = $data['main']['humidity']."%";
        $meteo['Wind'] = $data['wind']['speed']."m/s";
        $meteo['Sunrise'] = date('h:i A', $data['sys']['sunrise']);
        $meteo['Sunset'] = date('h:i A', $data['sys']['sunset']);
        
        
        
        
        

        $info['phpversion'] = phpversion();
        $info['mysqlversion'] = $version;
        $info['filesize'] = $this->helper->formatBytes($this->helper->foldersize(BASEPATH.'/'));
        $info['databasesize'] = $databasesize. ' mb';

        
        
       return $this->container->view->render($response,'admin/home.twig',[
           'count'=>$count[0], 'info' =>$info , 'temp' => $meteo
                                                                         
        ]);
    }
    
    public function page404($request,$response){
        return $this->view->render($response,'admin/errors/404.twig');
    }
   
    public function FileManager($request,$response){
        return $this->view->render($response,'FileManager.php');
    }
   
     
}

