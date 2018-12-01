<?php

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Classes\files;
use \App\Models\Emails;

defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends Controller{
   
  
    public function home($request,$response) {
      $count = [];
        
        // info
        $pdo = $this->db->connection()->getPdo();
        $version = $pdo->query('select version()')->fetchColumn();
        

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
        $meteo['Humidity'] = "<b>الرطوبة : ".$data['main']['humidity']."%</b>";
        $meteo['Wind'] = "<b>سرعة الرياح:".$data['wind']['speed']."m/s</b><br>";
        $meteo['Pressure'] = "<b>Pressure:".$data['main']['pressure']."hpa</b><br>";
        $meteo['Visibility'] =  "<b>Visibility:".$visibilitykm."Km</b><br>";
        $meteo['Sunrise'] = "<b>شروق الشمس : ".date('h:i A', $data['sys']['sunrise'])."</b><br>";
        $meteo['Sunset'] = "<b>غروب الشمس : ".date('h:i A', $data['sys']['sunset'])."</b>";
        
        
        
        
        
        
      $count['products'] = $this->db->table('products')->count(); 
      $count['users'] = $this->db->table('users')->count(); 
      $count['emails'] = $this->db->table('emails')->count(); 
      $count['posts'] = $this->db->table('posts')->count(); 
      $count['orders'] = $this->db->table('orders')->count(); 
      $count['pages'] = $this->db->table('pages')->count(); 
  
        $info['phpversion'] = phpversion();
        $info['mysqlversion'] = $version;
          
        
       return $this->container->view->render($response,'admin/home.twig',[
           'count'=>$count, 'info' =>$info , 'temp' => $meteo
                                                                         
        ]);
    }
    
    public function page404($request,$response){
        return $this->container->view->render($response,'admin/errors/404.twig');
    }
   
    
   
     
}

