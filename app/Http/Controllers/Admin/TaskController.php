<?php

namespace App\Http\Controllers\Admin;
//Need to add 


use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\AppModules;
use App\Models\RoleModule;
use App\Models\ManageTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\User;

class TaskController extends Controller
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMyTask()
    {

        $my_tasks = ManageTask::get_my_tasks(Auth::user()->id);
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        return view('manage-tasks.list-my-tasks', [
            'app_modules' => $modules,
            'module_access' => $module_access,
            'my_tasks' => $my_tasks,
        ]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAssginedTask()
    {
        if (isset($_GET['q'])) {
            $assigned_tasks = ManageTask::search(trim($_GET['q']))->paginate(10)->onEachSide(1)->withQueryString();
        } else {
            $assigned_tasks = ManageTask::get_assigned_tasks(Auth::user()->id);
        }
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        return view('manage-tasks.list-assgined-tasks', [
            'app_modules' => $modules,
            'module_access' => $module_access,
            'assigned_tasks' => $assigned_tasks,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addtask(Request $request)
    {
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        return view('manage-tasks.add-tasks', [
            'app_modules' => $modules,
            'module_access' => $module_access,
        ]);
    }

    public function save_tasks(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            "task_title" => "required|max:255",
            "task_assigned_by" => "required",
            "task_assigned_to" => "required",
            "task_description" => "required|max:4000",
            "task_status" => "required",
        ]);



        ManageTask::addtask($request);

        return redirect()->route('assigned_tasks');
    }

    public function view_tasks($id)
    {
        $task_info = ManageTask::findOrFail($id);
        $modules = RoleModule::get_active_modules_by_role_id();
        return view('manage-tasks.view-task-detail', [
            'app_modules' => $modules,
            'task_info' => $task_info,
        ]);
    }

    public function forward_tasks($id)
    {
        $task_info = ManageTask::findOrFail($id);
        $modules = RoleModule::get_active_modules_by_role_id();
        return view('manage-tasks.forward-task-details', [
            'app_modules' => $modules,
            'task_info' => $task_info,
        ]);
    }

    public function edit_task($id)
    {
        $my_employees = User::where('isActive', 1)->get();
        $task_info = ManageTask::findOrFail($id);
        $modules = RoleModule::get_active_modules_by_role_id();
        return view('manage-tasks.edit-assigned-task', [
            'app_modules' => $modules,
            'task_info' => $task_info,
            'my_employees' => $my_employees,
        ]);
    }

    public function edit_mytasks($id)
    {
        $task_info = ManageTask::findOrFail($id);
        $modules = RoleModule::get_active_modules_by_role_id();
        return view('manage-tasks.edit-my-task', [
            'app_modules' => $modules,
            'task_info' => $task_info,
        ]);
    }

    public static function update_task(request $request, $id)

    {

        $validated = $request->validate([
            "task_title" => "required|max:255",
            "task_assigned_by" => "required",
            "task_assigned_to" => "required",
            "task_description" => "required|max:4000",
            "task_status" => "required",
        ]);

        ManageTask::update_task($request, $id);

        return redirect()->route('assigned_tasks');
    }








    public static function delete_tasks($id)
    {
        ManageTask::where('id', $id)->delete();

        return redirect()->back();
    }

    //

}
