<?php

namespace App\Models;
use illuminate\database\eloquent\model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination;
use \App\Classes\Helper;


class Media extends model{

    protected $table = 'media';
    
    protected $guarded = ['id', 'created_at', 'updated_at'];
    
    
   
    public function ext(){
       $helper = new helper();
       return $helper->get_ext($this->name);
    }
    
    
}