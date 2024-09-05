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

class CustomerCallsController extends Controller
{
    
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

     //method to view customer calls
    public function list_customer_calls($customer_id)
    { 
        if(isset($_GET['q'])){
            $customer_calls_details = CustomerLeadCalls::search(trim($_GET['q']),$customer_id)->orderBy('created','DESC')->paginate(10)->onEachSide(1)->withQueryString(); 
        }else{  
            $customer_calls_details = CustomerLeadCalls::where('customer_id', $customer_id)->orderBy('created','DESC')->paginate(10)->onEachSide(1)->withQueryString();
        }
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        return view('manage-customers.customer-calls.list-customer-calls',[
            'app_modules' => $modules,
            'module_access' => $module_access,
            'customer_id' => $customer_id,
            'customer_calls_details' =>$customer_calls_details,
        ]);
    }
    

    //method to add customer calls
    public function add_customer_calls($customer_id)
    {
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        $customer_contacts = CustomerLeadContacts::where('customer_id',$customer_id)->where('isActive',1)->get();
        return view('manage-customers.customer-calls.add-customer-calls',[
            'app_modules' => $modules,
            'module_access' => $module_access,
            'customer_id' => $customer_id,
            'customer_contacts' => $customer_contacts,
        ]);
    }

    //method to save customer calls
    public function save_customer_calls($customer_id, Request $request)
    {
        $customer = CustomerLeadProfile::findOrFail($customer_id);
        // validate
        $validated = $request->validate([
            'call_date' => 'required',
            'call_time' => 'required',
            'call_description' => 'required|max:1500',
            'call_with' => ['required', Rule::exists('customer_lead_contacts','id')->where('customer_id', $customer_id)->where('isActive',1)],
        ]);

        $call_info = CustomerLeadCalls::add_calls($customer_id, Auth::user()->id, $request, $customer->isLead);

        return redirect()->route('viewCallsDetails_customers', ['customer_id' => $customer_id, 'call_id' => $call_info->id]);
    }

    //method to view customer calls
    public function view_customer_calls($customer_id, $calls_id)
    {
        $calls_info = CustomerLeadCalls::where('id', $calls_id)->where('customer_id', $customer_id)->first();
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        return view('manage-customers.customer-calls.view-calls',[
            'app_modules' => $modules,
            'module_access' => $module_access,
            'customer_id' => $customer_id,
            'calls_info' => $calls_info,
        ]);
    }

}
