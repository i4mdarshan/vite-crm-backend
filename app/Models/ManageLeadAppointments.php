<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageLeadAppointments extends Model
{
    use HasFactory;

    //function to add appointment
    public static function add_appointment($employee_id, $lead_id, $request)
    {
        $appointment = new ManageLeadAppointments;
        $appointment->employee_id = $employee_id;
        $appointment->lead_id = $lead_id;
        $appointment->appointment_date = $request->appointment_date;
        $appointment->appointment_time = $request->appointment_time;
        $appointment->appointment_with = $request->appointment_with;
        $appointment->appointment_description = $request->appointment_description;
        $appointment->created = date('Y-m-d h:i:s');
        $appointment->updated = date('Y-m-d h:i:s');
        $appointment->save();

        return $appointment;

    }

    public $timestamps = false;
    protected $table = 'lead_appointments';
}
