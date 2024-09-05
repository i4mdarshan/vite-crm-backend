<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerLeadCalls extends Model
{
    use HasFactory;

    //relation to get contact person details
    public function callWith()
    {
        return $this->belongsTo(CustomerLeadContacts::class,'call_with');
    }

    //relation to get call added by 
    public function addedBy()
    {
        return $this->belongsTo(User::class,'employee_id');
    }

    // relation to get customer/lead name
    public function customerLeadDetails()
    {
        return $this->belongsTo(CustomerLeadProfile::class,'customer_id');
    }

    //method to search calls
    public function scopeSearch($query, $term,$customer_id)
    {
        $term = "%$term%";
        $query->where('customer_id',$customer_id)->where(function ($query) use($term){
            $query->where('call_time','LIKE',$term)
            ->orWhereHas('callWith',function($query) use($term){
                $query->where('contact_person_name', 'LIKE', $term);
            });
        });
    }

     //method to add calls
     public static function add_calls($customer_id,$employee_id,$request,$isLead)
     {
         $calls_info = new CustomerLeadCalls;
         $calls_info->employee_id = $employee_id;
         $calls_info->customer_id = $customer_id;
         $calls_info->call_date = $request->call_date;
         $calls_info->call_time = $request->call_time; 
         $calls_info->call_description = $request->call_description;
         $calls_info->call_with = $request->call_with;
         $calls_info->isLead = $isLead;
         $calls_info->created = date('y-m-d h:i:s');
         $calls_info->updated = date('y-m-d h:i:s');
         $calls_info->save();
 
         return $calls_info;
     }

     public $timestamps = false;
     protected $table = 'customer_lead_calls';
}
