<?php

namespace App\Models;
use illuminate\database\eloquent\model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination;


class Order extends model{


    
    protected $table = 'orders';
    
    protected $guarded = ['id', 'created_at', 'updated_at'];
    
    public function full_name(){
        return $this->first_name . " " . $this->last_name;
    }
    
    public function get_statue(){
        if($this->statue == 1) {
            echo '<span class="label border-right-violet  label-striped label-striped-right">قيد الإنتظار</span>';
        }
    }
    
    
}