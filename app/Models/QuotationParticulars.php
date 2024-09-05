<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationParticulars extends Model
{
    use HasFactory;

    //relation to get product details
    public function product()
    {
        return $this->belongsTo(ProductDetails::class,'product_id');
    }

    //relation to get unit details
    public function unit()
    {
        return $this->belongsTo(ProductUnit::class,'product_unit');
    }

    public $timestamps = false;
    protected $table="quotation_particulars";
}
