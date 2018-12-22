<?php


namespace App\Models;
use illuminate\database\eloquent\model;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination;


class Comments extends model{

    protected $table = 'comments';
    protected $guarded = ['id', 'created_at', 'updated_at'];
    
    
    // Get Post User
    public function by(){
        return $this->belongsTo('\App\Models\User','user_id');
    }
    
    // Get Post User
    public function post(){
        return $this->belongsTo('\App\Models\Post','post_id');
    }
    
    
    
    
}

