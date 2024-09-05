<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomersCollections extends Model
{
    use HasFactory;

    // relation to get collection received by details
    public function received_by()
    {
        return $this->belongsTo(User::class,'collected_by_person_name');
    }

    //  relation to get collection raised by details
    public function raised_by()
    {
        return $this->belongsTo(CustomerLeadContacts::class,'collected_from_person_name');
    }

    //relation to get customer company details
    public function customer()
    {
        return $this->belongsTo(CustomerLeadProfile::class,'customer_id');
    }

    //method to search collections
    public function scopeSearch($query, $term,$customer_id)
    {
        $term = "%$term%";
        $query->where('customer_id',$customer_id)->where(function ($query) use($term){
            $query->where('collected_by_person_name','LIKE',$term)
            ->orwhere('collected_from_person_name','LIKE',$term);
        });
    }

    //method to add collection
    public static function add_collection($customer_id,$employee_id,$request)
    {
        $collection_info = new CustomersCollections;
        $collection_info->employee_id = $employee_id;
        $collection_info->customer_id = $customer_id;
        $collection_info->collected_by_person_name = $request->collected_person_name;
        $collection_info->money_received = $request->received_money;
        $collection_info->money_received_date = $request->received_money_date;
        $collection_info->collected_from_person_name = $request->person_name_collected_from;
        $collection_info->money_pending = $request->pending_money;
        $collection_info->money_pending_date = $request->pending_money_date;
        $collection_info->mode_of_payment = $request->mode_of_payment;
        $collection_info->status = $request->collection_status;
        $collection_info->created = date('y-m-d h:i:s');
        $collection_info->updated = date('y-m-d h:i:s');
        $collection_info->save();

        return $collection_info;
    }

    //method to update collection
    public static function update_collection($collection_id, $request)
    {
        $collection_info = CustomersCollections::findOrFail($collection_id);
        $collection_info->collected_by_person_name = isset($request->collected_person_name) ? $request->collected_person_name : $collection_info->collected_by_person_name ;
        $collection_info->money_received = isset($request->received_money) ? $request->received_money : $collection_info->received_money;
        $collection_info->money_received_date = isset($request->received_money_date) ? $request->received_money_date : $collection_info->money_received_date;
        $collection_info->collected_from_person_name = isset($request->person_name_collected_from) ? $request->person_name_collected_from : $collection_info->collected_from_person_name ;
        $collection_info->money_pending = isset($request->pending_money) ? $request->pending_money : $collection_info->money_pending;
        $collection_info->money_pending_date = $request->pending_money_date;
        $collection_info->mode_of_payment = isset($request->mode_of_payment) ? $request->mode_of_payment : $collection_info->mode_of_payment;
        $collection_info->status = isset($request->collection_status) ? $request->collection_status : $collection_info->status;
        $collection_info->updated = date('y-m-d h:i:s');
        $collection_info->save();
        return $collection_info;
    }

    public $timestamps = false;
    protected $table = 'collection';
}
