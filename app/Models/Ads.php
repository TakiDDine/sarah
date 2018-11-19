<?php

namespace App\Models;
use illuminate\database\eloquent\model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination;


class Ads extends model{


    
    protected $table = 'ads';
    
    protected $guarded = ['id', 'created_at', 'updated_at'];
    
    /* *************
     * Display User Role 
     * *************
    */
    public static function displayRole($username){
        $role = User::where('username',$username)->first()->role;
        if($role == 1 ) {
            echo '<span class="label label-primary">مستخدم عادي</span>';
        }
        if($role == 2 ) {
            echo '<span class="label label label-success">مدير</span>';
        }
        if($role == 3 ) {
            echo '<span class="label label-primary">غير معروف </span>';
        }        
    }
    
    /* *************
     * Display User Statue 
     * *************
    */  
    public static function displayStatue($username){
        $statue = self::where('username',$username)->first()->statue;
        if($statue == 1 ) {
            echo '<span class="label border-left-success label-striped">مفعل</span>';
        }
        if($statue == 2 ) {
            echo '<span class="label border-left-primary label-striped">ينتظر الموافقة</span>';
        }
        if($statue == 3 ) {
            echo '<span class="label border-left-danger label-striped">محظور </span>';
        }        
    }
}