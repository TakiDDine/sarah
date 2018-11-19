<?php




namespace App\Models;
use illuminate\database\eloquent\model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination;
use \App\Models\ProductCategories;


class Product extends model{


    protected $admin_role = 2;
    protected $table = 'products';
    
    protected $guarded = ['id', 'created_at', 'updated_at'];
    
 
    public function ThumbnailsImages(){
        $gallers = explode('//', $this->gallery);
        
        $gallery['1'] = $gallers[0];
        $gallery['2'] = $gallers[1];
        
        return $gallery;
        
    }
    
    public function gallery(){
        return explode('//', $this->gallery); 
    }
    
    
public function category(){
    
    $product = ProductCategories::where('id',$this->categoryID)->first();
    
    if($product){    
        return $product->name;
    }
    return 'N/A';
    
    }
    
    

}