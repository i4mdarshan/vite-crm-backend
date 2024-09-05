<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\AppModules;
use App\Models\CustomerLeadAppointments;
use App\Models\CustomerLeadContacts;
use App\Models\CustomerLeadProfile;
use App\Models\RoleModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class LeadAppointmentsController extends Controller
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

    //method to view appointment
    public function list_lead_appointments($lead_id)
    {
        if(isset($_GET['q'])){
            $lead_appointments = CustomerLeadAppointments::search(trim($_GET['q']),$lead_id)->paginate(10)->onEachSide(1)->withQueryString(); 
        }else{
            $lead_appointments = CustomerLeadAppointments::where('customer_id', $lead_id)->paginate(10)->onEachSide(1)->withQueryString();
        }
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        return view('manage-leads.lead-appointments.list-appointments',[
            'app_modules' => $modules,
            'module_access' => $module_access,
            'lead_id' => $lead_id,
            'lead_appointments' => $lead_appointments,
        ]);
    }

    //method to add appointment
    public function add_lead_appointment($lead_id)
    {
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        $customer_contacts = CustomerLeadContacts::where('customer_id',$lead_id)->where('isActive',1)->get();
        return view('manage-leads.lead-appointments.add-appointment',[
            'app_modules' => $modules,
            'module_access' => $module_access,
            'lead_id' => $lead_id,
            'customer_contacts' => $customer_contacts
        ]);
    }

    //method to save appointment
    public function save_lead_appointment($lead_id, Request $request)
    {
        $lead = CustomerLeadProfile::findOrFail($lead_id);
        $validated = $request->validate([
            'appointment_date' => 'required|after_or_equal:today',
            'appointment_time' => 'required',
            'appointment_with' => ['required', Rule::exists('customer_lead_contacts','id')->where('customer_id', $lead_id)->where('isActive',1)],
            'appointment_description' => 'required|max:1500',
        ]);
        $employee_id = Auth::user()->id;
        $appointment_info = CustomerLeadAppointments::add_appointment($employee_id,$lead_id,$request,$lead->isLead);

        return redirect()->route('viewAppointmentDetails_leads',['appointment_id' => $appointment_info->id, 'lead_id' => $lead_id]);
    }

    //method to view lead appointment
    public function view_lead_appointment($lead_id, $appointment_id)
    {
        $appointment_info = CustomerLeadAppointments::where('id', $appointment_id)->where('customer_id', $lead_id)->first();
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        return view('manage-leads.lead-appointments.view-appointment',[
            'app_modules' => $modules,
            'module_access' => $module_access,
            'lead_id' => $lead_id,
            'appointment_info' => $appointment_info,
        ]);
    }
}
