<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class ManageCustomerCalls extends Model
{
    use HasFactory;

    //method to add calls
    public static function add_calls($customer_id,$employee_id,$request)
    {
        $calls_info = new ManageCustomerCalls;
        $calls_info->employee_id = $employee_id;
        $calls_info->customer_id = $customer_id;
        $calls_info->call_date = $request->call_date;
        $calls_info->call_time = $request->call_time; 
        $calls_info->call_description = $request->call_description;
        $calls_info->created = date('y-m-d h:i:s');
        $calls_info->updated = date('y-m-d h:i:s');
        $calls_info->save();

        return $calls_info;
    }

    public $timestamps = false;
    protected $table = 'customer_calls';
}
