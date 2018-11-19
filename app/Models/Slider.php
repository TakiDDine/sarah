<?php




namespace App\Models;
use illuminate\database\eloquent\model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination;


class Slider extends model{


    protected $table = 'slider';
    
    protected $guarded = ['id', 'created_at', 'updated_at'];
    


}