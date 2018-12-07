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
        
        
        
        
        
        
      $count['products'] = $this->db->table('products')->count(); 
      $count['users'] = $this->db->table('users')->count(); 
      $count['emails'] = $this->db->table('emails')->count(); 
      $count['posts'] = $this->db->table('posts')->count(); 
      $count['orders'] = $this->db->table('orders')->count(); 
      $count['pages'] = $this->db->table('pages')->count(); 
  
        $info['phpversion'] = phpversion();
        $info['mysqlversion'] = $version;
        $info['filesize'] = $this->helper->formatBytes($this->helper->foldersize(BASEPATH.'/'));
        $info['databasesize'] = $databasesize. ' mb';

        
        
       return $this->container->view->render($response,'admin/home.twig',[
           'count'=>$count, 'info' =>$info , 'temp' => $meteo
                                                                         
        ]);
    }
    
    public function page404($request,$response){
        return $this->container->view->render($response,'admin/errors/404.twig');
    }
   
    public function download_zip($request,$response){
        
            // Get real path for our folder
    $rootPath = realpath(BASEPATH);

    // Initialize archive object
    $zip = new \ZipArchive();
    $zip->open(BASEPATH.'/file.zip', \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

    // Create recursive directory iterator
    /** @var SplFileInfo[] $files */
    $files = new \RecursiveIteratorIterator(
        new \RecursiveDirectoryIterator($rootPath),
        \RecursiveIteratorIterator::LEAVES_ONLY
    );

    foreach ($files as $name => $file)
    {
        // Skip directories (they would be added automatically)
        if (!$file->isDir())
        {
            // Get real and relative path for current file
            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen($rootPath) + 1);

            // Add current file to archive
            $zip->addFile($filePath, $relativePath);
        }
    }

    // Zip archive will be created only after closing object
    $zip->close();

    }
   
     
}

