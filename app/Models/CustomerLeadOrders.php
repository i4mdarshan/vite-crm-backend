<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerLeadOrders extends Model
{
    use HasFactory;

    //method to search orders
    public function scopeSearch($query, $term,$customer_id)
    {
        $term = "%$term%";
        $query->where('customer_id',$customer_id)->where(function ($query) use($term){
            $query->where('order_no','LIKE',$term);
        });
    }
       
    //method to get all orders
    public static function get_all_orders()
    {
        return CustomerLeadOrders::paginate(10)->onEachSide(1)->withQueryString();
    }
   
    public $timestamps = false;
    protected $table = 'orders';
}
