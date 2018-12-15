<?php

namespace App\Models;
use illuminate\database\eloquent\model;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination;


class Faqs extends model{
    
    protected $table = 'faqs';
    
    protected $guarded = ['id', 'created_at', 'updated_at'];  
    
}