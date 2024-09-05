<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\AppModules;
use App\Models\CustomerLeadProfile;
use App\Models\CustomerLeadContacts;
use App\Models\CustomerLeadCalls;
use App\Models\RoleModule;
use App\Models\States;
use App\Models\User;
use App\Rules\ValidateLeadNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class LeadsController extends Controller
{

    // initial constructor
    public function __construct()
    {
        $route_name = Route::currentRouteName();
        $this->middleware('permissioncheck:' . $route_name);

        $routeParse = explode('_', $route_name);
        if ($route_name == 'home') {
            $routeName = 'home';
        } else {
            $routeName = 'manage_' . $routeParse[1];
        }

        $this->module_info = AppModules::get_module_id_by_slug($routeName);
    }

    //getter function to module id from constructor
    public function getModuleId()
    {
        // dd($this->module_info->id);
        return $this->module_info->id;
    }

    //method to list leads 
    public function show_leads()
    {
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);

        if (isset($_GET['q'])) {
            $search_query = trim($_GET['q']);
            $all_leads = CustomerLeadProfile::get_leads_customers_data($isLead = 1,$search_by = $search_query);
        } else {
            $all_leads = CustomerLeadProfile::get_leads_customers_data($isLead = 1);
        }

        return view('manage-leads.list-leads', [
            'app_modules' => $modules,
            'module_access' => $module_access,
            'all_leads' => $all_leads->paginate(15)->onEachSide(1)->withQueryString(),
        ]);
    }

    //method to add lead
    public function add_lead()
    {
        if (Auth::user()->id == config('constants.director_role_id')) {
            $my_employees = User::where('isActive', 1)->where('id','!=',config('constants.director_role_id'))->get();
        } else {
            $my_employees = Auth::user()->child_employees->where('isActive', 1);
        }

        $employee_module_access = 0;
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);

        $employee_module_access = RoleModule::where('role_id', Auth::user()->role_id)->where('module_id', config('constants.manage_employee'));

        if ($employee_module_access->first()) {
            $employee_module_access = $employee_module_access->first('modify_access')->modify_access;
        } else {
            $employee_module_access = null;
        }

        $states = States::all();

        return view('manage-leads.add-lead', [
            'my_employees' => $my_employees,
            'app_modules' => $modules,
            'module_access' => $module_access,
            'employee_module_access' => $employee_module_access,
            'states' => $states
        ]);
    }

    // method to convert lead to customer

    public static function convert_lead($lead_id)
    {
        $lead_info = CustomerLeadProfile::findOrFail($lead_id);
        $lead_info->lead_convert_date = date('Y-m-d h:i:s');
        $lead_info->isLead = 0;
        $lead_info->updated = date('Y-m-d h:i:s');
        $lead_info->save();

        return redirect()->route('manage_leads');
    }

    //method to save lead
    public function save_lead(Request $request)
    {

        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);

        // dd($module_access[0] == 1);

        // validate the form data
        $validated = $request->validate([
            "lead_name" => "required|max:255",
            "lead_owner_name" => "required|max:255",
            "lead_type" => "required",
            "lead_assigned_to" => "required",
            "lead_web" => "nullable|max:100",
            "lead_no_1" => "required|numeric",
            "lead_no_2" => "nullable|numeric",
            "lead_gst_no" => ["required","regex:/^(NA|[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1})$/"],
            "lead_mail_1" => "nullable|email|max:50|unique:customer_lead_profile,customer_mail",
            "lead_mail_2" => "nullable|email|max:50|unique:customer_lead_profile,customer_mail2",
            "lead_manager_name" => "nullable|max:30",
            "lead_manager_number" => "nullable|numeric",
            "lead_accountant_name" => "nullable|max:30",
            "lead_accountant_number" => "nullable|numeric",
            "lead_district" => "required|max:30",
            "lead_state" => "required",
            "lead_taluka" => "required|max:30",
            "lead_pin_code" => "required|numeric",
            "lead_country" => "nullable|max:30",
            "lead_office_country" => "nullable|max:30",
            "lead_office_state" => "nullable",
            "lead_office_district" => "nullable|max:30",
            "lead_office_taluka" => "nullable|max:30",
            "lead_office_pin_code" => "nullable|numeric",
            "address_line_1" => "required|max:30",
            "address_line_2" => "required|max:30",
            "address_line_3" => "nullable|max:30",
            "address_line_4" => "nullable|max:30",
            "address_line_5" => "nullable|max:30",
            "address_line_6" => "nullable|max:30",
            "o_address_line_1" => "nullable|max:30",
            "o_address_line_2" => "nullable|max:30",
            "o_address_line_3" => "nullable|max:30",
            "o_address_line_4" => "nullable|max:30",
            "o_address_line_5" => "nullable|max:30",
            "o_address_line_6" => "nullable|max:30",
            "isActive" => "required",
        ],[
            "lead_gst_no.regex" => "You have entered an invalid GST NO."
        ]);

        //validate the request lead nos
        $lead_no_1 = $request->lead_no_1;
        $lead_no_2 = $request->lead_no_2;

        $unique_check_1 = CustomerLeadProfile::where('customer_no1', $lead_no_1)->orWhereRaw("customer_no2 = " . $lead_no_1)->get();
        if (!empty($lead_no_2)) {
            $unique_check_2 = CustomerLeadProfile::where('customer_no1', $lead_no_2)->orWhereRaw("customer_no2 = " . $lead_no_2)->get();
        } else {
            $unique_check_2 = [];
        }

        // dd(count($unique_check_1) != 0 || count($unique_check_2) != 0);

        if (count($unique_check_1) != 0 || count($unique_check_2) != 0) {
            return back()->withErrors(["message" => "One of Lead Phone 1 or Lead Phone 2 already exists."])->withInput($request->all());
        }

        //save the lead data to the database
        $lead_info = CustomerLeadProfile::add_lead($request);

        return redirect()->route('viewProfile_leads', $lead_info->id);
    }

    //method to view lead detail
    public function view_lead($lead_id)
    {
        if (Auth::user()->id == 1) {
            $lead_details = CustomerLeadProfile::where('id', $lead_id)->first();
        } else {
            // $lead_details = CustomerLeadProfile::where('id', $lead_id)->where('isLead', 1)->whereRaw('(employee_id =' . Auth::user()->id)->orWhereRaw('customer_assigned_to =' . Auth::user()->id . ')')->first();
            $employee_ids = [Auth::user()->id];
            $auth_child_employees = Auth::user()->child_employees;
            if(count($auth_child_employees) > 0){
                foreach ($auth_child_employees as $employee) {
                    array_push($employee_ids,$employee->id);
                }
            }
            $lead_details = CustomerLeadProfile::where('id', $lead_id)->where('isLead',1)->first();
            // check if the lead details should be shown
            if(!in_array($lead_details->employee_id,$employee_ids)){
                if(!in_array($lead_details->customer_assigned_to,$employee_ids)){
                    abort(404);
                }
            }
        }
        
        // dd($lead_details);
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        return view('manage-leads.view-lead', [
            'app_modules' => $modules,
            'module_access' => $module_access,
            'lead_details' => $lead_details,
            'lead_id' => $lead_id,
        ]);
    }

    //method to edit lead
    public function edit_lead($lead_id)
    {
        if (Auth::user()->role_id == config('constants.director_role_id')) {
            $lead_details = CustomerLeadProfile::where('id', $lead_id)->where('isLead',1)->first();
            $my_employees = User::where('isActive', 1)->get();
        } else {
            // $lead_details = CustomerLeadProfile::where('id', $lead_id)->where('isLead', 1)->whereRaw('(employee_id =' . Auth::user()->id)->orWhereRaw('customer_assigned_to =' . Auth::user()->id . ')')->first();
            $employee_ids = [Auth::user()->id];
            $auth_child_employees = Auth::user()->child_employees;
            if(count($auth_child_employees) > 0){
                foreach ($auth_child_employees as $employee) {
                    array_push($employee_ids,$employee->id);
                }
            }
            $lead_details = CustomerLeadProfile::where('id', $lead_id)->where('isLead',1)->first();

            // check if the lead details should be shown
            if(!in_array($lead_details->employee_id,$employee_ids)){
                if(!in_array($lead_details->customer_assigned_to,$employee_ids)){
                    abort(404);
                }
            }
            $my_employees = $auth_child_employees->where('isActive', 1);
        }

        $employee_module_access = 0;
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);

        $employee_module_access = RoleModule::where('role_id', Auth::user()->role_id)->where('module_id', config('constants.manage_employee'));

        if ($employee_module_access->first()) {
            $employee_module_access = $employee_module_access->first('modify_access')->modify_access;
        } else {
            $employee_module_access = null;
        }

        if ($lead_details->customer_address) {

            $lead_address = explode('__', $lead_details->customer_address);
        } else {

            $lead_address = ["", "", "", "", "", ""];
        }

        if ($lead_details->office_address) {

            $office_address = explode('__', $lead_details->office_address);
        } else {

            $office_address = ["", "", "", "", "", ""];
        }

        $states = States::all();
        // dd($employee_module_access);
        return view('manage-leads.edit-lead', [
            'app_modules' => $modules,
            'module_access' => $module_access,
            'lead_details' => $lead_details,
            'my_employees' => $my_employees,
            'employee_module_access' => $employee_module_access,
            'lead_address' => $lead_address,
            'office_address' => $office_address,
            'states' => $states
        ]);
    }

    //method to update lead
    public function update_lead($lead_id, Request $request)
    {
        // dd($request);
        $validated = $request->validate([
            "lead_name" => "required|max:255",
            "lead_owner_name" => "required|max:255",
            "lead_type" => "required",
            "lead_assigned_to" => "required",
            "lead_web" => "nullable|max:100",
            "lead_no_1" => "required|numeric",
            "lead_no_2" => "nullable|numeric",
            "lead_gst_no" => ["required","regex:/^(NA|[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1})$/"],
            "lead_mail_1" => "nullable|email|unique:customer_lead_profile,customer_mail," . $lead_id,
            "lead_mail_2" => "nullable|email|unique:customer_lead_profile,customer_mail2," . $lead_id,
            "lead_manager_name" => "nullable|max:30",
            "lead_manager_number" => "nullable|numeric",
            "lead_accountant_name" => "nullable|max:30",
            "lead_accountant_number" => "nullable|numeric",
            "lead_district" => "required|max:30",
            "lead_state" => "required",
            "lead_taluka" => "required|max:30",
            "lead_pin_code" => "required|numeric",
            "lead_country" => "nullable|max:30",
            "lead_office_country" => "nullable|max:30",
            "lead_office_state" => "nullable",
            "lead_office_district" => "nullable|max:30",
            "lead_office_taluka" => "nullable|max:30",
            "lead_office_pin_code" => "nullable|numeric",
            "address_line_1" => "required|max:30",
            "address_line_2" => "required|max:30",
            "address_line_3" => "nullable|max:30",
            "address_line_4" => "nullable|max:30",
            "address_line_5" => "nullable|max:30",
            "address_line_6" => "nullable|max:30",
            "o_address_line_1" => "nullable|max:30",
            "o_address_line_2" => "nullable|max:30",
            "o_address_line_3" => "nullable|max:30",
            "o_address_line_4" => "nullable|max:30",
            "o_address_line_5" => "nullable|max:30",
            "o_address_line_6" => "nullable|max:30",
            "lead_status" => "required",
        ],[
            "lead_gst_no.regex" => "You have entered an invalid GST NO."
        ]);

        //validate the request lead nos
        $lead_no_1 = $request->lead_no_1;
        $lead_no_2 = $request->lead_no_2;
        // dd(!empty($lead_no_2));

        $unique_check_1 = CustomerLeadProfile::where('id', '!=', $lead_id)->where('customer_no1', $lead_no_1)->orWhereRaw("customer_no2 = " . $lead_no_1)->get();


        if (!empty($lead_no_2)) {
            $unique_check_2 = CustomerLeadProfile::where('id', '!=', $lead_id)->WhereRaw('(customer_no1 =' . $lead_no_2)->orWhereRaw("customer_no2 = " . $lead_no_2 . ")")->get();
        } else {
            $unique_check_2 = [];
        }

        if (count($unique_check_1) != 0 || count($unique_check_2) != 0) {
            return back()->withErrors(["message" => "One of lead contact already exists."])->withInput($request->all());
        }

        //save the lead data to the database
        $lead_info = CustomerLeadProfile::update_lead($lead_id, $request);

        return redirect()->route('viewProfile_leads', $lead_id);
    }
}
