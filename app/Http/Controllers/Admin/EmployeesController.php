<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\AppModules;
use App\Models\Firms;
use App\Models\RoleModule;
use App\Models\User;
use App\Models\UserDetails;
use App\Models\UserRoles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EmployeesController extends Controller
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

    //function to show all the employees
    public function show_employees()
    {   
        // dd(Auth::user()->child_employees);
        
        if(Auth::user()->role_id == config('constants.director_role_id')){
            if (isset($_GET['q'])) {
                $all_employees = User::search(trim($_GET['q']))->paginate(15)->onEachSide(1)->withQueryString();
            }else{
            $all_employees = User::paginate(15)->onEachSide(1)->withQueryString();
            }
        }else{
                $all_employees = User::where('firm_id',Auth::user()->firm_id)->where('added_by', Auth::user()->id)->paginate(15)->onEachSide(1)->withQueryString();
        }
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        $modules = RoleModule::get_active_modules_by_role_id();
        return view('manage-employees.list-employees',[
            'app_modules' => $modules,
            'all_employees' => $all_employees,
            'module_access' => $module_access,
        ]);
    }

    //function to view employee
    public function view_employee($user_id)
    {   
        
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        $modules = RoleModule::get_active_modules_by_role_id();
        $employee_info = User::findOrFail($user_id);
        return view('manage-employees.view-employee',[
            'app_modules' => $modules,
            'employee_info' => $employee_info,
            'module_access' => $module_access,
        ]);
    }

    //function to add employee
    public static function add_employee()
    {
        $modules = RoleModule::get_active_modules_by_role_id();
        $all_employees = User::where('isActive',1)->get();
        $all_active_roles = UserRoles::where('isActive',1)->get();
        $firms = Firms::all();
        return view('manage-employees.add-employee',[
            'app_modules' => $modules,
            'all_employees' => $all_employees,
            'all_active_roles' => $all_active_roles,
            'firms' => $firms,
        ]);
    }

    //function to save employee
    public static function save_employee(Request $request)
    {

        $validate_added_by = (Auth::user()->role_id != 1) ? "required|in:".Auth::user()->id : "required";

        //please check phone number verification in detail
        $validated = $request->validate([
            "full_name" => "required|max:40",
            "email" => "required|max:50|email|unique:users,email",
            "user_role" => "required",
            "added_by" => $validate_added_by,
            "user_firm" => "required|exists:firms,id",
            "password" => "required|min:6|confirmed",
            "personal_phone_no_1" => "required|digits:10|unique:user_details,personal_phone_no_1",
            "personal_phone_no_2" => "nullable|digits:10|unique:user_details,personal_phone_no_2",
            "father_phone_no" => "nullable|digits:10|unique:user_details,father_phone_no",
            "mother_phone_no" => "nullable|digits:10|unique:user_details,mother_phone_no",
            "wife_phone_no" => "nullable|digits:10|unique:user_details,wife_phone_no",
            "others_phone_no" => "nullable|digits:10|unique:user_details,others_phone_no",
            "current_address" => "required|max:150",
            "permanent_address" => "required|max:150",
            "accessories" => "nullable|mimes:jpg,jpeg,png,pdf,docx|max:2048",
            "joining_date" => "required|before_or_equal:".date('Y-m-d'),
            "profile_image" => "nullable|mimes:jpg,jpeg,png|max:2048",
            "joining_letter" => "nullable|mimes:jpg,jpeg,png,pdf,docx|max:2048",
        // status
        ]);

        // dd($request,$request->hasFile('profile_image'));
        $add_basic_details = User::add_user($request);

        $add_employee_details = UserDetails::add_user_details($add_basic_details->id, $request);

        return redirect()->route('manage_employee');
    }

    //method to edit Employee
    public function edit_employee($user_id)
    {
        $employee_details = User::where('id', $user_id)->first();
        // dd($employee_details);
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        $all_active_roles = UserRoles::where('isActive',1)->get();
        $firms = Firms::all();
        $all_employees = User::where('isActive',1)->get();
        return view('manage-employees.edit-employee',[
            'app_modules' => $modules,
            'module_access' => $module_access,
            'employee_details' => $employee_details,
            'all_active_roles' => $all_active_roles,
            'all_employees' => $all_employees,
            'firms' => $firms,
        ]);
    }

    //method to update Employees
    public function update_employee($user_id, Request $request)
    {
        // validate
        // dd($request);
        $validated = $request->validate([
            "full_name" => "required|max:40",
            "email" => "required|email|max:50|unique:users,email,".$user_id,
            "user_role" => "required",
            "password" => "nullable|min:6|confirmed",
            "personal_phone_no_1" => "required|digits:10|unique:user_details,personal_phone_no_1,".$user_id.",employee_id",
            "personal_phone_no_2" => "nullable|digits:10|unique:user_details,personal_phone_no_2,".$user_id.",employee_id",
            "father_phone_no" => "nullable|digits:10|unique:user_details,father_phone_no,".$user_id.",employee_id",
            "mother_phone_no" => "nullable|digits:10|unique:user_details,mother_phone_no,".$user_id.",employee_id",
            "wife_phone_no" => "nullable|digits:10|unique:user_details,wife_phone_no,".$user_id.",employee_id",
            "others_phone_no" => "nullable|digits:10|unique:user_details,others_phone_no,".$user_id.",employee_id",
            "current_address" => "required|max:150",
            "permanent_address" => "required|max:150",
            "accessories" => "nullable|mimes:jpg,jpeg,png,pdf,docx|max:2048",
            "joining_date" => "required|before_or_equal:".date('Y-m-d'),          
            "profile_image" => "nullable|mimes:jpg,jpeg,png|max:2048",
            "joining_letter" => "nullable|mimes:jpg,jpeg,png,pdf,docx|max:2048",
        ]);

        $employees_info = User::update_employees($user_id,$request);
        $update_employee_details = UserDetails::update_user_details($employees_info->id, $request);

        return redirect()->route('view_employee', [$update_employee_details->employee_id]);
    }

    //method to deactivate employee access
    public static function deactivate_employee($user_id)
    {
        $deactivate_employee = User::deactivate_employee($user_id);

        return redirect()->route('manage_employee');
    }
    
}
