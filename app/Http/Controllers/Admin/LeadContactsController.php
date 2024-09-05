<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\AppModules;
use App\Models\CustomerLeadContacts;
use App\Models\RoleModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class LeadContactsController extends Controller
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

    //method to view lead contacts
    public function view_lead_contacts($lead_id)
    {   
        if(isset($_GET['q'])){
            $lead_contact_details = CustomerLeadContacts::search(trim($_GET['q']),$lead_id)->paginate(10)->onEachSide(1)->withQueryString(); 
        }else{
            $lead_contact_details = CustomerLeadContacts::where('customer_id', $lead_id)->paginate(10)->onEachSide(1)->withQueryString();
        }
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        return view('manage-leads.lead-contacts.list-lead-contacts',[
            'app_modules' => $modules,
            'module_access' => $module_access,
            'lead_id' => $lead_id,
            'lead_contact_details' =>$lead_contact_details,
        ]);
    }

    //method to view lead contact detail
    public function view_lead_contact_detail($lead_id, $contact_id)
    {
        $contact_details = CustomerLeadContacts::where('id',$contact_id)->where('customer_id', $lead_id)->first();
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        return view('manage-leads.lead-contacts.view-lead-contact',[
            'app_modules' => $modules,
            'module_access' => $module_access,
            'lead_id' => $lead_id,
            'contact_details' => $contact_details,
        ]);
    }

    //method to add lead contacts
    public function add_lead_contacts($lead_id)
    {
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        return view('manage-leads.lead-contacts.add-lead-contacts',[
            'app_modules' => $modules,
            'module_access' => $module_access,
            'lead_id' => $lead_id,
        ]);
    }

    //method to save lead contacts
    public function save_lead_contacts($lead_id, Request $request)
    {
        // validate
        $validated = $request->validate([
            'person_name' => 'required|max:255',
            'phone_number' => 'required|digits:10|unique:customer_lead_contacts,contact_number',
            'designation' => 'required|max:30',
            'person_email' => 'required|email|max:50|unique:customer_lead_contacts,contact_email',
            'contact_status' => 'required',
            'contact_notes' => 'nullable|max:1500',
            'contact_image' => 'nullable|mimes:jpg,jpeg,png|max:2048'
        ]);

        //Jinal first commit

        $contact_info = CustomerLeadContacts::add_contact($lead_id, Auth::user()->id, $request);

        return redirect()->route('viewContactDetails_leads', ['lead_id' => $lead_id, 'contact_id' => $contact_info->id]);
    }

    //method to edit lead contact detail
    public function edit_lead_contact($lead_id, $contact_id)
    {
        $contact_details = CustomerLeadContacts::where('id',$contact_id)->where('customer_id', $lead_id)->first();
        $modules = RoleModule::get_active_modules_by_role_id();
        $module_access = Helper::get_module_access($this->getModuleId(), Auth::user()->role_id);
        return view('manage-leads.lead-contacts.edit-lead-contact',[
            'app_modules' => $modules,
            'module_access' => $module_access,
            'lead_id' => $lead_id,
            'contact_details' => $contact_details,
        ]);
    }


    //method to update lead contacts
    public function update_lead_contact($lead_id, $contact_id, Request $request)
    {
        // validate
        // dd($request);
        $validated = $request->validate([
            'person_name' => 'required|max:255',
            'phone_number' => 'required|digits:10|unique:customer_lead_contacts,contact_number,'.$contact_id,
            'designation' => 'required|max:30',
            'person_email' => 'required|email|max:50|unique:customer_lead_contacts,contact_email,'.$contact_id,
            'contact_status' => 'required',
            'contact_notes' => 'nullable|max:1500',
            'contact_image' => 'nullable|mimes:jpg,jpeg,png|max:2048'
        ]);

        $contact_info = CustomerLeadContacts::update_contact($contact_id, $request);

        return redirect()->route('viewContactDetails_leads', ['lead_id' => $lead_id, 'contact_id' => $contact_id]);
    }
}
