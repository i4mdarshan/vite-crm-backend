<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\AppModules;
use App\Models\Firms;
use App\Models\RoleModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class FirmsController extends Controller
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

    //method to show firms list
    public function show_firms()
    {
        if(isset($_GET['q'])){
            $all_firms = Firms::search(trim($_GET['q']))->get(); 
        }else{
            $all_firms = Firms::get_all_firms();
        }
        
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        return view('manage-firms.list-firms',[
            'all_firms' => $all_firms,
            'app_modules' => $modules,
            'module_access' => $module_access,
        ]);
    }

    //method to edit firm
    public function edit_firm($firm_id)
    {
        $firm_details = Firms::findOrFail($firm_id);

        if ($firm_details->firm_address) {

            $firm_address_lines = explode('__',$firm_details->firm_address);
        } else {
            
            $firm_address_lines = ["","","","","",""];
        }

        // dd($firm_address_lines);
        $modules = RoleModule::get_active_modules_by_role_id();
        return view('manage-firms.edit-firm',[
            'app_modules' => $modules,
            'firm_details' => $firm_details,
            'firm_address_lines' => $firm_address_lines,
        ]);
    }

    //method to update firm details
    public static function update_firm(Request $request)
    {
        $validated = $request->validate([
            'firm_id' => 'required|exists:firms,id',
            'firm_name' => 'required|max:40',
            'firm_owner_name' => 'required|max:40',
            'firm_email' => 'required|email|max:50',
            'firm_address_line_1' => 'required|max:30',
            'firm_address_line_2' => 'required|max:30',
            'firm_address_line_3' => 'required|max:30',
            'firm_address_line_4' => 'required|max:30',
            'firm_address_line_5' => 'required|max:30',
            'firm_address_line_6' => 'required|max:30',
            'firm_gst_no' => 'required|alpha_num',
            'firm_contact_no' => 'required',
            'firm_bank_name' => 'required|max:50',
            'firm_bank_account_no' => 'required|numeric',
            'firm_bank_ifsc_code' => 'required|alpha_num',
            'firm_bank_branch_name' => 'required|max:50',
            // 'signatory_image' => 'required|image|mimes:png,jpg,jpeg|max:2048|dimensions:ratio=1/1',
        ]);
        
        // dd($request);
        $firm_updated = Firms::update_firm($request);

        return redirect()->route('edit_firms',$request->firm_id);
    }
}
