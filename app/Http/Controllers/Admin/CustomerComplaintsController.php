<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\AppModules;
use App\Models\CustomerLeadComplaints;
use App\Models\ComplaintsPhoto;
use App\Models\ComplaintStatus;
use App\Models\CustomerLeadComplaintStatuses;
use App\Models\CustomerLeadContacts;
use App\Models\RoleModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class CustomerComplaintsController extends Controller
{
    // initial constructor
    public function __construct()
    {
        $route_name = Route::currentRouteName();
        $this->middleware('permissioncheck:'.$route_name);

        $routeParse = explode('_',$route_name);
        if($route_name == 'home'){
            $routeName = 'home';
        }else{
            $routeName = 'manage_'.$routeParse[1];
        }

        $this->module_info = AppModules::get_module_id_by_slug($routeName);
    }

    //getter function to module id from constructor
    public function getModuleId()
    {
        return $this->module_info->id;
    }

    //method to view complaint
    public function list_customer_complaints($customer_id)
    {
        $customer_complaints = CustomerLeadComplaints::where('customer_id', $customer_id)->get();
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        return view('manage-customers.customer-complaints.list-complaints',[
            'app_modules' => $modules,
            'module_access' => $module_access,
            'customer_id' => $customer_id,
            'customer_complaints' => $customer_complaints,
        ]);
    }

    //method to add complaint
    public function add_customer_complaints($customer_id)
    {   
        $customer_contacts = CustomerLeadContacts::where('customer_id',$customer_id)->where('isActive',1)->get();
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        return view('manage-customers.customer-complaints.add-complaint',[
            'app_modules' => $modules,
            'module_access' => $module_access,
            'customer_id' => $customer_id,
            'customer_contacts' => $customer_contacts,
        ]);
    }

    //method to save complaint
    public function save_customer_complaints($customer_id, Request $request)
    {

        $validated = $request->validate([
            'complaints_received_by' => 'required|in:'.Auth::user()->full_name,
            'complaints_raised_by' => 'required|exists:customer_lead_contacts,id',
            'complaints_subject' => 'required|max:100',
            'complaints_description' => 'required|max:4000',
            'complaint_photos.*' => 'nullable',
            'complaint_photos.0' => 'nullable|mimes:jpeg,jpg,png|max:2048',
            'complaint_photos.*' => 'mimes:jpeg,jpg,png|max:2048',
        ],[
            'complaint_photos.0.nullable' => 'The complaint photo field is required.',
            'complaint_photos.*.mimes' => 'The complaint photos must be a file of type: jpeg, jpg, png.',
            'complaint_photos.*.max' => 'The complaint photos must not be greater than 2048 kilobytes.',
        ]);


        $complaint_info = CustomerLeadComplaints::add_complaint($customer_id, Auth::user()->id, $request);

        if ($request->file('complaint_photos')) {
            foreach($request->file('complaint_photos') as $file)
            {
                $name = $file->getClientOriginalName();
                $file->move(public_path().'/uploads/customers/complaint-image/', $name);
                $photos_model = new ComplaintsPhoto();
                $photos_model->complaint_id = $complaint_info->id;
                $photos_model->image_name = $name;
                $photos_model->created = date("Y-m-d h:i:s");
                $photos_model->save();
            }
        }

        //add default complaint status
        if($complaint_info){

            $complaint_status = new CustomerLeadComplaintStatuses();
            $complaint_status->complaint_id = $complaint_info->id;
            $complaint_status->employee_id = Auth::user()->id;
            $complaint_status->complaint_status_id = config('constants.in_progress_complaint_status_id');
            $complaint_status->complaint_status_comments = "This complaint is under review.";
            $complaint_status->created = date('Y-m-d h:i:s');
            $complaint_status->updated = date('Y-m-d h:i:s');
            $complaint_status->save();
        }

        return redirect()->route('viewComplaintDetails_customers', ['customer_id' => $customer_id, 'complaint_id' => $complaint_info->id]);
        
    }


    //method to view customer complaint
    public function view_customer_complaints($customer_id, $complaint_id)
    {
        $complaint_info = CustomerLeadComplaints::where('id', $complaint_id)->where('customer_id', $customer_id)->first();
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        $complaint_statuses = ComplaintStatus::all();
        return view('manage-customers.customer-complaints.view-complaint',[
            'app_modules' => $modules,
            'module_access' => $module_access,
            'customer_id' => $customer_id,
            'complaint_info' => $complaint_info,
            'complaint_statuses' => $complaint_statuses
        ]);
    }
    //method to edit customer complaints detail
    public function edit_customer_complaints($customer_id, $complaint_id)
    {
        $complaint_details = CustomerLeadComplaints::where('id',$complaint_id)->where('customer_id', $customer_id)->first();
        $customer_contacts = CustomerLeadContacts::where('customer_id',$customer_id)->where('isActive',1)->get();
        // dd($complaint_details);
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        return view('manage-customers.customer-complaints.edit-complaint',[
            'app_modules' => $modules,
            'module_access' => $module_access,
            'customer_id' => $customer_id,
            'complaint_details' => $complaint_details,
            'customer_contacts' => $customer_contacts,
        ]);
    }


    //method to update customer complaints
    public function update_customer_complaints($customer_id, $complaint_id, Request $request)
    {
        // validate
        $complaint_details = CustomerLeadComplaints::findOrFail($complaint_id);
        $validated = $request->validate([
            'complaints_raised_by' => 'required',
            'complaints_subject' => 'required|max:100', 
            'complaints_description' => 'required|max:4000',
            'complaint_photos.*' => 'nullable',
            'complaint_photos.0' => 'nullable|mimes:jpeg,jpg,png|max:2048',
            'complaint_photos.*' => 'mimes:jpeg,jpg,png|max:2048',
        ],[
            'complaint_photos.0.required' => 'The complaint photo field is required.',
            'complaint_photos.*.mimes' => 'The complaint photos must be a file of type: jpeg, jpg, png.',
            'complaint_photos.*.max' => 'The complaint photos must not be greater than 2048 kilobytes.',
        ]);

        $complaint_info = CustomerLeadComplaints::update_complaint($complaint_id, $request);

        //add updated complaint photos
        if (!empty($request->file('complaint_photos'))) {
            foreach($request->file('complaint_photos') as $file)
            {
                $name = date("Y_m_d_h_i_s_").$file->getClientOriginalName();
                $file->move(public_path().'/uploads/customers/complaint-image/', $name);
                $photos_model = new ComplaintsPhoto();
                $photos_model->complaint_id = $complaint_info->id;
                $photos_model->image_name = $name;
                $photos_model->created = date("Y-m-d h:i:s");
                $photos_model->save();
            }
        }
        
        return redirect()->route('viewComplaintDetails_customers', ['customer_id' => $customer_id, 'complaint_id' => $complaint_id]);
    }

    //method to update customer complaint status
    public static function update_complaint_status($customer_id, $complaint_id,Request $request)
    {
        $validated = $request->validate([
            'complaint_status' => 'required',
            'complaint_status_comment' => 'required|max:1400',
        ]);

        $complaint_status_info = CustomerLeadComplaintStatuses::add_status($complaint_id, $request);

        return redirect()->route('viewComplaintDetails_customers', ['customer_id' => $customer_id, 'complaint_id' => $complaint_id]);
    }

    //method to delete complaint photo 
    public static function delete_complaint_photo(Request $request)
    {
        // dd($request);
        $delete_photo = ComplaintsPhoto::delete_complaint_photo($request->id);
        return json_encode(
            array(
                'status' => true,
                'is_deleted' => $delete_photo
            )
        );
    }
}
