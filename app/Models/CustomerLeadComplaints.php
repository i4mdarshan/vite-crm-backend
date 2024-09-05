<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerLeadComplaints extends Model
{
    use HasFactory;

    //relation to get complaint status
    public function statuses()
    {
        return $this->hasMany(CustomerLeadComplaintStatuses::class, 'complaint_id')->orderBy('updated','desc');
    }

    //relation to get employee details of the employee
    public function employee()
    {
        return $this->belongsTo(User::class, 'complaint_received_by');
    }
    
    //relation to get complained raised by details
    public function contact()
    {
        return $this->belongsTo(CustomerLeadContacts::class,'complaint_raised_by');
    }

    //relation to get complaint photos
    public function photos()
    {
        return $this->hasMany(ComplaintsPhoto::class,'complaint_id');
    }

    //relation get complaint received
    public function received_by()
    {
        return $this->belongsTo(User::class,'complaint_received_by');
    }

    //relation to get complaint raised by user info
    public function raised_by()
    {
        return $this->belongsTo(CustomerLeadContacts::class,'complaint_raised_by');
    }

    //function to add complaints
    public static function add_complaint($customer_id, $employee_id,$request)
    {
        $complaint = new CustomerLeadComplaints;
        $complaint->customer_id = $customer_id;
        $complaint->complaint_received_by = $employee_id;
        $complaint->complaint_raised_by = $request->complaints_raised_by;
        $complaint->complaint_subject = $request->complaints_subject;
        $complaint->complaint_description = $request->complaints_description;
        $complaint->created = date('Y-m-d h:i:s');
        $complaint->updated = date('Y-m-d h:i:s');
        $complaint->save();

        return $complaint;

    }

    //method to update contact
    public static function update_complaint($complaint_id, $request)
    {
        // dd($request);
        $complaint_info = CustomerLeadComplaints::findOrFail($complaint_id);
        $complaint_info->complaint_received_by = Auth::user()->id != $complaint_info->complaint_received_by ? Auth::user()->id : $complaint_info->complaint_received_by;
        $complaint_info->complaint_raised_by = isset($request->complaints_raised_by) ? $request->complaints_raised_by : $complaint_info->complaint_raised_by;
        $complaint_info->complaint_subject = isset($request->complaints_subject) ? $request->complaints_subject : $complaint_info->complaint_subject;
        $complaint_info->complaint_description = isset($request->complaints_description) ? $request->complaints_description : $complaint_info->complaint_description;

        // if(request()->hasFile('complaint_photos')){
        //     if($complaint_info->complaint_photos){
        //         $imagePath = public_path().'/uploads/customers/complaint-image/'.$complaint_info->complaint_photos;
        //         if(File::exists($imagePath)){
        //             unlink($imagePath);
        //         }
        //     }
        //     $name = date("Y_m_d_h_i_s_").request()->file('complaint_photos')->getClientOriginalName();
        //     request()->file('complaint_photos')->move(public_path().'/uploads/customers/complaint-image/', $name);
        //     $complaint_info->complaint_photos = $name;
        // }

        $complaint_info->updated = date('y-m-d h:i:s');
        $complaint_info->save();
        return $complaint_info;
    }

    public $timestamps = false;
    protected $table = 'customer_lead_complaints';
}
