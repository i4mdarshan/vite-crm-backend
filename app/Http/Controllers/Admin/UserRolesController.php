<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\AppModules;
use App\Models\RoleModule;
use App\Models\UserRoles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class UserRolesController extends Controller
{
    //
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

    //method to show user roles
    public function show_roles()
    {
        $all_roles = UserRoles::get_all_user_roles();
        $modules = RoleModule::get_active_modules_by_role_id();
        // dd($modules);
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        return view('manage-roles.list-roles',[
            'all_roles' => $all_roles,
            'app_modules' => $modules,
            'module_access' => $module_access,
        ]);
    }


    public function add_role()
    {
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);  
        if($module_access[0] == 0){
            return redirect('access_forbidden');
        }

        $modules = RoleModule::get_active_modules_by_role_id();
        $active_modules = AppModules::get_active_modules();
        
        return view('manage-roles.add-role', ['app_modules'=> $modules, 'active_modules' => $active_modules]);
    }

    public static function save_role(Request $request)
    {
        // dd($request);

        //validation required
        $validated = $request->validate([
            "role_name" => "required|unique:user_roles,role_name|max:40",
            "role_status" => "required",
            "module_id" => "required",
            "module_permission" => "required",
            "module_permission.*" => "required_with:module_id",
        ],[
            "module_permission.*.required_with" => "Please select permission for this module.",
            "role_status.required" => "Please select role status.",
            "role_name.unique" => "This role already exists.",
        ]);

        $modules = RoleModule::get_active_modules_by_role_id();
        $all_roles = UserRoles::get_all_user_roles(0);
        $add_role = UserRoles::add_user_roles($request);
        $role_id = $add_role->id;
        if($role_id){

            $i=0;
            foreach($request->module_id as $module_id){
                RoleModule::add_role_module($role_id, $module_id, $request->module_permission[$i]);
                $i++;
            }

            return redirect()->route('manage_roles', 
            ['app_modules' => $modules,
            'all_roles' => $all_roles]);

        }else{
            //error 
        }
    }


    //emthod to edit user role
    public function edit_role($role_id)
    {   
        // $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);  
        // if($module_access[0] == 0){
        //     return redirect('access_forbidden');
        // }

        $modules = RoleModule::get_active_modules_by_role_id();
        $active_modules = AppModules::get_active_modules();
        $role_details = UserRoles::get_user_role_details($role_id);

        // prepare for active module ids and its modify access
        $selected_module_ids = [];
        $selected_module_ids_modify_access = [];

        foreach ($role_details->modules as $key => $role_detail) {
            $selected_module_ids[] = $role_detail->module_id;
            $selected_module_ids_modify_access[] = $role_detail->modify_access;
        }

        //error in updating the role module access

        return view('manage-roles.edit-role', 
        ['app_modules' => $modules,
        'role_details' => $role_details,
        'selected_module_ids' => $selected_module_ids,
        'selected_module_ids_modify_access' => $selected_module_ids_modify_access,
        'active_modules' => $active_modules]);
    }


    public static function update_role(Request $request, $role_id)
    {
        $old_user_role = UserRoles::findOrFail($role_id);
        // dd($old_user_role);
        $old_user_role_modules = RoleModule::where('role_id',$role_id)->get();
        $updated_module_ids =[];
        $updated_module_id_modify_access = [];
        $updated_module_ids = $request->module_id;
        $updated_module_id_modify_access = $request->module_permissions;
        $validated = $request->validate([
            "role_name" => "required|string||max:40|unique:user_roles,role_name,".$old_user_role->id,
            "role_status" => "required",
            "module_id" => "required",
            "module_permission" => "required",
            "module_permission.*" => "required_with:module_id"
        ],[
            "module_permission.*.required_with" => "Please select permission for this module.",
            "role_status.required" => "Please select role status.",
            "role_name.unique" => "This role already exists.",
        ]);

        // dd($request);
        //update user role
        UserRoles::update_user_role($request,$role_id);

        //delete old add new
        foreach ($old_user_role_modules as $role_module) {
            RoleModule::delete_role_module($role_module->role_id, $role_module->module_id);
        }

        //add role module
        $i=0;
            foreach($request->module_id as $module_id){
                RoleModule::add_role_module($role_id, $module_id, $request->module_permission[$i]);
                $i++;
            }

        $modules = RoleModule::get_active_modules_by_role_id();
        $all_roles = UserRoles::get_all_user_roles(0);
        return redirect()->route('manage_roles', 
            ['app_modules' => $modules,
            'all_roles' => $all_roles]);

    }
}
