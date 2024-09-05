<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductUnit extends Model
{
    use HasFactory;

    //method to create new product unit
    public static function add_unit($product_unit)
    {
        $new_unit = new ProductUnit();
            $new_unit->name = str_replace(' ','_',strtolower($product_unit));
            $new_unit->created = date("Y-m-d h:i:s");
            $new_unit->updated = date("Y-m-d h:i:s");
            $new_unit->save();
        return $new_unit;
    }

    public $timestamps = false;
    protected $table = "product_units";
}
