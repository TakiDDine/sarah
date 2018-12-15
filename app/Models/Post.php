<?php

namespace App\Models;
use illuminate\database\eloquent\model;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination;
use \App\Classes\Helper;
use \App\Model\Comments as comment;

class Post extends model{

public function timestamps()
{
    $this->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
    $this->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
}
    
    protected $table = 'posts';
    
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
    
    public function excerpt(){  
        $helper = new helper();
       return $helper->get_snippet($this->content,25,' [...] ');
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
    
    
    // Get post Comments 
    public function comments() {
        return $this->hasMany('\App\Models\Comments');
    }
    
  
    
    // Get Post User
    public function writer(){
        return $this->belongsTo('\App\Models\User','author');
    }
    
    // Get Post User
    public function categorie(){
        return $this->belongsTo('\App\Models\PostsCategories','categoryID');
    }
    
    
    

}