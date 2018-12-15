<?php

namespace App\Models;
use illuminate\database\eloquent\model;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination;


class Emails extends model{
  
    
    protected $admin_role = 2;
    protected $table = 'emails';
    protected $guarded = ['id', 'created_at', 'updated_at'];
        
    public function snippet(){
       echo get_snippet($this->body,15,' [...] ');
    } 
}