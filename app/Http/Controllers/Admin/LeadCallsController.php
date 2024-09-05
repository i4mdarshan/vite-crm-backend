<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\AppModules;
use App\Models\CustomerLeadCalls;
use App\Models\CustomerLeadContacts;
use App\Models\CustomerLeadProfile;
use App\Models\RoleModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class LeadCallsController extends Controller
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

     //method to view lead calls
    public function list_lead_calls($lead_id)
    {   
        if(isset($_GET['q'])){
            $lead_calls_details = CustomerLeadCalls::search(trim($_GET['q']),$lead_id)->orderBy('created','DESC')->paginate(10)->onEachSide(1)->withQueryString(); 
        }else{
            $lead_calls_details = CustomerLeadCalls::where('customer_id', $lead_id)->orderBy('created','DESC')->paginate(10)->onEachSide(1)->withQueryString();
        }
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        return view('manage-leads.lead-calls.list-lead-calls',[
            'app_modules' => $modules,
            'module_access' => $module_access,
            'lead_id' => $lead_id,
            'lead_calls_details' =>$lead_calls_details,
        ]);
    }

    //method to add lead calls
    public function add_lead_calls($lead_id)
    {
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        $customer_contacts = CustomerLeadContacts::where('customer_id',$lead_id)->where('isActive',1)->get();
        return view('manage-leads.lead-calls.add-lead-calls',[
            'app_modules' => $modules,
            'module_access' => $module_access,
            'lead_id' => $lead_id,
            'customer_contacts' => $customer_contacts
        ]);
    }

    //method to save lead calls
    public function save_lead_calls($lead_id, Request $request)
    {
        $lead = CustomerLeadProfile::findOrFail($lead_id);
        // validate
        $validated = $request->validate([
            'call_date' => 'required',
            'call_time' => 'required',
            'call_description' => 'required|max:1500',
            'call_with' => ['required', Rule::exists('customer_lead_contacts','id')->where('customer_id', $lead_id)->where('isActive',1)],
        ]);

        $call_info = CustomerLeadCalls::add_calls($lead_id, Auth::user()->id, $request,$lead->isLead);

        return redirect()->route('viewCallsDetails_leads', ['lead_id' => $lead_id, 'call_id' => $call_info->id]);
    }

    //method to view lead calls
    public function view_lead_calls($lead_id, $calls_id)
    {
        $calls_info = CustomerLeadCalls::where('id', $calls_id)->where('customer_id', $lead_id)->first();
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        return view('manage-leads.lead-calls.view-calls',[
            'app_modules' => $modules,
            'module_access' => $module_access,
            'lead_id' => $lead_id,
            'calls_info' => $calls_info,
        ]);
    }

}



?>