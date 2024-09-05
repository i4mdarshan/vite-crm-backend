<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\AppModules;
use App\Models\CustomerLeadNotes;
use App\Models\RoleModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


class CustomerNotesController extends Controller
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

    //method to view notes
    public function list_customer_notes($customer_id)
    {
        if(isset($_GET['q'])){
            $customer_notes = CustomerLeadNotes::search(trim($_GET['q']),$customer_id)->paginate(10)->onEachSide(1)->withQueryString(); 
        }else{
            $customer_notes = CustomerLeadNotes::where('customer_id', $customer_id)->paginate(10)->onEachSide(1)->withQueryString();
        }
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        return view('manage-customers.customer-notes.list-notes',[
            'app_modules' => $modules,
            'module_access' => $module_access,
            'customer_id' => $customer_id,
            'customer_notes' => $customer_notes,
        ]);
    }

    //method to add bote
    public function add_customer_note($customer_id)
    {
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        return view('manage-customers.customer-notes.add-note',[
            'app_modules' => $modules,
            'module_access' => $module_access,
            'customer_id' => $customer_id,
        ]);
    }

    //method to save note
    public function save_customer_note($customer_id, Request $request)
    {
        $validated = $request->validate([
            'notes_date' => 'required|after_or_equal:today',
            'notes_time' => 'required',
            'notes_description' => 'required|max:1500',
        ]);
        $employee_id = Auth::user()->id;
        $note_info = CustomerLeadNotes::add_note($employee_id,$customer_id,$request);

        return redirect()->route('viewNoteDetails_customers',['note_id' => $note_info->id, 'customer_id' => $customer_id]);
    }

    //method to view customer note
    public function view_customer_note($customer_id, $note_id)
    {
        $note_info = CustomerLeadNotes::where('id', $note_id)->where('customer_id', $customer_id)->first();
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        return view('manage-customers.customer-notes.view-note',[
            'app_modules' => $modules,
            'module_access' => $module_access,
            'customer_id' => $customer_id,
            'note_info' => $note_info,
        ]);
    }

}
