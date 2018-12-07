<?php




namespace App\Models;
use illuminate\database\eloquent\model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination;


class User extends model{


    protected $admin_role = 2;
    protected $table = 'users';
    
    protected $guarded = ['id', 'created_at', 'updated_at'];
    
    /* *************
     * Display User Role 
     * *************
    */
    public function role(){
        
        $role = User::where('username',$this->username)->first();
        
        if($role){
            if($role->role == 1 ) {
                echo '<span class="label label-primary">مستخدم عادي</span>';
            }
            if($role->role == 2 ) {
                echo '<span class="label label label-success">مدير</span>';
            }
            if($role->role == 3 ) {
                echo '<span class="label label-primary">غير معروف </span>';
            } 
        }
        echo  " ";

    }
    
    /* *************
     * Display User Statue 
     * *************
    */  
    public function statue(){
        $statue = self::where('username',$this->username)->first();
        
        if($statue){
            if($statue->statue == 1 ) {
                echo '<span class="label border-left-success label-striped">مفعل</span>';
            }
            if($statue->statue == 2 ) {
                echo '<span class="label border-left-primary label-striped">ينتظر الموافقة</span>';
            }
            if($statue->statue == 3 ) {
                echo '<span class="label border-left-danger label-striped">محظور </span>';
            }   
        }
         echo  " ";
    }
    
    
    public function gender(){
        if($this->gender == 'male') {
            return 'مذكر';
        }else{
            return 'أنثى';
        }
    }
    
    
    
    public function is_admin(){
        
        if($this->role == $this->admin_role){
            return true;
        }
        
        return false;
    }
}