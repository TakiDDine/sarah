<?php

namespace App\Models;
use illuminate\database\eloquent\model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination;


class WishList extends model{


    
    protected $table = 'productswishlist';
    
    protected $guarded = ['id', 'created_at', 'updated_at'];
   
    

}