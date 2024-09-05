<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategories extends Model
{
    use HasFactory;


    //method to get products
    public function products()
    {
        return $this->hasMany(ProductDetails::class,'product_category');
    }

    // relation to get products from orders particulars table
    public function ordered_products()
    {
        return $this->hasMany(CustomerOrderParticulars::class, 'product_category_id');
    }

    // relation to get products from quotations particulars table
    public function quotation_products()
    {
        return $this->hasMany(QuotationParticulars::class, 'product_category_id');
    }

    //method to list product categories
    public static function get_all_product_categories($active = 0)
    {
        if($active == 1){
            return ProductCategories::where('isActive',1)->get();
        }
        return ProductCategories::all();
    }


    //method to add product category name
    public static function add_product_category_name($request)
    {
        $product_category = new ProductCategories;
        $product_category->category_name = $request->product_category_name;
        $product_category->isActive = $request->product_category_status;
        $product_category->created = date("Y-m-d h:i:s");
        $product_category->updated = date("Y-m-d h:i:s");
        $product_category->save();

        return $product_category;
    }

    //method to update product category
    public static function update_product_category($request, $category_id)
    {
        $product_category = ProductCategories::findOrFail($category_id);
        $product_category->category_name = isset($request->product_category_name) ? $request->product_category_name : $product_category->category_name;
        $product_category->isActive = isset($request->product_category_status) ? $request->product_category_status : $product_category->isActive;
        $product_category->updated = date("Y-m-d h:i:s");
        $product_category->save();
        return $product_category;
    }


    public $timestamps = false;
    protected $table = 'product_category';

}
