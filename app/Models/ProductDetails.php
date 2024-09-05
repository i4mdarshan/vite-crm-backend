<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class ProductDetails extends Model
{
    use HasFactory;

    //relation to get product category
    public function category()
    {
        return $this->belongsTo(ProductCategories::class,'product_category');
    }

    //relation to get product unit
    public function unit()
    {
        return $this->belongsTo(ProductUnit::class,'product_unit');
    }

    //method to search product
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use($term){
            $query->where('product_name','LIKE',$term)
            ->orWhere('product_origin','LIKE',$term)
            ->orWhere('product_hsn','LIKE',$term)
            ->orWhere('product_packaging','LIKE',$term)
            ->orWhereHas('category',function($query) use($term){
                $query->where('category_name', 'LIKE', $term);
            });
        });
    }

    //method to list products
    public static function get_all_products($active = 0)
    {
        if($active == 1){
            return ProductDetails::where('isActive',1)->orderBy('created','desc')->paginate(10)->onEachSide(1)->withQueryString();
        }
        return ProductDetails::orderBy('created','desc')->paginate(10)->onEachSide(1)->withQueryString();
    }

    //method to add product
    public static function add_product($request)
    {
        $product_details = new ProductDetails;
        $product_details->product_name = $request->product_name;
        $product_details->product_category = $request->product_category;
        $product_details->product_origin = $request->product_origin;
        $product_details->product_hsn = $request->product_hsn;
        $product_details->product_packaging = $request->product_packaging;
        $product_details->product_tax = $request->product_tax;

        if($request->hasFile('product_tds')){
            $name = date("Y_m_d_h_i_s_").$request->file('product_tds')->getClientOriginalName();
            $request->file('product_tds')->move(public_path().'/uploads/products/product_tds/', $name);
            $product_details->product_tds = $name;
        }

        if($request->hasFile('product_msds')){
            $name = date("Y_m_d_h_i_s_").$request->file('product_msds')->getClientOriginalName();
            $request->file('product_msds')->move(public_path().'/uploads/products/product_msds/', $name);
            $product_details->product_msds = $name;
        }

        // save new product unit 
        if(!is_numeric($request->product_unit)){
            $new_unit = ProductUnit::add_unit($request->product_unit);
            $product_details->product_unit = $new_unit->id;
        }else{
            $product_details->product_unit = $request->product_unit;
        }

        $product_details->isActive = $request->product_status;
        $product_details->created = date("Y-m-d h:i:s");
        $product_details->updated = date("Y-m-d h:i:s");
        $product_details->save();

        return $product_details;
    }

    //method to update product
    public static function update_product($request, $product_id)
    {
        $product_details = ProductDetails::findOrFail($product_id);
        $product_details->product_name = isset($request->product_name) ? $request->product_name : $product_details->product_name;
        $product_details->product_category = isset($request->product_category) ? $request->product_category : $product_details->product_category;
        $product_details->product_origin = isset($request->product_origin) ? $request->product_origin : $product_details->product_origin;
        $product_details->product_hsn = isset($request->product_hsn) ? $request->product_hsn : $product_details->product_hsn;
        $product_details->product_packaging = isset($request->product_packaging) ? $request->product_packaging : $product_details->product_packaging;
        $product_details->product_tax = isset($request->product_tax) ? $request->product_tax : $product_details->product_tax;

        // save new product unit 
        if(!is_numeric($request->product_unit) && isset($request->product_unit)){
            $new_unit = ProductUnit::add_unit($request->product_unit);
            $product_details->product_unit = $new_unit->id;
        }else{
            $product_details->product_unit = $request->product_unit;
        }

        if(request()->hasFile('product_tds')){
            if($product_details->product_tds){
                $imagePath = public_path().'/uploads/products/product_tds/'.$product_details->product_tds;
                if(File::exists($imagePath)){
                    unlink($imagePath);
                }
            }
            $name = date("Y_m_d_h_i_s_").request()->file('product_tds')->getClientOriginalName();
            request()->file('product_tds')->move(public_path().'/uploads/products/product_tds/', $name);
            $product_details->product_tds = $name;
        }

        if(request()->hasFile('product_msds')){
            if($product_details->product_msds){
                $imagePath = public_path().'/uploads/products/product_msds/'.$product_details->product_msds;
                if(File::exists($imagePath)){
                    unlink($imagePath);
                }
            }
            $name = date("Y_m_d_h_i_s_").request()->file('product_msds')->getClientOriginalName();
            request()->file('product_msds')->move(public_path().'/uploads/products/product_msds/', $name);
            $product_details->product_msds = $name;
        }
        
        $product_details->isActive = isset($request->product_status) ? $request->product_status : $product_details->isActive;
        $product_details->updated = date("Y-m-d h:i:s");
        $product_details->save();

        return $product_details;
    }


    public $timestamps = false;
    protected $table = 'product_details';
}
