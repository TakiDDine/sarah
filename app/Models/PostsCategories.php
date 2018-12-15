<?php


namespace App\Models;
use illuminate\database\eloquent\model;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination;


class PostsCategories extends model{

    protected $table = 'postscategories';
    protected $guarded = ['id', 'created_at', 'updated_at'];
    
    public function posts() {
        return $this->hasMany('\App\Models\Post','categoryID');
    }
    
}

