<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\Helper;
use App\Models\AppModules;
use Illuminate\Support\Facades\Route;
use App\Models\RoleModule;
use App\Models\User;
use App\Models\States;
use App\Rules\ValidateCustomerNumber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\CustomerLeadProfile;
use App\Models\Firms;;


class CustomerController extends Controller
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
        return $this->module_info->id;
    }


    //method to list customers 
    public function show_customers()
    {
        // if (Auth::user()->role_id == config('constants.director_role_id')) {
        //     if (isset($_GET['q'])) {
        //         $all_customers = CustomerLeadProfile::search(trim($_GET['q']))->orderBy('created', 'DESC')->paginate(10);
        //     } else {
        //         $all_customers = CustomerLeadProfile::where('isLead', 0)->where('firm_id', Auth::user()->firm_id)->where('isActive', 1)->orderBy('created', 'DESC')->paginate(15);
        //     }
        // } else {
        //     // $employee_ids = "(".Auth::user()->id;
        //     $employee_ids = [Auth::user()->id];
        //     $auth_child_employees = Auth::user()->child_employees;
        //     if (count($auth_child_employees) > 0) {
        //         foreach ($auth_child_employees as $employee) {
        //             array_push($employee_ids, $employee->id);
        //         }
        //     }
        //     // $employee_ids.=")";
        //     // dd($employee_ids);
        //     // dd(CustomerLeadProfile::whereRaw('(employee_id in ? or customer_assigned_to = ?)',[$employee_ids,Auth::user()->id])->where('isLead',0)->orderBy('created', 'DESC')->toSql());

        //     $all_customers = CustomerLeadProfile::whereIn('employee_id', $employee_ids)->orWhereIn('customer_assigned_to', $employee_ids)->where('isLead', 0)->orderBy('created', 'DESC')->paginate(15);
        // }

        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);

        if (isset($_GET['q'])) {
            $search_query = trim($_GET['q']);
            $all_customers = CustomerLeadProfile::get_leads_customers_data($isLead = 0,$search_by = $search_query);
        } else {
            $all_customers = CustomerLeadProfile::get_leads_customers_data($isLead = 0);
        }

        return view('manage-customers.list-customers', [
            'app_modules' => $modules,
            'module_access' => $module_access,
            'all_customers' => $all_customers->paginate(15)->onEachSide(1)->withQueryString(),
        ]);
    }

    //method to add customers
    public function add_customers()
    {
        if (Auth::user()->role_id == config('constants.director_role_id')) {
            $my_employees = User::where('isActive', 1)->get();
        } else {
            $my_employees = User::where('added_by', Auth::user()->id)->where('isActive', 1)->get();
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

        return view('manage-customers.add-customers', [
            'my_employees' => $my_employees,
            'app_modules' => $modules,
            'module_access' => $module_access,
            'employee_module_access' => $employee_module_access,
            'states' => $states
        ]);
    }

    //method to save customer
    public function save_customers(Request $request)
    {
        // validate the form data
        $validated = $request->validate([
            "customer_name" => "required|max:255",
            "customer_owner_name" => "required|max:255",
            "customer_gst_no" => ["required","regex:/^(NA|[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1})$/"],
            "customer_type" => "required",
            "customer_assigned_to" => "required",
            "customer_web" => "nullable|max:1000",
            "customer_no1" => "required|numeric",
            "customer_no2" => "nullable|numeric",
            "customer_mail" => "nullable|email|max:50|unique:customer_lead_profile,customer_mail",
            "customer_mail2" => "nullable|email|max:50|unique:customer_lead_profile,customer_mail2",
            "manager_name" => "nullable|max:30",
            "manager_number" => "nullable|numeric",
            "accountant_name" => "nullable|max:30",
            "accountant_number" => "nullable|numeric",
            "customer_country" => "nullable|max:30",
            "customer_state" => "required",
            "customer_district" => "required|max:30",
            "customer_taluka" => "required|max:30",
            "customer_pin_code" => "required|numeric",
            "office_country" => "nullable|max:30",
            "office_state" => "nullable",
            "office_district" => "nullable|max:30",
            "office_taluka" => "nullable|max:30",
            "office_pin_code" => "nullable|numeric",
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
            "customer_notes" => "nullable|max:1500",
            "isActive" => "required",
        ],[
            "customer_gst_no.regex" => "You have entered an invalid GST NO."
        ]);



        //validate the request customer nos
        $customer_no1 = $request->customer_no1;
        $customer_no2 = $request->customer_no2;

        $unique_check_1 = CustomerLeadProfile::where('customer_no1', $customer_no1)->orWhereRaw("customer_no2 = " . $customer_no1)->get();
        if (!empty($customer_no2)) {
            $unique_check_2 = CustomerLeadProfile::where('customer_no1', $customer_no2)->orWhereRaw("customer_no2 = " . $customer_no2)->get();
        } else {
            $unique_check_2 = [];
        }

        // dd($request);

        if (count($unique_check_1) != 0 || count($unique_check_2) != 0) {
            return back()->withErrors(["message" => "One of Customer Phone 1 or Customer Phone 2 already exists."])->withInput($request->all());
        }

        //save the customer data to the database
        $customer_info = CustomerLeadProfile::add_customers($request, Auth::user()->id);

        return redirect()->route('viewProfile_customers', $customer_info->id);
    }

    // method to view customer detail
    public function view_customer($customer_id)
    {
        // dd($customer_id);
        if (Auth::user()->role_id == config('constants.director_role_id')) {
            $customer_details = CustomerLeadProfile::where('id', $customer_id)->first();
        } else {
            // Previous list query
            // $customer_details = CustomerLeadProfile::where('id', $customer_id)->where('isLead',0)->whereRaw('(employee_id ='.Auth::user()->id)->orWhereRaw('customer_assigned_to ='.Auth::user()->id.')')->first();

            $employee_ids = [Auth::user()->id];
            $auth_child_employees = Auth::user()->child_employees;
            if (count($auth_child_employees) > 0) {
                foreach ($auth_child_employees as $employee) {
                    array_push($employee_ids, $employee->id);
                }
            }
            $customer_details = CustomerLeadProfile::where('id', $customer_id)->where('isLead', 0)->first();
            // check if the lead details should be shown
            if (!in_array($customer_details->employee_id, $employee_ids)) {
                if (!in_array($customer_details->customer_assigned_to, $employee_ids)) {
                    abort(404);
                }
            }
        }

        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        return view('manage-customers.view-customers', [
            'app_modules' => $modules,
            'customer_details' => $customer_details,
            'module_access' => $module_access,
            'customer_id' => $customer_id,
        ]);
    }

    //method to edit customer
    public function edit_customer($customer_id)
    {
        if (Auth::user()->role_id == config('constants.director_role_id')) {
            $customer_details = CustomerLeadProfile::where('id', $customer_id)->where('isLead', 0)->first();
            $my_employees = User::where('isActive', 1)->get();
        } else {
            // $customer_details = CustomerLeadProfile::where('id', $customer_id)->where('isLead',0)->where('isActive',1)->whereRaw('(employee_id ='.Auth::user()->id)->orWhereRaw('customer_assigned_to ='.Auth::user()->id.')')->first();

            $employee_ids = [Auth::user()->id];
            $auth_child_employees = Auth::user()->child_employees;
            if (count($auth_child_employees) > 0) {
                foreach ($auth_child_employees as $employee) {
                    array_push($employee_ids, $employee->id);
                }
            }
            $customer_details = CustomerLeadProfile::where('id', $customer_id)->where('isLead', 0)->first();
            // check if the lead details should be shown
            if (!in_array($customer_details->employee_id, $employee_ids)) {
                if (!in_array($customer_details->customer_assigned_to, $employee_ids)) {
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

        if ($customer_details->customer_address) {

            $customer_address = explode('__', $customer_details->customer_address);
        } else {

            $customer_address = ["", "", "", "", "", ""];
        }

        if ($customer_details->office_address) {

            $office_address = explode('__', $customer_details->office_address);
        } else {

            $office_address = ["", "", "", "", "", ""];
        }

        $states = States::all();

        return view('manage-customers.edit-customer', [
            'app_modules' => $modules,
            'module_access' => $module_access,
            'customer_details' => $customer_details,
            'my_employees' => $my_employees,
            'employee_module_access' => $employee_module_access,
            'customer_address' => $customer_address,
            'office_address' => $office_address,
            'states' => $states
        ]);
    }

    //method to update customer
    public function update_customer($customer_id, Request $request)
    {
        $customer_details = CustomerLeadProfile::findOrFail($customer_id);
        $validated = $request->validate([
            "customer_name" => "required|max:255",
            "customer_owner_name" => "required|max:255",
            "customer_gst_no" => ["required","regex:/^(NA|[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1})$/"],
            "customer_type" => "required",
            "customer_assigned_to" => ($customer_details->employee_id == Auth::user()->id) ? "required" : "nullable",
            "customer_website" => "nullable|max:1000",
            "customer_no1" => "required|numeric|different:customer_no2",
            "customer_no2" => "nullable|numeric|different:customer_no1",
            "customer_mail" => "nullable|email|max:50|unique:customer_lead_profile,customer_mail," . $customer_id,
            "customer_mail2" => "nullable|email|max:50|unique:customer_lead_profile,customer_mail2," . $customer_id,
            "manager_name" => "nullable|max:30",
            "manager_number" => "nullable|numeric",
            "accountant_name" => "nullable|max:30",
            "accountant_number" => "nullable|numeric",
            "customer_country" => "nullable|max:30",
            "customer_state" => "required",
            "customer_district" => "required|max:30",
            "customer_taluka" => "required|max:30",
            "customer_pin_code" => "required|numeric",
            "office_country" => "nullable|max:30",
            "office_state" => "nullable",
            "office_district" => "nullable|max:30",
            "office_taluka" => "nullable|max:30",
            "office_pin_code" => "nullable|numeric",
            "office_country" => "nullable|max:30",
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
            "customer_notes" => "nullable|max:1500",
            "isActive" => "required",

        ], [
            "customer_no1.different" => "The customer no. 1 and customer no. 2 must be different.",
            "customer_no2.different" => "The customer no. 2 and customer no. 1 must be different.",
            "customer_mail.different" => "The customer email 1 and customer email 2 must be different.",
            "customer_mail2.different" => "The customer email 2 and customer email 1 must be different.",
            "customer_gst_no.regex" => "You have entered an invalid GST NO."
        ]);

        //validate the request customer nos
        $customer_no1 = $request->customer_no1;
        $customer_no2 = $request->customer_no2;


        if (!empty($customer_no2)) {
            $unique_check_1 = CustomerLeadProfile::where('id', '!=', $customer_id)->whereRaw("('customer_no1' = " . $customer_no1 . " OR 'customer_no2' = " . $customer_no2 . ")")->get();
            $unique_check_2 = CustomerLeadProfile::where('id', '!=', $customer_id)->whereRaw("('customer_no1' = " . $customer_no2 . " OR 'customer_no2' = " . $customer_no1 . ")")->get();
        } else {
            $unique_check_1 = CustomerLeadProfile::where('id', '!=', $customer_id)->where('customer_no1', $customer_no1)->get();
            $unique_check_2 = [];
        }

        // dd($customer_id,$unique_check_1,$unique_check_2);

        if (count($unique_check_1) != 0 || count($unique_check_2) != 0) {
            return back()->withErrors(["message" => "One of Customer Phone 1 or Customer Phone 2 already exists."])->withInput($request->all());
        }

        //save the customer data to the database
        $customer_info = CustomerLeadProfile::update_customer($customer_id, $request);

        return redirect()->route('viewProfile_customers', $customer_info->id);
    }
}
