<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerLeadBehaviours extends Model
{
    use HasFactory;

    //method to search complaints
    public function scopeSearch($query, $term,$customer_id)
    {
        $term = "%$term%";
        $query->where('customer_id',$customer_id)->where(function ($query) use($term){
            $query->where('contact_person_name','LIKE',$term)
            ->orwhere('contact_email','LIKE',$term)
            ->orwhere('contact_number','LIKE',$term);
        });
    }

    //method to update customer behaviour
    public static function update_behaviour($request,$customer_id)
    {
        $customer_behaviour_info = CustomerLeadBehaviours::where('customer_id',$customer_id)->first();
        if (empty($customer_behaviour_info)) {
            $customer_behaviour_info = new CustomerLeadBehaviours();
        }

        $customer_behaviour_info->customer_id =  $customer_id;
        $customer_behaviour_info->nature =  $request->customer_nature;
        $customer_behaviour_info->order_contact = $request->contact_order;
        $customer_behaviour_info->payment_contact = $request->contact_payment;
        $customer_behaviour_info->payment_condition = $request->pay_condition;
        $customer_behaviour_info->order_followups_required = $request->order_followups;
        $customer_behaviour_info->payment_followups_required = $request->payment_followups;
        $customer_behaviour_info->price_cross_checker = $request->price_checker;
        $customer_behaviour_info->payment_safety = $request->payment_safety;
        $customer_behaviour_info->friendly = $request->customer_friendly;
        $customer_behaviour_info->soft_corner = $request->customer_soft_corner;
        $customer_behaviour_info->technical_helping = $request->technical_help;
        $customer_behaviour_info->educated = $request->customer_education;
        $customer_behaviour_info->brand_price_lover = $request->brand_lover;
        $customer_behaviour_info->loyal = $request->loyalty;
        $customer_behaviour_info->years_for_generation = $request->years_generation;
        $customer_behaviour_info->trail_done_before = $request->trail_before;
        $customer_behaviour_info->another_business = $request->other_business;
        $customer_behaviour_info->past_payment_defaulter = $request->past_defaulter;
        $customer_behaviour_info->duration_of_joining = $request->joining_duration;
        $customer_behaviour_info->competitor_conn = $request->conn_competitor;
        $customer_behaviour_info->partnership = $request->customer_partnership;

        if (empty($customer_behaviour_info)) {
            $customer_behaviour_info->updated = date("Y-m-d h:i:s");
        } else {
            $customer_behaviour_info->created = date("Y-m-d h:i:s");
            $customer_behaviour_info->updated = date("Y-m-d h:i:s");
        }
        
        $customer_behaviour_info->save();

        return $customer_behaviour_info;
    }

    public $timestamps = false;
    protected $table = 'customer_lead_behaviour';
}
