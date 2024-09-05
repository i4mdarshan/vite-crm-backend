<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerLeadAppointments extends Model
{
    use HasFactory;

    //relation to get customer/lead profile
    public function customer()
    {
        return $this->belongsTo(CustomerLeadProfile::class,'customer_id');
    }

    //relation to get appointment with details
    public function appointmentWith()
    {
        return $this->belongsTo(CustomerLeadContacts::class,'appointment_with');
    }

    //relation to get appointment added by 
    public function addedBy()
    {
        return $this->belongsTo(User::class,'employee_id');
    }

    // relation to get customer/lead name
    public function customerLeadDetails()
    {
        return $this->belongsTo(CustomerLeadProfile::class,'customer_id');
    }

    //method to search appointment
    public function scopeSearch($query, $term,$customer_id)
    {
        $term = "%$term%";
        $query->where('customer_id',$customer_id)->where(function ($query) use($term){
            $query->where('appointment_with','LIKE',$term)
            ->orwhere('appointment_time','LIKE',$term)
            ->orWhereHas('appointmentWith',function($query) use($term){
                $query->where('contact_person_name', 'LIKE', $term);
            });
        });
    }

    //function to add appointment
    public static function add_appointment($employee_id, $customer_id, $request, $isLead)
    {
        $appointment = new CustomerLeadAppointments;
        $appointment->employee_id = $employee_id;
        $appointment->customer_id = $customer_id;
        $appointment->appointment_date = $request->appointment_date;
        $appointment->appointment_time = $request->appointment_time;
        $appointment->appointment_with = $request->appointment_with;
        $appointment->appointment_description = $request->appointment_description;
        $appointment->isLead = $isLead;
        $appointment->created = date('Y-m-d h:i:s');
        $appointment->updated = date('Y-m-d h:i:s');
        $appointment->save();

        return $appointment;

    }

    public $timestamps = false;
    protected $table = 'customer_lead_appointments';
}
