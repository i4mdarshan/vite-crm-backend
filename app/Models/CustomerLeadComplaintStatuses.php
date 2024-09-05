<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CustomerLeadComplaintStatuses extends Model
{
    use HasFactory;

    // relation to get complaint status name
    public function status()
    {
        return $this->belongsTo(ComplaintStatus::class,'complaint_status_id');
    }

    //relation to get employee details
    public function employee()
    {
        return $this->belongsTo(User::class,'employee_id');
    } 

    //method to add complaint status
    public static function add_status($complaint_id, $request)
    {
        $complaint_status_info = new CustomerLeadComplaintStatuses();
        $complaint_status_info->employee_id = Auth::user()->id;
        $complaint_status_info->complaint_id = $complaint_id;
        $complaint_status_info->complaint_status_id = $request->complaint_status;    
        $complaint_status_info->complaint_status_comments = $request->complaint_status_comment;    
        $complaint_status_info->created = date("Y-m-d h:i:s");
        $complaint_status_info->updated = date("Y-m-d h:i:s");
        $complaint_status_info->save();

        return $complaint_status_info;
    }

    protected $table = "customer_lead_complaint_status";
    public $timestamps = false;
}
