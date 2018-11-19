<?php

namespace App\Models;
use illuminate\database\eloquent\model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination;


class Menus extends model{

    
    protected $table = 'menus';
    
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
    public function the_menu(){
        return json_decode( $this->menu , TRUE);
    }
    
    
    
    
}