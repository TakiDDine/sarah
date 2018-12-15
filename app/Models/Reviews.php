<?php

namespace App\Models;
use illuminate\database\eloquent\model;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination;


class Reviews extends model{

    public function timestamps()
    {
        $this->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        $this->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
    }
    
    protected $table = 'productreviews';
    
    protected $guarded = ['id', 'created_at', 'updated_at'];
    
   
}