<?php

namespace App\Models;
use illuminate\database\eloquent\model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination;


class Page extends model{


    
    protected $table = 'pages';
    
    protected $guarded = ['id', 'created_at', 'updated_at'];
  

}