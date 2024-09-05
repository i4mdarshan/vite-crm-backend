<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageLead extends Model
{
    use HasFactory;

    //function to get user details
    public function employee()
    {
        return $this->belongsTo(User::class,'employee_id');
    }

    //function to get details of assigned to employee
    public function assigned()
    {
        return $this->belongsTo(User::class, 'lead_assigned_to');
    }

    //function to save lead
    public static function add_lead($request, $employee_id)
    {
        $lead_info = new ManageLead;
        $lead_info->employee_id = $employee_id;
        $lead_info->lead_name = $request->lead_name;
        $lead_info->lead_type = $request->lead_type;
        $lead_info->lead_assigned_to = $request->assigned_to;
        $lead_info->lead_web = $request->lead_web;
        $lead_info->lead_no_1 = $request->lead_no_1;
        $lead_info->lead_no_2 = $request->lead_no_2;
        $lead_info->lead_mail_1 = $request->lead_mail_1;
        $lead_info->lead_mail_2 = $request->lead_mail_2;
        $lead_info->lead_district = $request->lead_district;
        $lead_info->lead_taluka = $request->lead_taluka;
        $lead_info->lead_address = $request->lead_address;
        $lead_info->lead_converted = $request->lead_converted;
        $lead_info->isActive = $request->lead_status;
        $lead_info->created = date("Y-m-d h:i:s");
        $lead_info->updated = date("Y-m-d h:i:s");
        $lead_info->save();

        return $lead_info;
    }


    //method to update lead
    public static function update_lead($lead_id, $request)
    {
        $lead_info = ManageLead::findOrFail($lead_id);
        $lead_info->lead_name = isset($request->lead_name) ? $request->lead_name : $lead_info->lead_name ;
        $lead_info->lead_type = isset($request->lead_type) ? $request->lead_type : $lead_info->lead_type;
        $lead_info->lead_web = $request->lead_web;
        $lead_info->lead_no_1 = isset($request->lead_no_1) ? $request->lead_no_1 : $lead_info->lead_no_1;
        $lead_info->lead_no_2 = $request->lead_no_2;
        $lead_info->lead_mail_1 = isset($request->lead_mail_1) ? $request->lead_mail_1 : $lead_info->lead_mail_1;
        $lead_info->lead_mail_2 = $request->lead_mail_2;
        $lead_info->lead_district = isset($request->lead_district) ? $request->lead_district : $lead_info->lead_district;
        $lead_info->lead_taluka = isset($request->lead_taluka) ? $request->lead_taluka : $lead_info->lead_taluka;
        $lead_info->lead_address = isset($request->lead_address) ? $request->lead_address : $lead_info->lead_address;
        // $lead_info->lead_converted = $request->lead_converted;
        $lead_info->isActive = isset($request->lead_status) ? $request->lead_status : $lead_info->isActive;
        $lead_info->updated = date("Y-m-d h:i:s");
        $lead_info->save();

        return $lead_info;
    }

    public $timestamps = false;
    protected $table = 'lead_profile';
}
