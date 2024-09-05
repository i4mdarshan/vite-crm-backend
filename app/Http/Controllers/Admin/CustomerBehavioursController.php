<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\AppModules;
use App\Models\CustomerLeadBehaviours;
use App\Models\RoleModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class CustomerBehavioursController extends Controller
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

    //method to view customer behaviour detail
    public function view_customer_behaviour_detail($customer_id)
    {
        // dd($customer_id);
        $behaviour_details = CustomerLeadBehaviours::where('customer_id', $customer_id)->first();
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        return view('manage-customers.customer-behaviours.view-customer-behaviour',[
            'app_modules' => $modules,
            'module_access' => $module_access,
            'customer_id' => $customer_id,
            'behaviour_details' => $behaviour_details,
        ]);
    }

    //method to edit customer behaviour detail
    public function edit_customer_behaviour($customer_id)
    {
        // dd($customer_id);
        $behaviour_details = CustomerLeadBehaviours::where('customer_id', $customer_id)->first();
        // dd($behaviour_details);
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        return view('manage-customers.customer-behaviours.edit-customer-behaviour',[
            'app_modules' => $modules,
            'module_access' => $module_access,
            'customer_id' => $customer_id,
            'behaviour_details' => $behaviour_details,
        ]);
    }

    //method to update customer behaviour
    public function update_customer_behaviour($customer_id, Request $request)
    {   
        $validated = $request->validate([
            "customer_nature" => "nullable|max:40",
            "contact_order" => "nullable|max:40",
            "contact_payment" => "nullable|max:40",
            "pay_condition" => "nullable",
            "order_followups" => "nullable|in:yes,no",
            "payment_followups" => "nullable|in:yes,no",
            "price_checker" => "nullable|in:yes,no",
            "payment_safety" => "nullable|in:yes,no",
            "customer_friendly" => "nullable|in:yes,no",
            "customer_soft_corner" => "nullable|max:40",
            "technical_help" => "nullable|in:yes,no",
            "customer_education" => "nullable|in:yes,no",
            "brand_lover" => "nullable|in:brand_lover,price_lover",
            "loyalty" => "nullable|in:yes,no",
            "years_generation" => "nullable|max:40",
            "trail_before" => "nullable|max:40",
            "other_business" => "nullable|in:yes,no",
            "past_defaulter" => "nullable|max:40",
            "joining_duration" => "nullable|max:40",
            "conn_competitor" => "nullable|max:40",
            "customer_partnership" => "nullable|max:40",
        ]);

        //save the customer data to the database
        $customer_behaviour_info = CustomerLeadBehaviours::update_behaviour($request, $customer_id);

        return redirect()->route('viewBehaviourDetails_customers', ['customer_id' => $customer_behaviour_info->customer_id]);
    }
}
