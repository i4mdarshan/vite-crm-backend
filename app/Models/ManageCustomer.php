<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageCustomer extends Model
{
    use HasFactory;

    //method to get all customers
    public static function get_all_customers()
    {
        return ManageCustomer::all();
    }
    //function to get user details
    public function employee()
    {
        return $this->belongsTo(User::class,'employee_id');
    }

    //function to get details of assigned to employee
    public function assigned()
    {
        return $this->belongsTo(User::class, 'customer_assigned_to');
    }

    //function to save customer
    public static function add_customers($request, $employee_id)
    {
        $customer_info = new ManageCustomer;
        $customer_info->employee_id = $employee_id;
        $customer_info->customer_name = $request->customer_name;
        $customer_info->customer_type = $request->customer_type;
        $customer_info->customer_assigned_to = $request->customer_assigned_to;
        $customer_info->customer_website = $request->customer_website;
        $customer_info->customer_no1 = $request->customer_no1;
        $customer_info->customer_no2 = $request->customer_no2;
        $customer_info->customer_mail = $request->customer_mail;
        $customer_info->customer_mail2 = $request->customer_mail2;
        $customer_info->customer_country = $request->customer_country;
        $customer_info->customer_state = $request->customer_state;
        $customer_info->customer_district = $request->customer_district;
        $customer_info->customer_taluka = $request->customer_taluka;
        $customer_info->customer_zip_code = $request->customer_zip_code;
        $customer_info->customer_address = $request->customer_address;
        $customer_info->customer_notes = $request->customer_notes;
        $customer_info->isActive = $request->customer_status;
        $customer_info->created = date("Y-m-d h:i:s");
        $customer_info->updated = date("Y-m-d h:i:s");
        $customer_info->save();

        return $customer_info;

    }

    //method to update customer
    public static function update_customer($customer_id, $request)
    {
        $customer_info = ManageLead::findOrFail($customer_id);
        $customer_info->customer_name = isset($request->customer_name) ? $request->customer_name : $customer_info->customer_name ;
        $customer_info->customer_type = isset($request->customer_type) ? $request->customer_type : $customer_info->customer_type;
        $customer_info->customer_website = $request->customer_website;
        $customer_info->customer_no1 = isset($request->customer_no1) ? $request->customer_no1 : $customer_info->customer_no1;
        $customer_info->customer_no2 = $request->customer_no2;
        $customer_info->customer_mail = isset($request->customer_mail) ? $request->customer_mail : $customer_info->customer_mail;
        $customer_info->customer_mail2 = $request->customer_mail2;
        $customer_info->customer_country = isset($request->customer_country) ? $request->customer_country : $customer_info->customer_country;
        $customer_info->customer_state = isset($request->customer_state) ? $request->customer_state : $customer_info->customer_state;
        $customer_info->customer_district = isset($request->customer_district) ? $request->customer_district : $customer_info->customer_district;
        $customer_info->customer_taluka = isset($request->customer_taluka) ? $request->customer_taluka : $customer_info->customer_taluka;
        $customer_info->customer_zip_code = isset($request->customer_zip_code) ? $request->customer_zip_code : $customer_info->customer_zip_code;
        $customer_info->customer_address = isset($request->customer_address) ? $request->customer_address : $customer_info->customer_address;
        $customer_info->customer_notes = isset($request->customer_notes) ? $request->customer_notes : $customer_info->customer_notes;
        $customer_info->isActive = isset($request->customer_status) ? $request->customer_status : $customer_info->isActive;
        $customer_info->updated = date("Y-m-d h:i:s");
        $customer_info->save();

        return $customer_info;
    }
    
    public $timestamps = false;
    protected $table = 'customer_profile';
}
